@extends('admin._layouts.default', [
    'title' => 'Pengguna',
    'menu_active' => 'system',
    'nav_active' => 'users',
])

@section('right-menu')
  <li class="nav-item">
    <a href="{{ url('/admin/user/edit/0') }}" class="btn plus-btn btn-primary mr-2" title="Baru"><i
        class="fa fa-plus"></i></a>
  </li>
@endsection

@section('content')
  <div class="card card-light">
    @include('admin._components.card-header', [
        'title' => 'Pengguna',
        'description' => 'Daftar pengguna sistem',
    ])
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <table class="data-table display table table-bordered table-striped table-condensed center-th"
            style="width:100%">
            <thead>
              <tr>
                <th>ID Pengguna</th>
                <th>Nama Lengkap</th>
                <th>Grup</th>
                <th>Status</th>
                <th class="text-center" style="max-width:10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($items as $item)
                <tr>
                  <td>
                    {{ $item->username }}
                    @if ($item->is_admin)
                      <span class="badge badge-warning">Administrator</span>
                    @endif
                  </td>
                  <td>{{ $item->fullname }}</td>
                  <td>{{ $item->group ? $item->group->name : '-' }}</td>
                  <td>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="{{ url("/admin/user/edit/$item->id") }}" class="btn btn-default btn-sm"><i
                          class="fa fa-edit"></i></a>
                      <a href="{{ url("/admin/user/delete/$item->id") }}" class="btn btn-danger btn-sm"><i
                          class="fa fa-trash"></i></a>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <p class="text-muted">Menampilkan {{ $items->count() }} rekaman dari total {{ $items->total() }} rekaman.</p>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
          {{ $items->withQueryString()->onEachSide(1)->links('admin._components.paginator') }}
        </div>
      </div>
    </div>
  </div>
@endsection
