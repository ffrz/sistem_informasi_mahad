@extends('admin._layouts.default', [
    'title' => 'Tingkatan Sekolah',
    'menu_active' => 'school',
    'nav_active' => 'school-stage',
])

@section('right-menu')
  <li class="nav-item">
    <a href="<?= url('/admin/school-stage/edit/0') ?>" class="btn plus-btn btn-primary mr-2" title="Baru"><i
        class="fa fa-plus"></i></a>
  </li>
@endSection

@section('content')
  <div class="card card-light">
    @include('admin._components.card-header', [
        'title' => 'Grup Pengguna',
        'description' => 'Daftar grup pengguna pada sistem',
    ])
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <table class="data-table display table table-bordered table-striped table-condensed center-th"
            style="width:100%">
            <thead>
              <tr>
                <th style="width:30%">Tingkatan</th>
                <th>Tingkat</th>
                <th>Siswa Aktif</th>
                <th style="width:5%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($items as $item)
                <tr>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->stageFormatted() }}</td>
                  <td>
                    {{ isset($active_students[$item->id]) && $active_students[$item->id] > 0 ? $active_students[$item->id] : 'tidak ada' }}
                  </td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="<?= url("/admin/school-stage/edit/$item->id") ?>" class="btn btn-default btn-sm"><i
                          class="fa fa-edit"></i></a>
                      <a onclick="return confirm('Anda yakin akan menghapus rekaman ini?')"
                        href="<?= url("/admin/school-stage/delete/$item->id") ?>" class="btn btn-danger btn-sm"><i
                          class="fa fa-trash"></i></a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="empty" colspan="3">Tidak ada rekaman</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endSection
