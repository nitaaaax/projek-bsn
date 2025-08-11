<!DOCTYPE html>
<html lang="en">
<head>
  <style>
.card-header {
    background-color: #f8f9fa !important;
    color: #212529 !important;
    border-bottom: 1px solid #dee2e6;
    font-weight: 600;
}
</style>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Si-UMKM Riau</title>

    <!-- Favicon -->
  <link rel="icon" href="{{ asset('public/asset/dist/img/logo-umkm.png') }}" type="image/png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css') }}">

  <!-- OverlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

  <!-- Summernote -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/summernote/summernote-bs4.min.css') }}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/toastr/toastr.min.css') }}">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  {{-- Tambahan style dari view --}}
  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('asset/dist/img/logo-umkm.png') }}" alt="Logo UMKM" height="60" width="60">
  </div>

  <!-- Navbar -->
  @include('partial.navbar')

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    @yield('content')
  </div>

  <!-- Footer -->
  @include('partial.footer')

</div>

<!-- jQuery & jQuery UI -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script> $.widget.bridge('uibutton', $.ui.button) </script>

<!-- Bootstrap Bundle -->
<script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- AdminLTE -->
<script src="{{ asset('asset/dist/js/adminlte.js') }}"></script>

<!-- OverlayScrollbars -->
<script src="{{ asset('asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- Plugins -->
<script src="{{ asset('asset/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('asset/plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('asset/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('asset/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('asset/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('asset/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('asset/plugins/summernote/summernote-bs4.min.js') }}"></script>

<!-- DataTables -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('asset/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('asset/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('asset/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Toastr & Alert -->
<script src="{{ asset('asset/plugins/toastr/toastr.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom JS -->
<script src="{{ asset('js/toastr-handler.js') }}"></script>
<script src="{{ asset('js/confirm.js') }}"></script>

<script>
  // Simpan URL terakhir kecuali halaman home supaya gak looping
  if (window.location.pathname !== '/') {
    localStorage.setItem('lastPage', window.location.href);
  }

  function goLastPage(e) {
    e.preventDefault();
    let lastPage = localStorage.getItem('lastPage');
    if (lastPage && lastPage !== window.location.href) {
      window.location.href = lastPage;
    } else {
      window.location.href = '/';
    }
  }

  // Pas DOM siap, pasang event click di semua link yang punya class 'home-link'
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('a.home-link').forEach(el => {
      el.addEventListener('click', goLastPage);
    });
  });
</script>

@stack('styles')
@stack('scripts')

</body>
</html>
