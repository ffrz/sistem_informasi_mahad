<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolLevel;
use App\Models\SchoolStage;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SchoolLevelController extends Controller
{
    //
    public function index(Request $request)
    {
        $filter = [
            'stage_id' => $request->get('stage_id', ''),
        ];

        $query = SchoolLevel::query();
        if (!empty($filter['stage_id'])) {
            $query->where('stage_id', '=', $filter['stage_id']);
        }
        $items = $query->orderBy('stage_id', 'asc')->orderBy('level', 'asc')->get();
        $tmp = DB::select('select sl.id, (select count(0) from students where level_id=sl.id and status=1) as count from school_levels sl');
        $active_students = [];
        foreach ($tmp as $item) {
            $active_students[$item->id] = $item->count;
        }

        $stages = SchoolStage::orderBy('stage', 'asc')->get();
        return view('admin.school-level.index', compact('items', 'stages', 'filter', 'active_students'));
    }

    public function edit(Request $request, $id = 0)
    {
        $item = $id ? SchoolLevel::find($id) : new SchoolLevel();
        if (!$item) {
            return redirect('admin/school-level')->with('warning', 'Tingkatan sekolah tidak ditemukan.');
        }

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:40',
            ], [
                'name.required' => 'Nama tingkatan harus diisi.',
                'name.max' => 'Nama tingkatan terlalu panjang, maksimal 40 karakter.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            
            // check duplicate for name, stage and level
            $rows = DB::select('select id from school_levels where name=? and stage_id=? and level=?',
                [$request->name, $request->stage_id, $request->level]);
            if ($rows && $rows[0]->id !== $item->id) {
                $validator->getMessageBag()->add('name', 'Nama kelas sudah digunakan, gunakan nama lain.');
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $data = ['Old Data' => $item->toArray()];
            $item->fill($request->all());
            $item->save();
            $data['New Data'] = $item->toArray();

            UserActivity::log(
                UserActivity::SCHOOL_LEVEL_MANAGEMENT,
                ($id == 0 ? 'Tambah' : 'Perbarui') . ' Kelas',
                'Kelas ' . e($item->name) . ' telah ' . ($id == 0 ? 'dibuat' : 'diperbarui'),
                $data
            );

            return redirect('admin/school-level')->with('info', 'Tingkatan sekolah telah disimpan.');
        }

        $stages = SchoolStage::all();

        return view('admin.school-level.edit', compact('item', 'stages'));
    }

    public function delete($id)
    {
        if (!$item = SchoolLevel::find($id)) {
            $message = 'Kelas tidak ditemukan.';
        } else if ($item->delete($id)) {
            $message = 'Kelas ' . e($item->name) . ' telah dihapus.';
            UserActivity::log(
                UserActivity::SCHOOL_LEVEL_MANAGEMENT,
                'Hapus Kelas',
                $message,
                $item->toArray()
            );
        }

        return redirect('admin/school-level')->with('warning', $message);
    }
}
