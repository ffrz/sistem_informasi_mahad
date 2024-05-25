@extends('admin._layouts.default', [
    'title' => 'Tagihan Santri',
    'menu_active' => 'transaction',
    'nav_active' => 'bill',
])

@section('right-menu')
  <li class="nav-item">
    <a href="{{ url('/admin/student-bill/edit/0') }}" class="btn plus-btn btn-primary mr-2" title="Baru"><i
        class="fa fa-plus"></i></a>
  </li>
@endSection

@section('content')
  <div class="card card-light">
    <div class="card-body">
      <h1>Tagihan Siswa</h1>
      <p></p>
    </div>
  </div>
@endSection
