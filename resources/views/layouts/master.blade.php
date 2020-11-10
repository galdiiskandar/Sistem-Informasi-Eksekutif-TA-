<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @yield('title')
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/plugins/iCheck/all.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/bower_components/select2/dist/css/select2.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris charts -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/bower_components/morris.js/morris.css')}}">
    <!-- daterange picker -->
  <link rel="stylesheet" href="{{ url('temp_dashboard/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="/dashboard" class="logo">
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Simply</b>Apartment</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="/display_picture/{{Auth::user()->photo}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="/display_picture/{{Auth::user()->photo}}" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->name}}
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/user/profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">Sign out</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/display_picture/{{Auth::user()->photo}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        @yield('menu')
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ url('temp_dashboard/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('temp_dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{ url('temp_dashboard/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ url('temp_dashboard/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ url('temp_dashboard/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('temp_dashboard/dist/js/demo.js')}}"></script>
<!-- Select2 -->
<script src="{{ url('temp_dashboard/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- DataTables -->
<script src="{{ url('temp_dashboard/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('temp_dashboard/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{ url('temp_dashboard/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ url('temp_dashboard/plugins/iCheck/icheck.min.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- ChartJS -->
<script src="{{ url('temp_dashboard/bower_components/chart.js/Chart.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{ url('temp_dashboard/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{ url('temp_dashboard/bower_components/morris.js/morris.min.js')}}"></script>
<script src="{{ url('temp_dashboard/plugins/code/highcharts.js')}}"></script>
<script src="{{ url('temp_dashboard/plugins/code/modules/exporting.js')}}"></script>
<script src="{{ url('temp_dashboard/plugins/code/modules/export-data.js')}}"></script>
<script src="{{ url('temp_dashboard/plugins/code/modules/accessibility.js')}}"></script>
<!-- date-range-picker -->
<script src="{{ url('temp_dashboard/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ url('temp_dashboard/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  });
  
  $(function () { 
    $('.select2').select2()

    $('#example1').DataTable();
    @if(Auth::user()->role == 2)
    var addButton = $('<a href="#" id="add_data" class="btn btn-primary btn-sm modalMd" title="Add New Data" data-toggle="modal" data-target="#modalAdd" style="margin-right: 15px;">Add New Data</span></a>');
    $("#example1_length").prepend(addButton);
    @endif
  });

  $('.datepicker_purchase_date').datepicker({
    format: "dd-mm-yyyy",
    autoclose: true,
    todayHighlight: true
  });

  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
  });
</script>
@yield('script')
</body>
</html>
