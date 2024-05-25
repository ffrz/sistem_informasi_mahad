<?php $title = ($item->id ? 'Edit' : 'Buat') . ' Tagihan'; ?>
@extends('admin._layouts.default', [
    'title' => $title,
    'menu_active' => 'transaction',
    'nav_active' => 'student-bill',
])

@section('content')
  <div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST"
      action="{{ url('admin/student-bill/edit/' . (int) $item->id) }}">
      @csrf
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="date">Tanggal</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" autofocus
              id="date" name="date" value="{{ old('date', $item->date) }}">
            @error('date')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="student_id">Santri</label>
            <select class="form-control custom-select select2" name="student_id" id="student_id">
              <option value="">Pilih Santri</option>
              @foreach ($students as $student)
                <option value="{{ $student->id }}" {{ $student->id == $item->student_id ? 'selected' : '' }}>
                  {{ "$student->nis - $student->fullname - {$student->stage->name} - {$student->level->name}" }}
                </option>
              @endforeach
            </select>
            @error('student_id')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="type_id">Jenis Biaya</label>
            <select class="form-control custom-select" name="type_id" id="type_id" disabled>
              <option value="">Pilih Jenis Biaya</option>
            </select>
            @error('type_id')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="amount">Jumlah (Rp.)</label>
            <input type="text" class="form-control text-right @error('amount') is-invalid @enderror" autofocus
              id="amount" placeholder="" name="amount" value="{{ old('amount', format_number($item->amount)) }}"
              disabled>
            @error('amount')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="description">Deskripsi</label>
            <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
              placeholder="Masukkan deskripsi" name="description"
              value="{{ old('description', $item->description) }}">
            @error('description')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button id="save" type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
      </div>
    </form>
  </div>
@endSection

@section('footscript')
  <script>
    $(document).ready(function() {
      let item = {!! json_encode($item) !!};
      let bill_types = {!! json_encode($types) !!};
      let bill_type_by_stages = {};
      let bill_type_by_ids = {};
      let student_by_ids = {!! json_encode($student_by_ids) !!};

      bill_types.forEach(function(el) {
        if (!bill_type_by_stages[el.stage.id]) {
          bill_type_by_stages[el.stage.id] = [];
        }
        bill_type_by_stages[el.stage.id].push(el);
        bill_type_by_ids[el.id] = el;
      });

      let $student_id = $('#student_id');
      let $type_id = $('#type_id');
      let $amount = $('#amount');
      $('.select2').select2();

      function update_ui_state() {
        let student_id = $student_id.val();
        let type_id = $type_id.val();
        console.log(type_id);
        $type_id.prop('disabled', student_id == '');
        $amount.prop('disabled', type_id  == '');
      }

      function on_student_change() {
        let student_id = $student_id.val();
        let type_id = $type_id.val();
        let student = student_by_ids[student_id];

        $type_id.empty();
        $type_id.append($("<option></option>")
          .attr("value", '').text('Pilih Jenis Biaya'));

        if (student_id > 0) {
          let types = bill_type_by_stages[student.stage.id];
          $.each(types, function(key, type) {
            $type_id.append($("<option></option>")
              .attr("value", type.id).text(type.name));
          });
        }

        update_ui_state();
      }

      function on_bill_type_changed() {
        let type_id = $type_id.val();
        $amount.val(0);
        if (type_id) {
          let type = bill_type_by_ids[$type_id.val()];
          $amount.val(toLocaleNumber(type.amount));
        }
        update_ui_state();
      }

      $type_id.change(on_bill_type_changed);
      $student_id.change(on_student_change);
      Inputmask("decimal", Object.assign({
        allowMinus: false
      }, INPUTMASK_OPTIONS)).mask("#amount");

      on_student_change();
      if (item && item.id) {
        $type_id.val(item.type_id);
      }
      update_ui_state();
    });
  </script>
@endSection
