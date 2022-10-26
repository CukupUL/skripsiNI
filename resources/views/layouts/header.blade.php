<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <!-- untuk keluar dari tampilan dashboard // dengan menyamakan (logout-form) dalam line 30 yanag sama -->
          <span class=" " onclick="document.getElementById('logout-form').submit()" > <i class="fas fa-sign-out-alt"></i> </span>
        </a>
      </li>
    </ul>
  </nav>

  <!-- menambahkan aksi dengan membuat form dengan post metode aktion nay ke rout ke lougot dan di tambahkan token  // proses mengunakan id (lougout-form) dari line 24 -->
  <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
  @csrf
  </form>
