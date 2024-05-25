<?php $title = ($item->id ? 'Edit' : 'Buat') . ' Tagihan'; ?>
@extends('admin._layouts.default', [
    'title' => $title,
    'menu_active' => 'transaction',
    'nav_active' => 'student-bill-type',
])

@section('content')
  <div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST" action="{{ url('admin/student-bill-type/edit/' . (int) $item->id) }}">
      @csrf
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="name">Jenis Biaya</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" autofocus id="name"
              placeholder="Jenis biaya" name="name" value="{{ old('name', $item->name) }}">
            @error('name')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="amount">Jumlah Biaya (Rp.)</label>
            <input type="text" class="form-control text-right @error('amount') is-invalid @enderror" autofocus id="amount"
              placeholder="" name="amount" value="{{ old('amount', format_number($item->amount)) }}">
            @error('amount')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="stage_id">Tingkat</label>
            <select class="form-control custom-select" name="stage_id" id="stage_id">
              <option value="">Semua Tingkat</option>
              @foreach ($stages as $stage)
                <option value="{{ $stage->id }}" {{ $item['stage_id'] == $stage->id ? 'selected' : '' }}>
                  {{ $stage->name }}</option>
              @endforeach
            </select>
            @error('stage_id')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="level_id">Semua Kelas</label>
            <select class="form-control custom-select" name="level_id" id="level_id" disabled>
              <option value="">Pilih Kelas</option>
            </select>
            @error('level_id')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
      </div>
    </form>
  </div>
@endSection

@section('footscript')
  <script>
    var item = {!! json_encode($item) !!};
    $(document).ready(function() {
      let levels_by_stages = {!! json_encode($levels_by_stages) !!};
      function on_stage_change() {
        let stage_id = $('#stage_id').val();
        let $level_id = $("#level_id");
        $level_id.prop('disabled', stage_id == '');
        $level_id.empty();
        $level_id.append($("<option></option>")
          .attr("value", '').text('Semua Kelas'));
        if (stage_id > 0) {
          $.each(levels_by_stages[stage_id], function(key, value) {
            $level_id.append($("<option></option>")
              .attr("value", key).text(value));
          });
        }
      }
      $('#stage_id').change(on_stage_change);
      on_stage_change();
      $("#level_id").val(item.level_id);

      Inputmask("decimal", Object.assign({
        allowMinus: false
      }, INPUTMASK_OPTIONS)).mask("#amount");
    });
  </script>
@endSection