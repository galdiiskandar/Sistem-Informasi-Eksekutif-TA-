@extends('layouts.master')
@section('title')
    <title>Dashboard</title>
@endsection
@section('menu')

<li class="active"><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard </a></li>
@if(Auth::user()->role == 3)
<li class="treeview">
  <a href="#">
    <i class="fa fa-table"></i> <span>Master Data</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="/room-inventory"><i class="fa fa-table"></i> <span>Data Room Inventory</span> </a></li>
    <li><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span> </a></li>
  </ul>
</li>
@endif
@if(Auth::user()->role == 2)
<li class="treeview">
  <a href="#">
    <i class="fa fa-table"></i> <span>Master Data</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="/user"><i class="fa fa-table"></i> <span>Data User</span> </a></li>
    <li><a href="/room"><i class="fa fa-table"></i> <span>Data Room</span> </a></li>
    <li><a href="/product"><i class="fa fa-table"></i> <span>Data Product</span> </a></li>
    <li><a href="/room-inventory"><i class="fa fa-table"></i> <span>Data Room Inventory</span> </a></li>
    <li><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span> </a></li>
  </ul>
</li>
<li><a href="/bendungan"><i class="fa fa-dashboard"></i> Bendungan </a></li>
@endif
@if(Auth::user()->role == 1) 
<li class="treeview">
    <a href="#">
        <i class="fa fa-print"></i> <span>Report</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="/room-inventory"><i class="fa fa-file"></i> <span>Report Room
                    Inventory</span> </a></li>
        <li><a href="/maintenance-cost"><i class="fa fa-file"></i> <span>Report Maintenance Cost</span> </a>
        </li>
    </ul>
</li>
@endif
@endsection

@section('content')
<section class="content-header">
    <h1>
      Dashboard
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @if (session()->has('message'))
        <div class="alert alert-success" style="opacity: 0.9;">
            <strong>Login Success!</strong>
        </div>
    @endif
    @if (($notification['urgency'] != 0) && (Auth::user()->role == 1))
        <div class="alert alert-danger" id="notification" style="cursor : pointer;">
        <strong>Warning!</strong> {{$notification['urgency']}} inventories over maintenance costs
        </div>
    @endif
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{$data_count_RI}}</h3>

            <p>Room Inventories</p>
          </div>
          <div class="icon">
            <i class="ion ion-cube"></i>
          </div>
          
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{$data_count_RIVG}}</h3>

            <p>Very Good Condition</p>
          </div>
          <div class="icon">
            <i class="ion-checkmark-circled" style="font-size: 90px;"></i>
          </div>
          
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{$data_count_RIG}}</h3>

            <p>Good Condition</p>
          </div>
          <div class="icon">
            <i class="ion-alert-circled"></i>
          </div>
          
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{$data_count_RIB}}</h3>

            <p>Bad Condition</p>
          </div>
          <div class="icon">
            <i class="ion-close-circled"></i>
          </div>
          
        </div>
      </div>
      <!-- ./col -->
    </div>
    <form id="notif_form" action="/maintenance-cost" method="GET" style="display: none;">
      @csrf
      <input type="hidden" id="add_report_type" name="add_report_type" value="2">
      <input type="hidden" id="add_date_urgency" name="add_date_urgency" value="01-2020">
    </form>
    @if(Auth::user()->role == 1)
    <div class="row">
      <!-- /.col (LEFT) -->
      <div class="col-md-12">
        <!-- BAR CHART -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Bar Chart</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <form id="form_search" action="/dashboard" method="GET">
              @csrf
              <input type="text" class="datepicker_chart" style="height : 30px;" id="chart_year" name="chart_year" value="{{$data_year}}">
            </form>
          </div>
          <div class="box-body chart-responsive" id="container" style="margin-right: 10px;">
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col (RIGHT) -->
      {{-- <!-- /.col (LEFT) -->
      <div class="col-md-6">

        <!-- BAR CHART -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Bar Chart</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body chart-responsive">
            <div id="container" style="height: 300px;"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
      <!-- /.col (RIGHT) --> --}}
    </div>
    @endif
    <!-- /.row -->
  </section>
  <!-- /.content -->
@endsection

@section('script')
<script>
  $(".alert.alert-success").fadeTo(2000, 0.9).slideUp(500, function(){
      $(".alert.alert-success").slideUp(500);
  });

  $("#notification").click(function() {
      document.getElementById('notif_form').submit();
  });

  $('.datepicker_chart').datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "years",
    autoclose: true
  });
  @if(Auth::user()->role == 1)
  $(function () {
        var searchData = $(
            '<a href="#" id="search_data" class="btn btn-primary btn-sm modalMd" title="Search Data" data-toggle="modal" data-target="#modalSearch" style="margin-left: 15px; margin-bottom: 4px;">Search Data</span></a>'
        );
        $("#chart_year").after(searchData);

        $("#search_data").click(function() {
            document.getElementById('form_search').submit();
        });
  });

  Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Maintenance Costs'
    },
    subtitle: {
        text: 'Simply Apartment'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Rp.'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>Rp. {point.y:f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: {!!json_encode($data_maintenance_costs)!!}
  });
  @endif
</script>
@endsection