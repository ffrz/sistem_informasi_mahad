<?php $title = ($item->id ? 'Edit' : 'Tambah') . ' Santri'; ?>
@extends('admin._layouts.default', [
    'title' => $title,
    'menu_active' => 'master',
    'nav_active' => 'student',
])

@section('content')
  <div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST" action="{{ url('admin/student/edit/' . (int) $item->id) }}">
      @csrf
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="nis">NIS</label>
            <input type="text" class="form-control @error('nis') is-invalid @enderror" autofocus id="nis"
              placeholder="" name="nis" value="{{ old('nis', $item->nis) }}">
            @error('nis')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="fullname">Nama Lengkap</label>
            <input type="text" class="form-control @error('fullname') is-invalid @enderror" autofocus id="fullname"
              placeholder="" name="fullname" value="{{ old('fullname', $item->fullname) }}">
            @error('fullname')
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
              <option value="">Pilih Tingkat</option>
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
            <label for="level_id">Kelas:</label>
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
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="status">Status:</label>
            <select class="form-control custom-select" name="status" id="status">
              <option value="">Pilih Tingkat</option>
              @foreach ($statuses as $code => $name)
                <option value="{{ $code }}" {{ $item->status == $code ? 'selected' : '' }}>
                  {{ $name }}</option>
              @endforeach
            </select>
            @error('stage_id')
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
        let $stage_id = $("#level_id");
        $stage_id.prop('disabled', stage_id == '');
        $stage_id.empty();
        $stage_id.append($("<option></option>")
          .attr("value", '-1').text('Pilih Kelas'));
        if (stage_id > 0) {
          $.each(levels_by_stages[stage_id], function(key, value) {
            $stage_id.append($("<option></option>")
              .attr("value", key).text(value));
          });
        }
      }
      $('#stage_id').change(on_stage_change);
      on_stage_change();
      $("#level_id").val(item.level_id);
    });
  </script>
@endSection
