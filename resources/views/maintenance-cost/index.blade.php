@extends('layouts.master')
@section('title')
    <title>Maintenance Costs</title>
@endsection
@section('menu')
<li><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard </a></li>
@if(Auth::user()->role == 3)
<li class="treeview active">
  <a href="#">
    <i class="fa fa-table"></i> <span>Master Data</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="/room-inventory"><i class="fa fa-table"></i> <span>Data Room Inventory</span> </a></li>
    <li class="active"><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span> </a></li>
  </ul>
</li>
@endif
@if(Auth::user()->role == 2)
<li class="treeview active">
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
        <li class="active"><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span>
            </a></li>
    </ul>
</li>
@endif
@if(Auth::user()->role == 1)
<li class="treeview active">
    <a href="#">
        <i class="fa fa-print"></i> <span>Report</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="/room-inventory"><i class="fa fa-file"></i> <span>Report Room
                    Inventory</span> </a></li>
        <li class="active"><a href="/maintenance-cost"><i class="fa fa-file"></i> <span>Report Maintenance Cost</span> </a>
        </li>
    </ul>
</li>
@endif
@endsection

@section('content')
<section class="content-header">
    <h1>
        Data Maintenance Cost
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master Data</a></li>
        <li class="active">Data Maintenance Cost</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Table Data Maintenance Cost</h3>
        </div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Date Maintenance</th>
                        <th>Room Number</th>
                        <th>Inventory Code</th>
                        <th>Cost</th>
                        <th>Receipt</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Information</th>
                        <th>Status</th>
                        @if((Auth::user()->role == 2) || (Auth::user()->role == 3))
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_maintenance_costs as $index => $datcos)
                    <tr>
                        <td>{{ $index +1 }}.</td>
                        <td>{{ \Carbon\Carbon::parse($datcos->date_maintenance)->format('d-m-Y') }}</td>
                        <td>{{ $datcos->roomnumber }}</td>
                        <td>{{ $datcos->codeinven }} - {{ $datcos->proname }}</td>
                        <td>{{ $datcos->cost }}</td>
                        <td>
                            <a  href="#"
                                data-d_image = "{{ $datcos->receipt_photo }}"
                                data-toggle="modal"
                                data-target="#modalImage">
                                <img height="50px" src="{{ url('/display_picture/'.$datcos->receipt_photo)}}">
                            </a>
                        </td>
                        <td>{{ $datcos->created_by }}</td>
                        <td>{{ $datcos->updated_by }}</td>
                        <td>{{ $datcos->information }}</td>
                        <td>{{ $datcos->status }}</td>
                        @if((Auth::user()->role == 2) || (Auth::user()->role == 3))
                        <td>
                            <a href="#" 
                            data-d_id="{{ $datcos->id }}"  
                            data-d_information="{{ $datcos->information }}"
                            data-d_status="{{ $datcos->status }}" class="btn btn-warning btn-sm modalMd "
                            title="Edit Data" data-toggle="modal" data-target="#modalEdit"><i
                                    class="glyphicon glyphicon-cog"></i></a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Date Maintenance</th>
                        <th>Room Number</th>
                        <th>Inventory Code</th>
                        <th>Cost</th>
                        <th>Receipt</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Information</th>
                        <th>Status</th>
                        @if((Auth::user()->role == 2) || (Auth::user()->role == 3))
                        <th>Action</th>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

<!-- /.modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Input New Data Maintenance Cost</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="add_form" role="form" action="/maintenance-cost/store" method="post">
                @csrf
                <div class="box-body">
                    <span class="form_result"></span>
                    <div class="form-group">
                        <label>Maintenance Date</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" autocomplete="off" readonly
                                class="form-control pull-right datepicker_purchase_date" id="add_maintenance_date"
                                required="required" name="add_maintenance_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Inventory Code</label>
                        <select class="form-control select2" style="width : 100%;" id="add_inven_code"
                            name="add_inven_code">
                            @foreach($data_room_inventories as $daris)
                            <option value="{{$daris->code_inventory}}">{{$daris->code_inventory}} -
                                {{$daris->productname}} - {{$daris->roomnumber}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="add_cost">Cost</label>
                        <input type="text" class="form-control" id="add_cost" placeholder="Input maintenance cost"
                            name="add_cost">
                    </div>
                    <div class="form-group">
                        <label for="add_photo">Payment Receipt</label>
                        <input type="file" class="form-control" id="add_photo" name="add_photo">
                      </div>
                    <div class="form-group">
                        <label for="add_information">Information</label>
                        <input type="text" class="form-control" id="add_information"
                            placeholder="Input additional information" name="add_information" maxlength="30">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->

<!-- /.modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Data Maintenance Cost</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="edit_form" role="form" action="/maintenance-cost/update" method="post">
                @csrf
                <div class="box-body">
                    <span class="form_result"></span>
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form-group">
                        <label for="edit_information">Information</label>
                        <input type="text" class="form-control" id="edit_information"
                            placeholder="Input additional information" name="edit_information" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="edit_status" name="edit_status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->

<div class="modal fade" id="modalImage" tabindex="-1" role="dialog" aria-labelledby="modalImage">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalMdTitle">Receipt Photo</h4>
            </div>
            <div class="modal-body">
                <img class="img-thumbnail" id="img01">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<form id="print_form" action="/maintenance-cost/print" method="POST" style="display: none;" target="_blank">
    @csrf
    @if($data2 == 1)
        <input type="hidden" id="print_date" name="print_date" value="{{$data}}">
    @else 
        <input type="hidden" id="print_date" name="print_date" value="{{$data1}}">
    @endif
    <input type="hidden" id="report_type" name="report_type" value="{{$data2}}">
</form>

<!-- /.modal -->
<div class="modal fade" id="modalSearch" tabindex="-1" role="dialogs" aria-labelledby="myModalLabels">
    <div class="modal-dialog" role="document">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Search Data Maintenance Costs</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="search_form" role="form" action="/maintenance-cost" method="get">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label>Report Type</label>
                        <select class="form-control" id="add_report_type"
                            name="add_report_type" onchange="hideFunction()">
                            <option value="1">Report Maintenance Costs</option>
                            <option value="2">Report Urgency</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Maintenance Date</label>
                        <div class="input-group date" style="width : 100%;">
                            <input type="text" class="form-control pull-right" id="reservation" name="range">
                        </div>
                        <div class="input-group date" style="width : 100%;">
                            <input type="text" class="form-control datepicker_report" id="add_date_urgency" name="add_date_urgency">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    @if(Auth::user()->role == 3)
    $(function () { 
    var addButton = $('<a href="#" id="add_data" class="btn btn-primary btn-sm modalMd" title="Add New Data" data-toggle="modal" data-target="#modalAdd" style="margin-right: 15px;">Add New Data</span></a>');
    $("#example1_length").prepend(addButton);
    $('.modalMd').on("click",function(){
      $('#add_form')[0].reset();
      $('.form_result').text('');
    });
    });
    @endif
    @if(Auth::user()->role == 1)
    $(function () {
        var allButton = $(
            '<a href="/maintenance-cost" id="show_all" class="btn btn-primary btn-sm" title="Show All" style="margin-right: 15px;">Show All</a>'
        );
        $("#example1_length").prepend(allButton);
        var printButton = $(
            '<a href="#" id="print_data" class="btn btn-primary btn-sm" title="Print Data" style="margin-right: 15px;">Print Data</a>'
        );
        $("#show_all").before(printButton);
        var searchData = $(
            '<a href="#" id="search_data" class="btn btn-primary btn-sm modalMd" title="Search Data" data-toggle="modal" data-target="#modalSearch" style="margin-right: 15px;">Search Data</span></a>'
        );
        $("#print_data").before(searchData);

        $("#print_data").click(function() {
            document.getElementById('print_form').submit();
        });
    });
    @endif
    $('#add_date_urgency').hide();
    function hideFunction() {
        var x = document.getElementById("add_report_type").value;
        if(x == 1){
            $('#reservation').show();
            $('#add_date_urgency').hide();
        } else {
            $('#add_date_urgency').show();
            $('#reservation').hide();
        }
        
    }

    $('#reservation').daterangepicker({
        locale: {
            format: 'DD-MM-YYYY'
        }
    });

    $('#add_date_urgency').datepicker({
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months",
        autoclose: true
    });

    $('#modalEdit').on('shown.bs.modal', function (event) {

        var button = $(event.relatedTarget)

        var v_id = button.data('d_id')
        var v_information = button.data('d_information')
        var v_status = button.data('d_status')

        var modal = $(this)

        modal.find('.box-body #edit_id').val(v_id);
        modal.find('.box-body #edit_information').val(v_information);
        modal.find('.box-body #edit_status').val(v_status);
    });

    $('#add_form').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "{{ url('/maintenance-cost/store') }}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                var html = '';
                if (data.errors) {
                    swal({
                        title: "Something went wrong!",
                        text: "Something wrong with your data!",
                        icon: "error",
                    });
                    html = '<div class="alert alert-danger">';
                    for (var count = 0; count < data.errors.length; count++) {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                } else {
                    event.preventDefault();
                    swal("Success", "Data maintenance cost added successfully!", "success").then((value) => {
                        $('#add_form')[0].reset();
                        $('#modalAdd').modal('hide');
                        url = "/maintenance-cost";
                        window.location.replace(url);
                    });
                }
                $('.form_result').html(html);
            }
        })
    });

    $('#edit_form').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "{{ url('/maintenance-cost/update') }}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                var html = '';
                if (data.errors) {
                    swal({
                        title: "Something went wrong!",
                        text: "Something wrong with your data!",
                        icon: "error",
                    });
                    html = '<div class="alert alert-danger">';
                    for (var count = 0; count < data.errors.length; count++) {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                } else {
                    event.preventDefault();
                    swal("Success", "Data maintenance cost changed successfully!", "success").then((value) => {
                        $('#edit_form')[0].reset();
                        $('#modalEdit').modal('hide');
                        url = "/maintenance-cost";
                        window.location.replace(url);
                    });
                }
                $('.form_result').html(html);
            }
        })
    });

</script>
<script>
$(function() {
    $('#modalImage').on("shown.bs.modal", function (e) {
      var button = $(e.relatedTarget)

      var v_image = button.data('d_image')

      var path = '/display_picture/'+ v_image

      // var modal = $(this)
      
      var modalImg = document.getElementById("img01");

      modalImg.src = path;
  

    });
});
</script>
@endsection
