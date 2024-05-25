@extends('admin._layouts.default', [
    'title' => 'Generate Tagihan',
    'menu_active' => 'transaction',
    'nav_active' => 'student-bill',
])

@section('content')
  <div class="card card-primary">
    <form class="form-horizontal quick-form" method="POST" action="{{ url('admin/student-bill/generate') }}">
      @csrf
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="date">Tanggal Tagihan</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" autofocus id="date"
              name="date" value="{{ old('date', $item->date) }}">
            @error('date')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="due_date">Tanggal Jatuh Tempo</label>
            <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date"
              name="due_date" value="{{ old('due_date', $item->due_date) }}">
            @error('due_date')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="type_id">Jenis Biaya</label>
            <select class="form-control custom-select" name="type_id" id="type_id">
              <option value="">Pilih Jenis Biaya</option>
              @foreach ($bill_types as $type)
                <option value="{{ $type->id }}" data-amount-{{ $type->id }}="{{ $type->amount }}">
                  {{ $type->name .
                      ($type->stage ? ' - ' . $type->stage->name : '') .
                      ($type->level ? ' - ' . $type->level->name : '') }}
                </option>
              @endforeach
            </select>
            @error('type_id')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="description">Deskripsi</label>
            <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
              placeholder="Masukkan deskripsi" name="description"
              value="{{ old('description', $item->description) }}">
            @error('description')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="amount">Jumlah (Rp.)</label>
            <input type="text" class="form-control text-right @error('amount') is-invalid @enderror" autofocus
              id="amount" name="amount" value="{{ old('amount', format_number($item->amount)) }}">
            @error('amount')
              <span class="text-danger">
                {{ $message }}
              </span>
            @enderror
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button id="save" type="submit" class="btn btn-warning"><i class="fas fa-bolt mr-1"></i> Generate</button>
      </div>
    </form>
  </div>
@endSection

@section('footscript')
  <script>
    $(document).ready(function() {
      Inputmask("decimal", Object.assign({
        allowMinus: false
      }, INPUTMASK_OPTIONS)).mask("#amount");

      let $type_id = $('#type_id');
      $type_id.change(function() {
        let id = $type_id.val();
        console.log($('#type_id data-amount-' + id).text());
      });
    });
  </script>
@endSection
