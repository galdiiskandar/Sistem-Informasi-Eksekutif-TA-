@extends('layouts.master')
@section('title')
    <title>Room Inventory</title>
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
    <li class="active"><a href="/room-inventory"><i class="fa fa-table"></i> <span>Data Room Inventory</span> </a></li>
    <li><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span> </a></li>
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
        <li class="active"><a href="/room-inventory"><i class="fa fa-table"></i> <span>Data Room Inventory</span> </a>
        </li>
        <li><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span> </a></li>
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
        <li class="active"><a href="/room-inventory"><i class="fa fa-file"></i> <span>Report Room
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
        Data Room Iventory
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master Data</a></li>
        <li class="active">Data Room Inventory</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Table Data Room Iventory</h3>
        </div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Code Inventory</th>
                        <th>Room Number</th>
                        <th>Product Name</th>
                        <th>Condition</th>
                        <th>Information</th>
                        <th>Status</th>
                        <th>Last Update</th>
                        @if((Auth::user()->role == 2) || (Auth::user()->role == 3))
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_room_inventories as $index => $daroin)
                    <tr>
                        <td>{{ $index +1 }}.</td>
                        <td>{{ $daroin->code_inventory }}</td>
                        <td>{{ $daroin->roomnumber }}</td>
                        <td>{{ $daroin->productname }}</td>
                        <td>{{ $daroin->condition }}</td>
                        <td>{{ $daroin->information }}</td>
                        <td>{{ $daroin->status }}</td>
                        <td>{{ \Carbon\Carbon::parse($daroin->updated_at)->format('d-m-Y') }}</td>
                        @if((Auth::user()->role == 2) || (Auth::user()->role == 3))
                        <td>
                            <a href="#" data-d_code_inventory="{{ $daroin->code_inventory }}"
                                data-d_product_serial="{{ $daroin->product_serial_number }}"
                                data-d_purchase_date="{{ $daroin->purchase_date }}"
                                data-d_condition="{{ $daroin->condition }}"
                                data-d_information="{{ $daroin->information }}" data-d_status="{{ $daroin->status }}" class="btn btn-warning btn-sm modalMd "
                                title="Edit Data" data-toggle="modal" data-target="#modalEdit"><i
                                    class="glyphicon glyphicon-cog"></i></a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Code Inventory</th>
                        <th>Room Number</th>
                        <th>Product Name</th>
                        <th>Condition</th>
                        <th>Information</th>
                        <th>Status</th>
                        <th>Last Update</th>
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
                <h3 class="box-title">Input New Data Room Inventory</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="add_form" role="form" action="/room-inventory/store" method="post">
                @csrf
                <div class="box-body">
                    <span class="form_result"></span>
                    <div class="form-group">
                        <label>Room Number</label>
                        <select class="form-control select2" style="width : 100%;" id="add_room_id" name="add_room_id">
                            @foreach($data_rooms->where('status','Ready') as $darom)
                            <option value="{{$darom->id}}">{{$darom->room_number}} - {{$darom->room_type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product Name</label>
                        <select class="form-control select2" style="width : 100%;" id="add_product_id"
                            name="add_product_id">
                            @foreach($data_products->where('status','Active') as $dapro)
                            <option value="{{$dapro->id}}">{{$dapro->product_name}} - {{$dapro->model}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="add_product_serial">Product Serial Number</label>
                        <input type="text" class="form-control" id="add_product_serial"
                            placeholder="Input product serial number" name="add_product_serial" maxlength="20">
                    </div>
                    <div class="form-group">
                        <label>Purchase Date</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" autocomplete="off" readonly
                                class="form-control pull-right datepicker_purchase_date" id="add_purchase_date"
                                required="required" name="add_purchase_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Condition</label>
                        <div class="form-group">
                            <div>
                                <input type="radio" class="flat-red" name="add_condition" value="Very good" checked>
                                Very good
                            </div>
                            <div>
                                <input type="radio" class="flat-red" name="add_condition" value="Good">
                                Good
                            </div>
                            <div>
                                <input type="radio" class="flat-red" name="add_condition" value="Bad">
                                Bad
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="add_information">Information</label>
                        <input type="text" class="form-control" id="add_information"
                            placeholder="Input additional information" name="add_information" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="add_status" name="add_status">
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

<!-- /.modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialogs" aria-labelledby="myModalLabels">
    <div class="modal-dialog" role="document">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Data Room Inventory</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="edit_form" role="form" action="/room-inventory/update" method="post">
                @csrf
                <div class="box-body">
                    <span class="form_result"></span>
                    <input type="hidden" id="edit_code_inventory" name="edit_code_inventory">
                    @if(Auth::user()->role == 2)
                    <div class="form-group">
                        <label for="edit_product_serial">Product Serial Number</label>
                        <input type="text" class="form-control" id="edit_product_serial"
                            placeholder="Input product serial number" name="edit_product_serial" maxlength="20">
                    </div>
                    @else
                    <div class="form-group">
                        <label for="edit_product_serial">Product Serial Number</label>
                        <input type="text" class="form-control" id="edit_product_serial"
                            placeholder="Input product serial number" name="edit_product_serial" maxlength="20" readonly>
                    </div>
                    @endif
                    @if(Auth::user()->role == 2)
                    <div class="form-group">
                        <label>Purchase Date</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" autocomplete="off" readonly
                                class="form-control pull-right datepicker_purchase_date" id="edit_purchase_date"
                                required="required" name="edit_purchase_date">
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <label>Condition</label>
                        <div class="form-group" id="condition-radio">
                            <div>
                                <input type="radio" class="flat-red" id="e_c_a" name="edit_condition" value="Very good">
                                Very good
                            </div>
                            <div>
                                <input type="radio" class="flat-red" id="e_c_b" name="edit_condition" value="Good">
                                Good
                            </div>
                            <div>
                                <input type="radio" class="flat-red" id="e_c_c" name="edit_condition" value="Bad">
                                Bad
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_information">Information</label>
                        <input type="text" class="form-control" id="edit_information"
                            placeholder="Input additional information" name="edit_information" maxlength="30">
                    </div>
                    @if(Auth::user()->role == 2)
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="edit_status" name="edit_status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    @endif
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
<div class="modal fade" id="modalSearch" tabindex="-1" role="dialogs" aria-labelledby="myModalLabels">
    <div class="modal-dialog" role="document">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Search Data Room Inventory</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="search_form" role="form" action="/room-inventory" method="get">
                @csrf
                <div class="box-body">
                    <span class="form_result"></span>
                    <div class="form-group">
                        <label>Room Number</label>
                        <select class="form-control select2" style="width : 100%;" id="search_room_id"
                            name="search_room_id">
                            <option value="">ALL</option>
                            @foreach($data_rooms as $darom)
                            <option value="{{$darom->room_number}}">{{$darom->room_number}} - {{$darom->room_type}}
                            </option>
                            @endforeach
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

<form id="print_form" action="/room-inventory/print" method="POST" style="display: none;" target="_blank">
    @csrf
    <input type="hidden" id="print_room_id" name="print_room_id" value="{{$data}}">
</form>
<!-- /.modal -->

@endsection
@section('script')
<script>
    $('.modalMd').on("click",function(){
        $('#add_form')[0].reset();
        $('.form_result').text('');
    });
    @if(Auth::user()->role == 1)
    $(function () {
        var allButton = $(
            '<a href="/room-inventory" id="show_all" class="btn btn-primary btn-sm" title="Show All" style="margin-right: 15px;">Show All</a>'
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

    $('#modalEdit').on('shown.bs.modal', function (event) {

        var button = $(event.relatedTarget)

        var v_code_inventory = button.data('d_code_inventory')
        var v_product_serial = button.data('d_product_serial')
        var v_purchase_date = button.data('d_purchase_date')
        var v_information = button.data('d_information')
        var v_status = button.data('d_status')

        var modal = $(this)

        modal.find('.box-body #edit_code_inventory').val(v_code_inventory);
        modal.find('.box-body #edit_product_serial').val(v_product_serial);
        modal.find('.box-body input[name="edit_purchase_date"]').val(v_purchase_date);
        modal.find('.box-body #edit_information').val(v_information);
        modal.find('.box-body #edit_status').val(v_status);

        if (button.data('d_condition') == "Very good") {
            $('#condition-radio > div:first-child > div').attr({
                'aria-checked': "true"
            }).addClass('checked');
            $('#condition-radio > div + div > div').attr({
                'aria-checked': "false"
            }).removeClass('checked');
            $('#condition-radio > div + div + div > div').attr({
                'aria-checked': "false"
            }).removeClass('checked');
            $('#e_c_a').attr('checked', true);
        } else if (button.data('d_condition') == "Good") {
            $('#condition-radio > div + div > div').attr({
                'aria-checked': "true"
            }).addClass('checked');
            $('#condition-radio > div:first-child > div').attr({
                'aria-checked': "false"
            }).removeClass('checked');
            $('#condition-radio > div + div + div > div').attr({
                'aria-checked': "false"
            }).removeClass('checked');
            $('#e_c_b').attr('checked', true);
        } else if (button.data('d_condition') == "Bad") {
            $('#condition-radio > div + div > div').attr({
                'aria-checked': "false"
            }).removeClass('checked');
            $('#condition-radio > div + div + div > div').attr({
                'aria-checked': "true"
            }).addClass('checked');
            $('#condition-radio > div:first-child > div').attr({
                'aria-checked': "false"
            }).removeClass('checked');
            $('#e_c_c').attr('checked', true);
        }
    });
    
    $('#add_form').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "{{ url('/room-inventory/store') }}",
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
                    swal("Success", "Data room inventory added successfully!", "success").then((value) => {
                        $('#add_form')[0].reset();
                        $('#modalAdd').modal('hide');
                        url = "/room-inventory";
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
            url: "{{ url('/room-inventory/update') }}",
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
                swal("Success", "Data room inventory changed successfully!", "success").then((value) => {
                    $('#edit_form')[0].reset();
                    $('#modalEdit').modal('hide');
                    url = "/room-inventory";
                    window.location.replace(url);
                });
                }
                $('.form_result').html(html);
            }
        })
    });

</script>
@endsection