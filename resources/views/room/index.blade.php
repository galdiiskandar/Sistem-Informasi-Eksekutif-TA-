@extends('layouts.master')
@section('title')
    <title>Room</title>
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
        <li class="active"><a href="/room"><i class="fa fa-table"></i> <span>Data Room</span> </a></li>
        <li><a href="/product"><i class="fa fa-table"></i> <span>Data Product</span> </a></li>
        <li><a href="/room-inventory"><i class="fa fa-table"></i> <span>Data Room Inventory</span> </a></li>
        <li><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span> </a></li>
    </ul>
</li>
@endsection

@section('content')
<section class="content-header">
    <h1>
        Data Room
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master Data</a></li>
        <li class="active">Data Room</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Table Data Room</h3>
        </div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Room Status</th>
                        <th>Additional Information</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_rooms as $index => $daroms)
                    <tr>
                        <td>{{ $index +1 }}.</td>
                        <td>{{ $daroms->room_number }}</td>
                        <td>{{ $daroms->room_type }}</td>
                        <td>{{ $daroms->status }}</td>
                        <td>{{ $daroms->information }}</td>
                        <td>
                            <a href="#" data-d_id="{{ $daroms->id }}" data-d_room_status="{{$daroms->status}}"
                                data-d_information="{{ $daroms->information }}" class="btn btn-warning btn-sm modalMd "
                                title="Edit Data" data-toggle="modal" data-target="#modalEdit"><i
                                    class="glyphicon glyphicon-cog"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Room Status</th>
                        <th>Additional Information</th>
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
                <h3 class="box-title">Input New Data Room</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="add_form" role="form" action="/room/store" method="post">
                @csrf
                <div class="box-body">
                    <span id="form_result"></span>
                    <div class="form-group">
                        <label for="add_room_number">Room Number</label>
                        <input type="text" class="form-control" id="add_room_number" placeholder="Input room number"
                            name="add_room_number" maxlength="5">
                    </div>
                    <div class="form-group">
                        <label>Room Type</label>
                        <select class="form-control" id="add_room_type" name="add_room_type">
                            <option value="Single">Single</option>
                            <option value="Double">Double</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Room Status</label>
                        <select class="form-control" id="add_room_status" name="add_room_status">
                            <option value="Ready">Ready</option>
                            <option value="Not ready">Not ready</option>
                        </select>
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
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialogs" aria-labelledby="myModalLabels">
    <div class="modal-dialog" role="document">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Data Room</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/room/update" method="post">
                @csrf
                <div class="box-body">
                    <input type="hidden" id="edit_id" required="required" name="edit_id">
                    <div class="form-group">
                        <label>Room Status</label>
                        <select class="form-control" id="edit_room_status" name="edit_room_status">
                            <option value="Ready">Ready</option>
                            <option value="Not ready">Not ready</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_information">Information</label>
                        <input type="text" class="form-control" id="edit_information"
                            placeholder="Input additional information" name="edit_information" maxlength="30">
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
        var v_room_status = button.data('d_room_status')
        var v_information = button.data('d_information')

        var modal = $(this)

        modal.find('.box-body #edit_id').val(v_id);
        modal.find('.box-body #edit_room_status').val(v_room_status);
        modal.find('.box-body #edit_information').val(v_information);
    });

    $('.btnDelete').click(function (e) {
        e.preventDefault();
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var itemId = $(this).attr('href').split('/')[3];
                    $.ajax({
                        type: "GET",
                        url: "/room/destroy/" + itemId, // atau ke bisa ganti disini pake variable
                        success: function (data) {
                            swal({
                                title: "Successfully deleted!",
                                text: "success",
                                icon: "success",
                            }).then((data) => {
                                if (data) {
                                    location.reload();
                                }
                            });
                        },
                        error: function (err) {
                            swal({
                                title: "Something went wrong!",
                                text: "Something wrong with your data!",
                                icon: "error",
                            });
                        }
                    });
                } else {
                    swal({
                        title: "You're safe!",
                        text: "Data is not deleted!",
                        icon: "success",
                    });
                }
            });
    });

    $('#add_form').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: "{{ url('/room/store') }}",
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
                    swal("Success", "Data room added successfully!", "success").then((value) => {
                        $('#add_form')[0].reset();
                        $('#modalAdd').modal('hide');
                        url = "/room";
                        window.location.replace(url);
                    });
                }
                $('#form_result').html(html);
            }
        })
    });

</script>
@endsection
