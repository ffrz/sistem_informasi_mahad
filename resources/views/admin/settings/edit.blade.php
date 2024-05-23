<?php use App\Models\Setting; ?>

@extends('admin._layouts.default', [
    'title' => 'Pengaturan',
    'menu_active' => 'system',
    'nav_active' => 'settings',
])
@section('content')
  <form method="POST" action="{{ url('admin/settings/save') }}">
    @csrf
    <div class="card card-light">
      <div class="card-header" style="padding:0;border-bottom:0;">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          {{-- <li class="nav-item">
            <a class="nav-link active" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab"
              aria-controls="inventory" aria-selected="true">Inventori</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" id="school-profile-tab" data-toggle="tab" href="#school-profile" role="tab"
              aria-controls="school-profile" aria-selected="false">Profil Lembaga</a>
          </li>
        </ul>
      </div>
      <div class="tab-content card-body" id="myTabContent">
        {{-- <div class="tab-pane fade show active" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
          <div class="form-row">
            <div class="form-group col-md-4">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="inv-show-desc" name="inv_show_description" {{ Setting::value('inv.show_description') ? 'checked' : '' }}>
                <label class="custom-control-label" for="inv-show-desc">Tampilkan deskripsi produk</label>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="inv-show-barcode" name="inv_show_barcode" {{ Setting::value('inv.show_barcode') ? 'checked' : '' }}>
                <label class="custom-control-label" for="inv-show-barcode">Tampilkan barcode produk</label>
              </div>
            </div>
          </div>
        </div> --}}
        <div class="tab-pane fade show active" id="school-profile" role="tabpanel" aria-labelledby="school-profile-tab">
          <div class="form-horizontal">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="school_name">Nama Lembaga</label>
                <input type="text" class="form-control @error('school_name') is-invalid @enderror" id="school_name"
                  placeholder="Nama Usaha" name="school_name"
                  value="{{ Setting::value('school.name', 'Madrasah...') }}">
                @error('school_name')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="school_phone">No. Telepon</label>
                <input type="text" class="form-control @error('school_phone') is-invalid @enderror"
                  id="school_phone" placeholder="Nomor Telepon / HP" name="school_phone"
                  value="{{ Setting::value('school.phone') }}">
                @error('school_phone')
                  <span class="text-danger">
                    {{ $message }}
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="school_address">Alamat</label>
                <textarea class="form-control" id="school_address" name="school_address">{{ Setting::value('school.address') }}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Simpan</button>
      </div>
    </div>
  </form>
@endSection
