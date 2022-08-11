@extends('layouts.master') 
<!--extends untuk memanggil dari folder layouts.master -->

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $total_penjualan }}</h3>

                <p>Total Penjualan</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="/penjualan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $total_produk }}</h3>

                <p>Total Produk</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/produk" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $total_produk_out_stok }}</h3>

                <p>Produk Habis Stok</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="/stok" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $total_produk_expired }}</h3>

                <p>Produk Expired</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="/exp" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- /.row -->

       
@endsection

@push('scripts')
  <script>
    
      var salesPenjualan = {
            labels: JSON.parse(document.querySelector("#listDatePenjualan").value),
            datasets: [
              {
                label: 'Penjualan',
                borderWidth: 1,
                data: JSON.parse(document.querySelector("#listPricePenjualan").value)
              },
            ]
          }

        var salesPenjualanDOM = document.querySelector("#chartPenjualan");
        var salesChart = new Chart(salesPenjualanDOM, { // lgtm[js/unused-local-variable]
          type: 'bar',
          data: salesPenjualan,
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true
                }
              }]
            }
          }
        })
  </script>
@endpush