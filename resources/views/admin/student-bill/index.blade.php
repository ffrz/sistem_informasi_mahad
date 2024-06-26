@extends('admin._layouts.default', [
    'title' => 'Tagihan Santri',
    'menu_active' => 'transaction',
    'nav_active' => 'student-bill',
])

@section('right-menu')
  <li class="nav-item">
    <a href="{{ url('/admin/student-bill/generate') }}" class="btn plus-btn btn-warning mr-2" title="Baru"><i
        class="fa fa-bolt mr-2"> </i>Generate</a>
    <a href="{{ url('/admin/student-bill/edit/0') }}" class="btn plus-btn btn-primary mr-2" title="Baru"><i
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
              <label class="mr-2" for="type_id">Jenis:</label>
              <select class="form-control custom-select mr-4" name="type_id" id="type_id"
                onchange="this.form.submit();">
                <option value="">Semua</option>
                @foreach ($types as $type)
                  <option value="{{ $type->id }}" {{ $filter['type_id'] == $type->id ? 'selected' : '' }}>
                    {{ $type->name .
                        ($type->stage ? ' - ' . $type->stage->name : '') .
                        ($type->level ? ' - ' . $type->level->name : '') }}
                  </option>
                @endforeach
              </select>
              <label class="mr-2" for="stage_id">Tingkat:</label>
              <select class="form-control custom-select" name="stage_id" id="stage_id" onchange="this.form.submit();">
                <option value="">Semua</option>
                @foreach ($stages as $stage)
                  <option value="{{ $stage->id }}" {{ $filter['stage_id'] == $stage->id ? 'selected' : '' }}>
                    {{ $stage->name }}</option>
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
          <table class="data-table display table table-bordered table-striped table-condensed center-th"
            style="width:100%">
            <thead>
              <tr>
                <th style="width:1%">#</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
                <th>Jumlah (Rp.)</th>
                <th>Dibayar (Rp.)</th>
                <th style="width:1%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($items as $item)
                <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ format_date($item->date) }}</td>
                  <td>{{ $item->description }}</td>
                  <td>{{ $item->student->nis . ' - ' . $item->student->fullname }}</td>
                  <td class="text-right">{{ format_number($item->amount) }}</td>
                  <td class="text-right">{{ format_number($item->total_paid) }}</td>
                  <td>
                    <div class="btn-group">
                      <a href="<?= url("/admin/student-bill/edit/$item->id") ?>" class="btn btn-default btn-sm"><i
                          class="fa fa-edit"></i></a>
                      <a onclick="return confirm('Anda yakin akan menghapus rekaman ini?')"
                        href="<?= url("/admin/student-bill/delete/$item->id") ?>" class="btn btn-danger btn-sm"><i
                          class="fa fa-trash"></i></a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="empty" colspan="7">Tidak ada rekaman</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @include('admin._components.paginator', ['items' => $items])
    </div>
  </div>
@endSection
