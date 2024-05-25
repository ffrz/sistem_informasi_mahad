<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolStage;
use App\Models\Student;
use App\Models\StudentBill;
use App\Models\StudentBillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;

class StudentBillController extends Controller
{
    //
    public function index()
    {
        $items = StudentBill::with('student')
            ->orderBy('id', 'desc')->paginate(25);
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
            $data['amount'] = number_from_input($data['amount']);
            
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

    public function generate(Request $request)
    {
        $item = new stdClass();
        $item->date = date('Y-m-d');
        $item->due_date = date('Y-m-d');
        $item->amount = 0;
        $item->type_id = 0;
        $item->description = '';

        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(), [
                'date' => 'required',
                'amount' => 'required',
                'type_id' => 'required',
                'description' => 'required',
            ], [
                'date' => 'Tanggal harus diisi',
                'amount' => 'Jumlah tagihan harus diisi',
                'type_id' => 'Jenis tagihan harus diisi',
                'description' => 'Deskripsi harus diisi',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $data = $request->all();
            $data['amount'] = number_from_input($data['amount']);

            $q = Student::where('status', '=', Student::STATUS_ACTIVE);
            $type = StudentBillType::with(['stage', 'level'])->find($data['type_id']);
            if ($type->stage) {
                $q->where('stage_id', '=', $type->stage->id);
            }
            if ($type->level) {
                $q->where('level_id', '=', $type->level->id);
            }
            $students = $q->orderBy('id', 'asc')->get();

            DB::beginTransaction();
            foreach ($students as $student) {
                $data['student_id'] = $student->id;

                $bill = new StudentBill();
                $bill->fill($data);
                $bill->save();
            }
            DB::commit();

            // $data = ['Old Data' => $item->toArray()];
            // $data['New Data'] = $item->toArray();

            // UserActivity::log(
            //     UserActivity::STUDENT_MANAGEMENT,
            //     ($id == 0 ? 'Tambah' : 'Perbarui') . ' Santri',
            //     'Santri ' . e($item->name) . ' telah ' . ($id == 0 ? 'dibuat' : 'diperbarui'),
            //     $data
            // );
            return redirect('admin/student-bill')->with('info', 'Tagihan telah digenerate.');
        }
        
        $bill_types = StudentBillType::with(['stage', 'level'])->orderBy('name', 'asc')->get();
        $stages = SchoolStage::orderBy('name', 'asc')->get();

        return view('admin.student-bill.generate', compact('item', 'bill_types', 'stages'));
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
