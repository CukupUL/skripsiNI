<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-2 d-flex"> 
        <div class="image">
          <img src="{{ Auth::user()->foto }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/profile" class="d-block">
            <p>
              <!-- untuk memanggil nama siap yang login -->
          {{ config ('app.name') }}  -  {{ auth()->user()->name }}
            </p> 
          </a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard 
              </p>
            </a>
          </li>
          <li class="nav-header"></li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Master
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('kategori.index') }}" class="nav-link">
                  <i class="fa fa-cube nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('produk.index') }}" class="nav-link">
                  <i class="fa fa-cubes nav-icon"></i>
                  <p>Produk</p>
                </a>
              </li>
            </ul>
          </li> 
           <li class="nav-header"></li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-info-circle"></i>
              <p>INFORMASI<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('exp.index') }}" class="nav-link">
                  <i class="nav-icon fa fa-exclamation-triangle"></i>
                  <p>Exp Date</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('stok.index') }}" class="nav-link">
                  <i class="fa fa-ban nav-icon"></i>
                  <p>Stok Abis</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/reports/produk " class="nav-link">
                  <i class="fa fa fa-book nav-icon"></i>
                  <p>Laporan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header"></li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Transaksi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/penjualan" class="nav-link">
                  <i class="fa fa-shopping-basket nav-icon"></i>
                  <p>Penjualan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('transaksi.baru') }}" class="nav-link">
                  <i class="fa fa-upload nav-icon"></i>
                  <p>Transaksi Baru</p>
                </a>
              </li>
            </ul>
        </ul>
      </nav>
    </div>
  </aside>