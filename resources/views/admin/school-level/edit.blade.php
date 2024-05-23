<?php $title = ($item->id ? 'Edit' : 'Tambah') . ' Kelas'; ?>
@extends('admin._layouts.default', [
    'title' => $title,
    'menu_active' => 'school',
    'nav_active' => 'school-level',
])

@section('content')
  <div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST" action="{{ url('admin/school-level/edit/' . (int) $item->id) }}">
      @csrf
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="stage_id">Tingkat Sekolah</label>
            <select class="form-control custom-select" name="stage_id" id="stage_id">
              <option value="">Pilih Tingkatan</option>
              @foreach ($stages as $stage)
                <option value="{{ $stage->id }}" {{ $item->stage_id == $stage->id ? 'selected' : '' }}>
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
            <label for="level">Kelas</label>
            <input type="number" min="1" max="12" class="form-control @error('level') is-invalid @enderror"
              autofocus id="level" placeholder="Masukkan tingkat kelas" name="level"
              value="{{ old('level', $item->level) }}">
            @error('level')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="name">Nama Kelas</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
              placeholder="Masukkan nama kelas" name="name" value="{{ old('name', $item->name) }}">
            @error('name')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
        <a class="btn btn-default ml-2" href="/admin/school-level"><i class="fas fa-cancel mr-1"></i> Batal</a>
      </div>
    </form>
  </div>
@endSection
