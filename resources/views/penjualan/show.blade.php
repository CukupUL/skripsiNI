@extends('layouts.master') 
<!--extends untuk memanggil dari folder layouts.master -->
@section('title')
    Detail Penjualan
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Detail Penjualan</li>
@endsection

@section('content')

<div class="card">
  <div class="card-body table-responsive">
    <table class="table">
      <tr>
        <th>No Penjualan</th>
        <td>: {{ $penjualan->no_penjualan }}</td>
      </tr>
      <tr>
        <th>Tanggal Penjualan</th>
        <td>: {{ date("d M Y", strtotime($penjualan->created_at)) }}</td>
      </tr>
      <tr>
        <th>Dibayar</th>
        <td>: {{ number_format($penjualan->bayar) }}</td>
      </tr>
      <tr>
        <th>Diterima</th>
        <td>: {{ number_format($penjualan->diterima) }}</td>
      </tr>
      <tr>
        <th>Kembalian</th>
        <td>: {{ number_format($penjualan->kembalian) }}</td>
      </tr>
    </table>
  </div>
</div>

<div class="card mt-3">
  <div class="card-body">
    <h4>List Item</h4>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Produk</th>
          <th>Jumlah</th>
          <th>Harga Jual</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
          <tr>
            <td>{{ $item->product->nama_produk }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ number_format($item->harga_jual) }}</td>
            <td>{{ number_format($item->subtotal) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


@endsection