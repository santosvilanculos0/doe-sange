@props(['script' => null])

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="{{ str_replace('_', '-', app()->getLocale()) }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"
    rel="stylesheet">
  <!-- Ionicons -->
  <link
    href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
    rel="stylesheet">
  <!-- Tempusdominus Bootstrap 4 -->
  <link
    href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"
    rel="stylesheet">
  <!-- iCheck -->
  <link href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"
    rel="stylesheet">
  <!-- JQVMap -->
  <link href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
  <!-- Theme style -->
  <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">
  <!-- overlayScrollbars -->
  <link
    href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}"
    rel="stylesheet">
  <!-- Daterange picker -->
  <link href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}"
    rel="stylesheet">
  <!-- summernote -->
  <link href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}"
    rel="stylesheet">
  <!-- DataTables -->
  <link
    href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}"
    rel="stylesheet">
  <link
    href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"
    rel="stylesheet">
  <link
    href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"
    rel="stylesheet">
</head>

<body class="dark-mode hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div
      class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake"
        src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
        height="60" width="60">
    </div>

    <!-- Navbar -->
    <x-nav />
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <x-aside />

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      {{ $slot }}
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; {{ date('Y') }} <a
          href="" target="_blank">Santos Vilanculos</a>.</strong>
      Todos direitos reservados.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}">
  </script>

  <!-- ChartJS -->
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
  <!-- Sparkline -->
  <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
  <!-- JQVMap -->
  <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}">
  </script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script
    src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
  </script>
  <!-- Summernote -->
  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script
    src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
  </script>
  <!-- DataTables  & Plugins -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}">
  </script>
  <script
    src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}">
  </script>
  <script
    src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
  </script>
  <script
    src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
  </script>
  <script
    src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}">
  </script>
  <script
    src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}">
  </script>
  <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
  <script
    src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}">
  </script>
  <script
    src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}">
  </script>
  <script
    src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}">
  </script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  {{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  {{-- <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script> --}}

  {{ $script }}
</body>

</html>
