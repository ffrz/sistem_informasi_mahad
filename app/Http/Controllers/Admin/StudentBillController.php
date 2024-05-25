<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentBill;
use App\Models\StudentBillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentBillController extends Controller
{
    //
    public function index()
    {
        $items = StudentBill::with('student')
            ->orderBy('id', 'desc')->get();
        return view('admin.student-bill.index', compact('items'));
    }

    public function edit(Request $request, $id = 0)
    {
        $item = $id ? StudentBill::find($id) : new StudentBill();
        if (!$item) {
            return redirect('admin/student-bill')->with('warning', ' tidak ditemukan.');
        }

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'student_id' => 'required',
                'type_id' => 'required',
                'amount' => 'required',
                'description' => 'required',
            ], [
                'description' => 'Deskripsi harus diisi',
                'student_id.required' => 'Santri harus diisi.',
                'type_id' => 'Jenis Biaya harus diisi',
                'amount.required' => 'Jumlah biaya harus diisi.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $data = $request->all();
            $data['paid'] = 0;
            $data['total_paid'] = 0;
            $data['amount'] = numberFromInput($data['amount']);
            
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
            return redirect('admin/student-bill')->with('info', 'Tagihan telah disimpan.');
        }

        $students = Student::with(['stage', 'level'])
            ->where('status', 1)->orderBy('fullname', 'asc')->get();
        $student_by_ids = [];
        foreach ($students as $student) {
            $student_by_ids[$student->id] = $student;
        }

        $types = StudentBillType::with(['stage'])->orderBy('name', 'asc')->get();

        return view('admin.student-bill.edit', compact('item', 'student_by_ids', 'types', 'students'));
    }

    public function generate()
    {
        $bill_types = StudentBillType::all();
        return view('admin.student-bill.generate', 'bill_types');
    }


    public function delete($id)
    {
        if (!$item = StudentBill::find($id)) {
            $message = 'Tagihan santri tidak ditemukan.';
        } else if ($item->delete($id)) {
            $message = 'Tagihan ' . e($item->description) . ' telah dihapus.';
            // UserActivity::log(
            //     UserActivity::STUDENT_MANAGEMENT,
            //     'Hapus Santri',
            //     $message,
            //     $item->toArray()
            // );
        }

        return redirect('admin/student-bill')->with('info', $message);
    }
}
