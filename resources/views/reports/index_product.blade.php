@extends('layouts.master') 
<!--extends untuk memanggil dari folder layouts.master -->
@section('title')
    Laporan 
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Laporan </li>
@endsection

@section('content')
  
  <div class="row">
    <div class="col-md-3">
      <div class="card bg-primary">
        <div class="card-body text-center bg-primary">
          <h4>Total Produk Stok Habis</h4>
          <h5>{{ $count_out_stok }}</h5>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          <h4 class="text-center">Produk Habis Stok</h4>
        </div>
        <div class="card-body">
          <ul>
            @forelse ($product_out_stok as $produk)
              <li>
                {{ $produk->nama_produk }}
              </li>
            @empty
              <li>
                Tidak ada produk
              </li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
    
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          <h4 class="text-center">Produk Mendekati Habis Stok</h4>
        </div>
        <div class="card-body">
          <ul>
            @forelse ($product_approach_stok as $produk)
              <li>
                {{ $produk->nama_produk }}
              </li>
            @empty
              <li>
                Tidak ada produk
              </li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
    
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          <h4 class="text-center">Produk Mendekati Expired</h4>
        </div>
        <div class="card-body">
          <ul>
            @forelse ($product_expires as $produk)
              <li>
                {{ $produk->nama_produk }} 
              </li>
            @empty
              <li>
                Tidak ada produk
              </li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-3">
    <div class="card-body table-responsive">
      <h4>List Transaksi</h4>
      <table class="table table-bordered w-100" id="tableProduk">
        <thead>
          <tr>
            <th>Nama Produk</th>
            <th>Nomor Order</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
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
    $("#tableProduk").dataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      autoWidth: false,
      ajax: {
          url: '{{ route('report.product.transaction.data') }}',
      },
      columns: [
          { data: 'nama_produk', name: 'nama_produk' },
          { data: 'no_penjualan', name: 'no_penjualan' },
          { data: 'jumlah', name: 'jumlah' },
          { data: 'subtotal', name: 'subtotal' },
      ],
    });
  </script>
@endpush