<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolStage;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SchoolStageController extends Controller
{
    //
    public function index()
    {
        $items = SchoolStage::all();
        $tmp = DB::select('select a.id, (select count(0) from students where stage_id=a.id and status=1) as count from school_stages a');
        $active_students = [];
        foreach ($tmp as $item) {
            $active_students[$item->id] = $item->count;
        }
        return view('admin.school-stage.index', compact('items', 'active_students'));
    }

    public function edit(Request $request, $id = 0)
    {
        $item = $id ? SchoolStage::find($id) : new SchoolStage();
        if (!$item) {
            return redirect('admin/school-stage')->with('warning', 'Tingkatan sekolah tidak ditemukan.');
        }

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:school_stages,name,' . $request->id . '|max:40',
            ], [
                'name.required' => 'Nama tingkatan harus diisi.',
                'name.unique' => 'Nama tingkatan harus unik, nama ini sudah digunakan.',
                'name.max' => 'Nama tingkatan terlalu panjang, maksimal 40 karakter.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $data = ['Old Data' => $item->toArray()];
            $item->fill($request->all());
            $item->save();
            $data['New Data'] = $item->toArray();

            UserActivity::log(
                UserActivity::SCHOOL_STAGE_MANAGEMENT,
                ($id == 0 ? 'Tambah' : 'Perbarui') . ' Tingkat Sekolah',
                'Tingkat Sekolah ' . e($item->name) . ' telah ' . ($id == 0 ? 'dibuat' : 'diperbarui'),
                $data
            );

            return redirect('admin/school-stage')->with('info', 'Tingkatan sekolah telah disimpan.');
        }

        $stages = SchoolStage::stages();

        return view('admin.school-stage.edit', compact('item', 'stages'));
    }

    public function delete($id)
    {
        if (!$item = SchoolStage::find($id)) {
            $message = 'Tingkatan sekolah tidak ditemukan.';
        } else if (DB::select('select count(0) as count from school_levels where stage_id = ?', [$id])[0]->count) {
            $message = 'Rekaman tidak dapat dihapus karena sudah digunakan.';
        } else if ($item->delete($id)) {
            $message = 'Tingkatan sekolah ' . e($item->name) . ' telah dihapus.';
            UserActivity::log(
                UserActivity::SCHOOL_STAGE_MANAGEMENT,
                'Hapus Tingkat Sekolah',
                $message,
                $item->toArray()
            );
        }

        return redirect('admin/school-stage')->with('warning', $message);
    }
}
