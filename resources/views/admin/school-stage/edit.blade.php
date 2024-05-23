<?php $title = ($item->id ? 'Edit' : 'Tambah') . ' Tingkatan Sekolah'; ?>
@extends('admin._layouts.default', [
    'title' => $title,
    'menu_active' => 'master',
    'nav_active' => 'school-stage',
])

@section('content')
  <div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST" action="{{ url('admin/school-stage/edit/' . (int) $item->id) }}">
      @csrf
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="name">Nama Tingkatan</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" autofocus id="name"
              placeholder="Masukkan Nama Tingkat" name="name" value="{{ old('name', $item->name) }}">
            @error('name')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="stage">Tingkatan</label>
            <select class="form-control custom-select" name="stage" id="stage">
              @foreach ($stages as $stage => $name)
                <option value="{{ $stage }}" {{ $item->stage == $stage ? 'selected' : '' }}>
                  {{ $name }}</option>
              @endforeach
            </select>
            @error('stage')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
        <a class="btn btn-default ml-2" href="/admin/school-stage"><i class="fas fa-cancel mr-1"></i> Batal</a>
      </div>
    </form>
  </div>
@endSection
