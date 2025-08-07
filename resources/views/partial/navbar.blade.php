 <style>
  .profile-box {
    cursor: pointer;
    display: flex;
    align-items: center;
    padding: 8px 12px;
    border-radius: 8px;
    transition: background 0.3s;
    position: relative;
  }

  .profile-box:hover {
    background-color: rgba(255, 255, 255, 0.1);
  }

  .profile-name {
    color: white;
    margin-left: 10px;
    font-weight: 500;
  }

  .popout-menu {
    position: absolute;
    top: 110%;
    right: 0;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    min-width: 150px;
    display: none;
    z-index: 1000;
  }

  .popout-menu.active {
    display: block;
  }

  .popout-menu button {
    width: 100%;
    border: none;
    background: none;
    padding: 10px 15px;
    text-align: left;
    color: red;
    font-weight: 500;
  }

  .popout-menu button:hover {
    background-color: #f2f2f2;
  }
</style>
 
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
    <img src="{{ asset('asset/dist/img/logo-umkm.png') }}"
         alt="Logo SI-UMKM RIAU"
         class="brand-image"
         style="height: 50px; width: auto; object-fit: contain;">
      <span class="brand-text fw-bold text-white ms-2">SI-UMKM <span style="color:#15AABF">RIAU</span></span>
  </a>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <!-- PROFILE DROPDOWN -->
    <div class="nav-item" style="position: relative;">
      <div class="profile-box" onclick="togglePopout()">
        <img src="{{ asset('asset/dist/img/profile-pic.jpg') }}" alt="User Image" class="rounded-circle" width="30" height="30">
        <span class="profile-name">Halo, {{ Auth::user()->username }}!</span>
      </div>

      <div class="popout-menu" id="popoutMenu">
      {{-- Tombol Profil Anda --}}
      <form method="GET" action="{{ route('profile.view') }}">
        <button type="submit" class="popout-item text-dark">
          <i class="fas fa-user mr-2"></i> Profil Anda
        </button>
      </form>

      {{-- Tombol Logout --}}
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="popout-item text-danger">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </button>
      </form>
    </div>

</div>


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
              Manajement
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.users.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Role</p>
              </a>
            </li>
           <li class="nav-item">
  <a href="{{ route('wilayah.index') }}" class="nav-link {{ request()->routeIs('wilayah.index') ? 'active' : '' }}">
    <i class="far fa-circle nav-icon"></i>
    <p>Provinsi & Kota</p>
  </a>
</li>

          </ul>
        </li>
        @endif
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </aside>
      

  <script>
  function togglePopout() {
    const menu = document.getElementById('popoutMenu');
    menu.classList.toggle('active');
  }

  // Optional: close when clicking outside
  document.addEventListener('click', function(event) {
    const box = document.querySelector('.profile-box');
    const menu = document.getElementById('popoutMenu');
    if (!box.contains(event.target) && !menu.contains(event.target)) {
      menu.classList.remove('active');
    }
  });
</script>