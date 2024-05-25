<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolLevel;
use App\Models\SchoolStage;
use App\Models\StudentBillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentBillTypeController extends Controller
{
    //
    public function index()
    {
        $items = StudentBillType::with(['stage', 'level'])
            ->orderBy('stage_id', 'asc')
            ->orderBy('level_id', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10);
        return view('admin.student-bill-type.index', compact('items'));
    }

    public function edit(Request $request, $id = 0)
    {
        $item = $id ? StudentBillType::find($id) : new StudentBillType();
        if (!$item) {
            return redirect('admin/student-bill-type')->with('warning', ' tidak ditemukan.');
        }

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:40',
                'amount' => 'required',
            ], [
                'name.required' => 'Jenis biaya harus diisi.',
                'amount.required' => 'Jumlah biaya harus diisi.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $data = $request->all();
            $data['amount'] = number_from_input($data['amount']);
            $data['stage_id'] = empty($data['stage_id']) ? null : $data['stage_id'];
            $data['level_id'] = empty($data['level_id']) ? null : $data['level_id'];
            
            // $data = ['Old Data' => $item->toArray()];
            $item->fill($data);
            $item->save();
            // $data['New Data'] = $item->toArray();

            // UserActivity::log(
            //     UserActivity::STUDENT_MANAGEMENT,
            //     ($id == 0 ? 'Tambah' : 'Perbarui') . ' Santri',
            //     'Santri ' . e($item->name) . ' telah ' . ($id == 0 ? 'dibuat' : 'diperbarui'),
            //     $data
            // );

            return redirect('admin/student-bill-type')->with('info', 'Jenis tagihan telah disimpan.');
        }

        $stages = SchoolStage::query()->orderBy('stage', 'asc')->get();
        $levels = SchoolLevel::query()->orderBy('level', 'asc')->get();
        $levels_by_stages = [];
        foreach ($levels as $level) {
            $levels_by_stages[$level->stage_id][$level->id] = $level->name;
        }

        return view('admin.student-bill-type.edit', compact('item', 'stages', 'levels', 'levels_by_stages'));
    }

    public function delete($id)
    {
        if (!$item = StudentBillType::find($id))
            $message = 'Jenis biaya tidak ditemukan.';
        else if ($item->delete($id)) {
            // $message = 'Santri ' . e($item->name) . ' telah dihapus.';
            // UserActivity::log(
            //     UserActivity::STUDENT_MANAGEMENT,
            //     'Hapus Santri',
            //     $message,
            //     $item->toArray()
            // );
        }

        return redirect('admin/student-bill-type')->with('info', $message);
    }
}
