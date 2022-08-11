@extends('layouts.master') 
<!--extends untuk memanggil dari folder layouts.master -->
@section('title')
    Daftar Penjualan
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Daftar Penjualan</li>
@endsection

@section('content')

<form action="/penjualan" method="POST" id="formPenjualan">
  @csrf

  @include('penjualan.form')

  <button class="btn btn-success btn-sm mt-3" type="button" onclick="Penjualan.checkSubmit()">Tambah Penjualan</button>
</form>


@endsection

@push('scripts')
<script>
  let table;
  $(function() {
    table = $("#tablePenjualan").dataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      autoWidth: false,
      ajax: {
          url: '{{ route('penjualan.data') }}',
      },
      columns: [
          // {data: 'DT_RowIndex', searchable: false, sortable: false},
          {data: 'no_penjualan'},
          {data: 'created_at'},
          {data: 'total_item'},
          {data: 'total_harga'},
          {data: 'aksi', searchable: false, sortable: false},
      ]
    })
  });
</script>
@endpush