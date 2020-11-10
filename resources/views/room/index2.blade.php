@extends('layouts.layout')

@section('title')
  
<title>Simply Apartment | Data Room</title>

@endsection

@section('menu')

<li><a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a></li>
<li><a href="/user"><i class="fa fa-table"></i> <span>Data User</span> </a></li>
<li class="active"><a href="/room"><i class="fa fa-table"></i> <span>Data Room</span> </a></li>
<li><a href="/inventory"><i class="fa fa-table"></i> <span>Data Inventory</span> </a></li>
<li><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span> </a></li>

@endsection

@section('content')

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <!-- /.box-header -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Rooms</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Room Number</th>
                <th>Room Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data_rooms as $daroms)
              <tr>
                <td>{{ $daroms->room_number }}</td>
                <td>{{ $daroms->room_type }}</td>
                <td>
                  <a href="#" 
                       data-d_id             ="{{ $daroms->id }}"
                       data-d_room_number    ="{{ $daroms->room_number }}"
                       data-d_room_type      ="{{ $daroms->room_type }}"
                       class="btn btn-warning btn-sm modalMd " title="Edit Data" data-toggle="modal" data-target="#modalEdit"><i class="glyphicon glyphicon-cog"></i></a>
                  <a href="/room/destroy/{{ $daroms->id }}" class="btn btn-danger btn-sm btnDelete" title="Delete Data"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Room Number</th>
                <th>Room Type</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

<!-- /.modal -->
<meta name="_token" content="{{csrf_token()}}" />
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="box box-primary">
      <div class="box-header with-border">
        <div class="alert alert-danger" style="display:none"></div>
        <h3 class="box-title">Input New Data Room</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
	    <form role="form" action="/room/store" method="post">
        <div class="box-body">
          <div class="form-group">
            <label for="add_room_number">Room Number</label>
            <input type="text" class="form-control" id="add_room_number" placeholder="Input product name" required="required" name="add_room_number">
          </div>
          <div class="form-group">
            <label for="add_room_type">Room Type</label>
            <input type="text" class="form-control" id="add_room_type" placeholder="Input model of product" required="required" name="add_room_type">
          </div>
	      </div>
	      <!-- /.box-body -->
	      <div class="box-footer">
	        <button type="submit" class="btn btn-primary" id="ajaxSubmit">Submit</button>
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
        {{csrf_field()}}
        <div class="box-body">
          <input type="hidden" id="edit_id" required="required" name="edit_id">
          <div class="form-group">
            <label for="edit_room_number">Room Number</label>
            <input type="text" class="form-control" id="edit_room_number" placeholder="Input product name" required="required" name="edit_room_number">
          </div>
          <div class="form-group">
            <label for="edit_room_type">Room Type</label>
            <input type="text" class="form-control" id="edit_room_type" placeholder="Input model of product" required="required" name="edit_room_type">
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

@section('datatables')
<script>
  $('#modalEdit').on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var v_id = button.data('d_id')
    var v_room_number = button.data('d_room_number')
    var v_room_type = button.data('d_room_type')

    var modal = $(this)

    modal.find('.box-body #edit_id').val(v_id);
    modal.find('.box-body #edit_room_number').val(v_room_number);
    modal.find('.box-body #edit_room_type').val(v_room_type);
  });

  $('.btnDelete').click(function(e){
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
        var itemId  = $(this).attr('href').split('/')[3]; 
        $.ajax({
          type: "GET",
          url: "/room/destroy/"+itemId, // atau ke bisa ganti disini pake variable
          success: function(data) {
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
          error: function(err) {
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
<script>
  jQuery(document).ready(function(){
    jQuery('#ajaxSubmit').click(function(e){
      e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    jQuery.ajax({
      url: "{{ url('/room/store') }}",
      method: 'post',
      data: {
        add_room_number: jQuery('#add_room_number').val(),
        add_room_type: jQuery('#add_room_type').val()
      },
      success: function(result){
        if(result.errors){
          jQuery('.alert-danger').html('<strong>Whoops!</strong> There were some problems with your input.');

          jQuery.each(result.errors, function(key, value){
            jQuery('.alert-danger').show();
            jQuery('.alert-danger').append('<li>'+value+'</li>');
          });
        }else{
          jQuery('.alert-danger').hide();
          $('#modalAdd').modal('hide');
          url = "/room";
          window.location.replace(url);
        }
      }});
    });
  });
</script>
@endsection