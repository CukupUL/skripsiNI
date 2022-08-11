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

<div class="card">
  <div class="card-body table-responsive">
    <a href="/penjualan/create" class="btn btn-success btn-sm mb-3">Tambah</a>

    <table class="table table-bordered w-100" id="tablePenjualan">
      <thead>
        <tr>
          <th>No. Transaksi</th>
          <th>Tanggal Transaksi</th>
          <th>Total Item</th>
          <th>Total Tagihan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>


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
          url: '{{ url('penjualan/data') }}',
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