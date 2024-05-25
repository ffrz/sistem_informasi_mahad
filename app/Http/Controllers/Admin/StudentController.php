<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AclResource;
use App\Models\ProductCategory;
use App\Models\SchoolLevel;
use App\Models\SchoolStage;
use App\Models\Student;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function __construct()
    {
        // ensure_user_can_access(AclResource::PRODUCT_CATEGORY_MANAGEMENT);
    }

    public function index(Request $request)
    {
        $filter = [
            'search' => $request->get('search', ''),
            'stage_id' => $request->get('stage_id', ''),
            'level_id' => $request->get('level_id', ''),
            'status' => $request->get('status', Student::STATUS_ACTIVE),
        ];

        $query = Student::with('level', 'stage');
        if (!empty($filter['search'])) {
            $query->where('fullname', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('nis', 'like', '%' . $filter['search'] . '%');
        }
        if (!empty($filter['stage_id'])) {
            $query->where('students.stage_id', '=', $filter['stage_id']);
        }
        if (!empty($filter['stage_id']) && !empty($filter['level_id'])) {
            // reset if choosen level_id is not from existing stages
            $found = SchoolLevel::where('stage_id', '=', $filter['stage_id'])
                ->where('id', '=', $filter['level_id'])
                ->get();
            if (count($found) > 0) {
                // add where clause if exists
                $query->where('students.level_id', '=', $filter['level_id']);
            } else {
                // reset the filter
                $filter['level_id'] = '';
            }
        }
        if (!empty($filter['status'])) {
            $query->where('students.status', '=', $filter['status']);
        }
        $query->orderBy('stage_id', 'asc')
            ->orderBy('level_id', 'asc')
            ->orderBy('fullname', 'asc');

        $items = $query->paginate(10);
        $stages = SchoolStage::query()->orderBy('stage', 'asc')->get();
        $statuses = Student::statuses();

        $levels = [];
        if (!empty($filter['stage_id'])) {
            $levels = SchoolLevel::query()
                ->where('stage_id', '=', $filter['stage_id'])
                ->orderBy('level', 'asc')->get();
        }

        return view('admin.student.index', compact('items', 'stages', 'filter', 'levels', 'statuses'));
    }

    public function edit(Request $request, $id = 0)
    {
        $item = $id ? Student::find($id) : new Student();
        if (!$item)
            return redirect('admin/student')->with('warning', 'Santri tidak ditemukan.');

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'nis' => 'required|max:10',
                'fullname' => 'required',
                'stage_id' => 'required',
                'level_id' => 'required',
            ], [
                'nis.required' => 'Nomor induk harus diisi.',
                'fullname.required' => 'Nama lengkap santri harus diisi.',
                'stage_id.required' => 'Tingkat harus dipilih.',
                'level_id.required' => 'Kelas harus dipilih.'
            ]);

            if ($validator->fails())
                return redirect()->back()->withInput()->withErrors($validator);

            $data = ['Old Data' => $item->toArray()];
            $item->fill($request->all());
            $item->save();
            $data['New Data'] = $item->toArray();

            UserActivity::log(
                UserActivity::STUDENT_MANAGEMENT,
                ($id == 0 ? 'Tambah' : 'Perbarui') . ' Santri',
                'Santri ' . e($item->name) . ' telah ' . ($id == 0 ? 'dibuat' : 'diperbarui'),
                $data
            );

            return redirect('admin/student')->with('info', 'Data Santri telah disimpan.');
        }

        $stages = SchoolStage::query()->orderBy('stage', 'asc')->get();
        $levels = SchoolLevel::query()->orderBy('level', 'asc')->get();
        $levels_by_stages = [];
        foreach ($levels as $level) {
            $levels_by_stages[$level->stage_id][$level->id] = $level->name;
        }
        $statuses = Student::statuses();

        return view('admin.student.edit', compact('item', 'stages', 'levels', 'levels_by_stages', 'statuses'));
    }

    public function delete($id)
    {
        if (!$item = Student::find($id))
            $message = 'Santri tidak ditemukan.';
        else if ($item->delete($id)) {
            $message = 'Santri ' . e($item->name) . ' telah dihapus.';
            UserActivity::log(
                UserActivity::STUDENT_MANAGEMENT,
                'Hapus Santri',
                $message,
                $item->toArray()
            );
        }

        return redirect('admin/student')->with('info', $message);
    }
}
