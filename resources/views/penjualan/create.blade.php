<!-- // mengambil file lougut -->
@extends('layouts.master') 
<!--extends untuk memanggil dari folder layouts.master // mengubah title padaplikasi -->
@section('title')
Transaksi Baru
@endsection
<!-- berfungsi memberikan nafigasi // paaren = adalah untuk mengambil file dalam master.blade untuk memberikan alamat terkhir pada alamat web kita -->
<!-- untuk memulai memasukan form //  csrf adalah untuk validari inputan yanag masuk ke server (selain get)/ fitur keamanan  dan fitur memudahkan supaya code tidak panjang //include memasukan komponan ke view , karna untuk afa file edit  //ada nya type = butoon untuk memberikan perintah sebelum kirim maka harus click terlebih ahulu dan dari folder js ceeckSubmit -->
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Transaksi Baru</li>
@endsection

@section('content')

<form action="/penjualan" method="POST" id="formPenjualan">
  @csrf

  @include('penjualan.form')

  <button class="btn btn-success btn-sm mt-3" type="button" onclick="Penjualan.checkSubmit()">Tambah Penjualan</button>
</form>

@endsection

<!-- pus untuk memangil file js nya -->

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