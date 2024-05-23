@extends('admin._layouts.default', [
    'title' => 'Santri',
    'menu_active' => 'master',
    'nav_active' => 'student',
])

@section('right-menu')
  <li class="nav-item">
    <a href="{{ url('/admin/student/edit/0') }}" class="btn plus-btn btn-primary mr-2" title="Baru"><i
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
                <option value="">Semua</option>
                @foreach ($stages as $stage)
                  <option value="{{ $stage->id }}" {{ $filter['stage_id'] == $stage->id ? 'selected' : '' }}>
                    {{ $stage->name }}</option>
                @endforeach
              </select>
              @if ($filter['stage_id'] != '')
                <label class="ml-4 mr-2" for="level_id">Kelas:</label>
                <select class="form-control custom-select" name="level_id" id="level_id" onchange="this.form.submit();">
                  <option value="">Semua</option>
                  @foreach ($levels as $level)
                    <option value="{{ $level->id }}" {{ $filter['level_id'] == $level->id ? 'selected' : '' }}>
                      {{ $level->name }}</option>
                  @endforeach
                </select>
              @endif
              <label class="ml-4 mr-2" for="status">Status:</label>
              <select class="form-control custom-select" name="status" id="status" onchange="this.form.submit();">
                <option value="">Semua</option>
                @foreach ($statuses as $code => $name)
                  <option value="{{ $code }}" {{ $filter['status'] == $code ? 'selected' : '' }}>
                    {{ $name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6 d-flex justify-content-end">
            <div class="form-group form-inline">
              <label class="mr-2" for="search">Cari:</label>
              <input type="text" class="form-control" name="search" id="search" value="{{ $filter['search'] }}">
            </div>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-md-12">
          <table class="display table table-bordered table-striped table-condensed" style="width:100%">
            <thead>
              <tr>
                <th style="width:10%">NIS</th>
                <th>Nama</th>
                <th style="width:5%">Tingkat</th>
                <th style="width:5%">Kelas</th>
                <th style="width:5%">Status</th>
                <th style="width:5%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($items as $item)
                <tr>
                  <td>{{ $item->nis }}</td>
                  <td>{{ $item->fullname }}</td>
                  <td>{{ $item->stage->name }}</td>
                  <td>{{ $item->level->name }}</td>
                  <td>{{ $item->statusFormatted() }}</td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="<?= url("/admin/student/detail/$item->id") ?>" class="btn btn-default btn-sm"><i
                          class="fa fa-eye"></i></a>
                      <a href="<?= url("/admin/student/edit/$item->id") ?>" class="btn btn-default btn-sm"><i
                          class="fa fa-edit"></i></a>
                      <a onclick="return confirm('Anda yakin akan menghapus rekaman ini?')"
                        href="<?= url("/admin/student/delete/$item->id") ?>" class="btn btn-danger btn-sm"><i
                          class="fa fa-trash"></i></a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="empty">Tidak ada rekaman.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {{-- .row --}}

      </div>
      <div class="row">
        <div class="col-md-6">
          <p class="text-muted">Menampilkan {{ $items->count() }} rekaman dari total {{ $items->total() }} rekaman.</p>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
          {{ $items->withQueryString()->onEachSide(1)->links('admin._components.paginator') }}

        </div>
      </div>
      {{-- .row --}}
    </div>
  </div>
@endSection
