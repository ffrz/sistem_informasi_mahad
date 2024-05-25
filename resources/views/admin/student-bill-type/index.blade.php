@extends('admin._layouts.default', [
    'title' => 'Biaya Sekolah',
    'menu_active' => 'transaction',
    'nav_active' => 'student-bill-type',
])

@section('right-menu')
  <li class="nav-item">
    <a href="<?= url('/admin/student-bill-type/edit/0') ?>" class="btn plus-btn btn-primary mr-2" title="Baru"><i
        class="fa fa-plus"></i></a>
  </li>
@endSection

@section('content')
  <div class="card card-light">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <table class="data-table display table table-bordered table-striped table-condensed center-th"
            style="width:100%">
            <thead>
              <tr>
                <th style="width:30%">Jenis Biaya</th>
                <th>Tingkat</th>
                <th>Kelas</th>
                <th>Biaya (Rp.)</th>
                <th style="width:5%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($items as $item)
                <tr>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->stage ? $item->stage->name : 'Semua Tingkat' }}</td>
                  <td>{{ $item->level ? $item->stage->name : 'Semua Kelas' }}</td>
                  <td class="text-right">{{ format_number($item->amount) }}</td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="<?= url("/admin/student-bill-type/edit/$item->id") ?>" class="btn btn-default btn-sm"><i
                          class="fa fa-edit"></i></a>
                      <a onclick="return confirm('Anda yakin akan menghapus rekaman ini?')"
                        href="<?= url("/admin/student-bill-type/delete/$item->id") ?>" class="btn btn-danger btn-sm"><i
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
