<!-- NAVBAR -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->

<!-- SIDEBAR -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link d-flex align-items-center">
    <img src="{{ asset('asset/dist/img/logoumkm.png') }}"
         alt="Logo SI-UMKM RIAU"
         class="brand-image img-circle elevation-3"
         style="opacity: .9; width: 40px; height: 40px; object-fit: cover;">
    <span class="brand-text font-weight-bold ml-2 text-white" style="font-size: 16px;">
      SI-UMKM <span class="text-info">RIAU</span>
    </span>
  </a>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <!-- PROFILE DROPDOWN -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
        <img src="{{ asset('asset/dist/img/avatar.png') }}" alt="User Image" class="rounded-circle" width="30" height="30">
        <span class="ml-2">{{ Auth::user()->username }}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="dropdown-item text-danger" type="submit">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </button>
        </form>
      </div>
    </li>

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Beranda</p>
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
          <i class="nav-icon fas fa-store"></i>
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

     {{-- HANYA UNTUK ADMIN --}}
    @if (Auth::check() && Auth::user()->role?->name === 'admin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-user-shield"></i>
          <p>
            Role Management
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Manipulasi Account</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Manipulasi Role</p>
            </a>
          </li>
        </ul>
      </li>
    @endif
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</aside>
