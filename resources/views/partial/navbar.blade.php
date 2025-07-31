<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
   <a href="{{ route('home.index') }}" class="brand-link d-flex align-items-center">
    <img src="{{ asset('asset/dist/img/logoumkm.png') }}" 
         alt="Logo SI-UMKM RIAU" 
         class="brand-image img-circle elevation-3"
         style="opacity: .9; width: 40px; height: 40px; object-fit: cover;">

    <span class="brand-text font-weight-bold ml-2 text-white" style="font-size: 16px;">
        SI-UMKM <span class="text-info">RIAU</span>
    </span>
</a>


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset ('/asset/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          {{-- <a href="#" class="d-block"> {{ $nama }} </a> --}}
        </div>
      </div>

      <!-- SidebarSearch Form -->
     <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> 

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    
          <li class="nav-item">
            <a href="{{ route('home.index') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>

         <li class="nav-item">
          <a href="{{ route('spj.index') }}" class="nav-link">
            <i class="fas fa-receipt nav-icon"></i>
            <p>Data SPJ</p>
          </a>
        </li>
         
        <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-store"></i> {{-- Ganti icon sesuai tema UMKM --}}
          <p>
            Data UMKM
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
          <a href="{{ route('umkm.proses.index') }}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Data UMKM Proses</p>
        </a>
      </li>
      <li class="nav-item">
          <a href="{{ route('umkm.sertifikasi.index') }}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Data UMKM Sertifikasi</p>
        </a>
      </li>

        </ul>
      </li>
      


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>