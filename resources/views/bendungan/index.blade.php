@extends('layouts.master')
@section('title')
    <title>Bendungan</title>
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
<li><a href="/bendungan"><i class="fa fa-dashboard"></i> Bendungan </a></li>
@endsection

@section('content')
<section class="content-header">
    <h1>
        Data Bendungan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bendungan</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Table Data Bendungan</h3>
        </div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Bendungan</th>
                        <th>Nama Bendungan</th>
                        <th>Wilayah</th>
                        <th>Luas (km<sup>2</sup>)</th>
                        <th>Tanggal Dibangun</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_bendungan as $index => $daben)
                    <tr>
                        <td>{{ $index +1 }}.</td>
                        <td>{{ $daben->kode_bendungan }}</td>
                        <td>{{ $daben->nama_bendungan }}</td>
                        <td>{{ $daben->wilayah }}</td>
                        <td>{{ $daben->luas }}</td>
                        <td>{{ \Carbon\Carbon::parse($daben -> tanggal_dibangun)->format('d-m-Y') }}</td>
                        <td>
                            <a href="#" data-d_kode_bendungan="{{ $daben->kode_bendungan }}" data-d_nama_bendungan="{{$daben->nama_bendungan}}"
                                data-d_wilayah="{{ $daben->wilayah }}" data-d_luas="{{ $daben->luas }}" data-d_tanggal_dibangun="{{ \Carbon\Carbon::parse($daben -> tanggal_dibangun)->format('d-m-Y') }}" class="btn btn-warning btn-sm modalMd "
                                title="Edit Data" data-toggle="modal" data-target="#modalEdit"><i
                                    class="glyphicon glyphicon-cog"></i></a>
                            <a href="/bendungan/destroy/{{ $daben->kode_bendungan }}" class="btn btn-danger btn-sm btnDelete" title="Delete Data"><i class="glyphicon glyphicon-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Kode Bendungan</th>
                        <th>Nama Bendungan</th>
                        <th>Wilayah</th>
                        <th>Luas (km<sup>2</sup>)</th>
                        <th>Tanggal Dibangun</th>
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
                <h3 class="box-title">Input New Data Bendungan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="add_form" role="form" action="/bendungan/store" method="post">
                @csrf
                <div class="box-body">
                    <span id="form_result"></span>
                    <div class="form-group">
                        <label for="add_kode_bendungan">Kode Bendungan</label>
                        <input type="text" class="form-control" id="add_kode_bendungan" placeholder="Input kode bendungan"
                            name="add_kode_bendungan" maxlength="5">
                    </div>
                    <div class="form-group">
                        <label for="add_nama_bendungan">Nama Bendungan</label>
                        <input type="text" class="form-control" id="add_nama_bendungan" placeholder="Input nama bendungan"
                            name="add_nama_bendungan" maxlength="80">
                    </div>
                    <div class="form-group">
                        <label for="add_wilayah">Wilayah</label>
                        <input type="text" class="form-control" id="add_wilayah" placeholder="Input wilayah"
                            name="add_wilayah" maxlength="80">
                    </div>
                    <div class="form-group">
                        <label for="add_luas">Luas (km<sup>2</sup>)</label>
                        <input type="text" class="form-control" id="add_luas" placeholder="Input luas"
                            name="add_luas">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Dibangun</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" autocomplete="off" readonly
                                class="form-control pull-right datepicker_purchase_date" id="add_tanggal_dibangun"
                                required="required" name="add_tanggal_dibangun">
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
<!-- /.modal -->

<!-- /.modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialogs" aria-labelledby="myModalLabels">
    <div class="modal-dialog" role="document">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Data Bendungan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/bendungan/update" method="post">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="edit_nama_bendungan">Kode Bendungan</label>
                        <input type="text" class="form-control" id="edit_kode_bendungan" placeholder="Input kode bendungan"
                            name="edit_kode_bendungan" maxlength="80" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_bendungan">Nama Bendungan</label>
                        <input type="text" class="form-control" id="edit_nama_bendungan" placeholder="Input nama bendungan"
                            name="edit_nama_bendungan" maxlength="80">
                    </div>
                    <div class="form-group">
                        <label for="edit_wilayah">Wilayah</label>
                        <input type="text" class="form-control" id="edit_wilayah" placeholder="Input wilayah"
                            name="edit_wilayah" maxlength="80">
                    </div>
                    <div class="form-group">
                        <label for="edit_luas">Luas (km<sup>2</sup>)</label>
                        <input type="text" class="form-control" id="edit_luas" placeholder="Input luas"
                            name="edit_luas">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Dibangun</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" autocomplete="off" readonly
                                class="form-control pull-right datepicker_purchase_date" id="edit_tanggal_dibangun"
                                required="required" name="edit_tanggal_dibangun">
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
<!-- /.modal -->
@endsection
@section('script')
<script>
    $('#modalEdit').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var v_kode_bendungan = button.data('d_kode_bendungan')
        var v_nama_bendungan = button.data('d_nama_bendungan')
        var v_wilayah = button.data('d_wilayah')
        var v_luas = button.data('d_luas')
        var v_tanggal_dibangun = button.data('d_tanggal_dibangun')

        var modal = $(this)

        modal.find('.box-body #edit_kode_bendungan').val(v_kode_bendungan);
        modal.find('.box-body #edit_nama_bendungan').val(v_nama_bendungan);
        modal.find('.box-body #edit_wilayah').val(v_wilayah);
        modal.find('.box-body #edit_luas').val(v_luas);
        modal.find('.box-body input[name="edit_tanggal_dibangun"]').val(v_tanggal_dibangun);
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
                        url: "/bendungan/destroy/" + itemId, // atau ke bisa ganti disini pake variable
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
</script>
@endsection
