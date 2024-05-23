@extends('admin._layouts.default', [
    'title' => 'Kelas',
    'menu_active' => 'master',
    'nav_active' => 'school-level',
])

@section('right-menu')
  <li class="nav-item">
    <a href="<?= url('/admin/school-level/edit/0') ?>" class="btn plus-btn btn-primary mr-2" title="Baru"><i
        class="fa fa-plus"></i></a>
  </li>
@endSection

@section('content')
  <div class="card card-light">
    <div class="card-body">
      <form action="?" method="GET">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group form-inline">
              <label class="mr-2" for="stage_id">Tingkat:</label>
              <select class="form-control custom-select" name="stage_id" id="stage_id" onchange="this.form.submit();">
                <option value="">Pilih Tingkatan</option>
                @foreach ($stages as $stage)
                  <option value="{{ $stage->id }}" {{ $filter['stage_id'] == $stage->id ? 'selected' : '' }}>
                    {{ $stage->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-md-12">
          <table class="data-table display table table-bordered table-striped table-condensed center-th"
            style="width:100%">
            <thead>
              <tr>
                <th style="width:25%">Tingkatan</th>
                <th style="width:5%">Kelas</th>
                <th>Nama Kelas</th>
                <th>Santri Aktif</th>
                <th style="width:5%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($items as $item)
                <tr>
                  <td>{{ $item->stage->name }}</td>
                  <td>{{ $item->level }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ isset($active_students[$item->id]) && $active_students[$item->id] > 0 ? $active_students[$item->id] : 'tidak ada' }}</td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="<?= url("/admin/school-level/edit/$item->id") ?>" class="btn btn-default btn-sm"><i
                          class="fa fa-edit"></i></a>
                      <a onclick="return confirm('Anda yakin akan menghapus rekaman ini?')"
                        href="<?= url("/admin/school-level/delete/$item->id") ?>" class="btn btn-danger btn-sm"><i
                          class="fa fa-trash"></i></a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="empty" colspan="5">Tidak ada rekaman</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endSection
