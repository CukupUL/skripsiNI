@extends('layouts.master') 
<!--extends untuk memanggil dari folder layouts.master -->
@section('title')
    Laporan
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Laporan</li>
@endsection

@section('content')
  
  <div class="row">
    <div class="col-md-4">
      <div class="card bg-primary">
        <div class="card-body bg-primary">
          <h4>Laporan Produk</h4>
        </div>
        <div class="card-footer">
          <a href="/reports/produk" class="text-white">Selengkapnya</a>
        </div>
      </div>
    </div>
  </div>

@endsection