@extends('layouts.master')
@section('title')
    <title>Product</title>
@endsection
@section('menu')
<li><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard </a></li>
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
        <li class="active"><a href="/product"><i class="fa fa-table"></i> <span>Data Product</span> </a></li>
        <li><a href="/room-inventory"><i class="fa fa-table"></i> <span>Data Room Inventory</span> </a></li>
        <li><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span> </a></li>
    </ul>
</li>
@endsection

@section('content')
<section class="content-header">
    <h1>
        Data Product
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master Data</a></li>
        <li class="active">Data Product</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Table Data Product</h3>
        </div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Model</th>
                        <th>Information</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_products as $index => $dapro)
                    <tr>
                        <td>{{ $index +1 }}.</td>
                        <td>{{ $dapro->product_name }}</td>
                        <td>{{ $dapro->model }}</td>
                        <td>{{ $dapro->information }}</td>
                        <td>{{ $dapro->status }}</td>
                        {{-- <td>{{ \Carbon\Carbon::parse($dapro->updated_at)->locale('id')->diffForHumans() }}</td>
                        --}}
                        <td>
                            <a href="#" data-d_id="{{ $dapro->id }}" data-d_information="{{ $dapro->information }}"
                                data-d_status="{{ $dapro->status }}"
                                class="btn btn-warning btn-sm modalMd " title="Edit Data" data-toggle="modal"
                                data-target="#modalEdit"><i class="glyphicon glyphicon-cog"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Model</th>
                        <th>Information</th>
                        <th>Status</th>
                        <th>Action</th>
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
                <h3 class="box-title">Input New Data Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="add_form" role="form" action="/product/store" method="post">
                @csrf
                <div class="box-body">
                    <span class="form_result"></span>
                    <div class="form-group">
                        <label for="add_product_name">Product Name</label>
                        <input type="text" class="form-control" id="add_product_name" placeholder="Input product name"
                            name="add_product_name" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="add_model">Product Model</label>
                        <input type="text" class="form-control" id="add_model" placeholder="Input product model"
                            name="add_model" maxlength="25">
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
                <h3 class="box-title">Edit Data Product</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="edit_form" role="form" action="/product/update" method="post">
                @csrf
                <div class="box-body">
                    <span class="form_result"></span>
                    <input type="hidden" id="edit_id" required="required" name="edit_id">
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
@endsection
@section('script')
<script>
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
            url: "{{ url('/product/store') }}",
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
                } else if (data.match) {
                    swal({
                        title: "Something went wrong!",
                        text: "Something wrong with your data!",
                        icon: "error",
                    });
                    $('#add_form')[0].reset();
                    html = '<div class="alert alert-danger">';
                    html += 'The product already exist.';
                    html += '</div>';
                } else {
                    event.preventDefault();
                    swal("Success", "Data product added successfully!", "success").then((value) => {
                        $('#add_form')[0].reset();
                        $('#modalAdd').modal('hide');
                        url = "/product";
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
            url: "{{ url('/product/update') }}",
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
                } else if (data.match) {
                    swal({
                        title: "Something went wrong!",
                        text: "Something wrong with your data!",
                        icon: "error",
                    });
                    html = '<div class="alert alert-danger">';
                    html += 'The product already exist.';
                    html += '</div>';
                } else {
                    event.preventDefault();
                    swal("Success", "Data product changed successfully!", "success").then((value) => {
                        $('#edit_form')[0].reset();
                        $('#modalEdit').modal('hide');
                        url = "/product";
                        window.location.replace(url);
                    });
                }
                $('.form_result').html(html);
            }
        })
    });
</script>
@endsection
