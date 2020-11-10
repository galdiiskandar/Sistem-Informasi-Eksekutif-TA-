@extends('layouts.layout')

@section('title')
  
<title>Simply Apartment | Data Maintenance Cost</title>

@endsection

@section('menu')

<li><a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a></li>
<li><a href="/user"><i class="fa fa-table"></i> <span>Data User</span> </a></li>
<li><a href="/room"><i class="fa fa-table"></i> <span>Data Room</span> </a></li>
<li><a href="/inventory"><i class="fa fa-table"></i> <span>Data Inventory</span> </a></li>
<li class="active"><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span> </a></li>

@endsection

@section('content')

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <!-- /.box-header -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Maintenance Cost</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Date Maintenance</th>
                <th>Total Cost</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data_maintenance_cost as $datcos)
                <tr>
                  <td>{{ $datcos->date_maintenance }}</td>
                  <td>{{ $datcos->total_cost }}</td>
                  <td>
                    <a href="#" 
                      data-d_id ="{{ $datcos->id }}"
                      data-d_date_maintenance ="{{ $datcos->date_maintenance }}"
                      data-d_total_cost ="{{ $datcos->total_cost }}"
                      class="btn btn-warning btn-sm modalMd " title="Edit Data" data-toggle="modal" data-target="#modalEdit"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="/user/destroy/{{ $datcos->id }}" class="btn btn-danger btn-sm btnDelete" title="Delete Data"><i class="glyphicon glyphicon-trash"></i></a>
                    <a href="#" class="btn btn-danger btn-sm btnDetail" title="Detail"><i class="glyphicon glyphicon-list-alt"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Date Maintenance</th>
                <th>Total Cost</th>
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
{{-- <meta name="_token" content="{{csrf_token()}}" /> --}}
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="box box-primary">
      <div class="box-header with-border">
        <div class="alert alert-danger" style="display:none"></div>
        <h3 class="box-title">Input New Data User</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="/maintenance-cost/store" method="post">
        {{ csrf_field() }}
        <div class="box-body">
          <div class="form-group">
            <label>Maintenance Date</label>
            <div class="input-group date">
              <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
              </div>
            <input type="text" class="form-control pull-right datepicker_purchase_date" required="required" name="add_maintenance_date">
            </div>
          </div>
          <div class="form-group">
            <label>Maintenance Type</label>
            <select class="form-control select2" style="width : 100%;" id="add_maintenance_type" name="add_maintenance_type">
              <option value="Kebersihan">Kebersihan</option>
              <option value="Renovasi">Renovasi</option>
              <option value="Perbaikan inventaris">Perbaikan Inventaris</option>
            </select>
          </div>
          <div class="form-group f_room_id">
            <label>Room Number</label>
            <select class="form-control select2" style="width : 100%;" name="add_room_id">
            @foreach($data_room as $darom)
              <option value="{{$darom->id}}">{{$darom->room_number}} - {{$darom->room_type}}</option>
            @endforeach
            </select>
          </div>
          <div class="form-group f_inventaris_id">
            <label>Iventaris</label>
            <select class="form-control select2" style="width : 100%;" name="add_inventory_id">
            @foreach($data_inventory as $datven)
              <option value="{{$datven->id}}">{{$datven->product_name}} - {{$datven->model}}</option>
            @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="add_cost">Cost</label>
            <input type="text" class="form-control" id="add_cost" name="add_cost" placeholder="Input cost" required="required">
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
<div class="modal fade" id ="modalEdit" tabindex="-1" role="dialogs" aria-labelledby="myModalLabels">
  <div class="modal-dialog" role="document">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Data User</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="/user/update" method="post">
        {{ csrf_field() }}
        <div class="box-body">
          <input type="hidden" class="form-control" id="edit_id" name="edit_id" required="required">
          <div class="form-group">
            <label for="edit_name">Name</label>
            <input type="text" class="form-control" id="edit_name" name="edit_name" placeholder="Input name" required="required">
          </div>
          <div class="form-group">
            <label for="edit_address">Address</label>
            <input type="text" class="form-control" id="edit_address" name="edit_address" placeholder="Input address" required="required">
          </div>
          <div class="form-group">
            <label>Gender</label>
            <div class="form-group" id="gender-radio">
              <div>
                <input type="radio" class="flat-red" id="e_c_a" name="edit_gender" value="Laki-laki">
                Laki-laki
              </div>
              <div>
                <input type="radio" class="flat-red" id="e_c_b" name="edit_gender" value="Perempuan">
                Perempuan
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_email">Email</label>
            <input type="email" class="form-control" id="edit_email" name="edit_email" placeholder="Input email address" required="required">
          </div>
          <div class="form-group">
            <label for="edit_password">Password</label>
            <input type="password" class="form-control" id="edit_password" name="edit_password" required autocomplete="new-password">
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
  $('.f_inventaris_id').attr('hidden', true);
  $('#add_maintenance_type').change(function (){
    var v_maintenance_type = $('#add_maintenance_type').val();

    if(v_maintenance_type == "Perbaikan inventaris"){
      $('.f_inventaris_id').attr('hidden', false);
      $('.f_room_id').attr('hidden', true);
    } else {
      $('.f_inventaris_id').attr('hidden', true);
      $('.f_room_id').attr('hidden', false);
    }
  });
  $('#modalEdit').on('shown.bs.modal', function (event) {

    var button = $(event.relatedTarget)
    var v_id = button.data('d_id')
    var v_name = button.data('d_name')
    var v_address = button.data('d_address')
    var v_email = button.data('d_email')
    var v_password = button.data('d_password')
    var v_gender = button.data('d_gender')

    var modal = $(this)

    modal.find('.box-body #edit_id').val(v_id);
    modal.find('.box-body #edit_name').val(v_name);
    modal.find('.box-body #edit_address').val(v_address);
    modal.find('.box-body #edit_email').val(v_email);
    modal.find('.box-body #edit_password').val(v_password);

    if(button.data('d_gender') == "Laki-laki"){
      $('#gender-radio > div + div > div').attr({'aria-checked':"false"}).removeClass('checked');
      $('#gender-radio > div:first-child > div').attr({'aria-checked':"true"}).addClass('checked');
    } else {
      $('#gender-radio > div:first-child > div').attr({'aria-checked':"false"}).removeClass('checked');
      $('#gender-radio > div + div > div').attr({'aria-checked':"true"}).addClass('checked');
    }
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
          url: "/user/destroy/"+itemId, // atau ke bisa ganti disini pake variable
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

  jQuery(document).ready(function(){
    jQuery('#ajaxSubmit').click(function(e){
      e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    
    jQuery.ajax({
      url: "{{ url('/user/store') }}",
      method: 'post',
      data: {
        add_name: jQuery('#add_name').val(),
        add_address: jQuery('#add_address').val(),
        add_gender: jQuery('.a_c_a:checked').val(),
        add_email: jQuery('#add_email').val(),
        add_password: jQuery('#add_password').val(),
        add_role: jQuery('#add_role').val()
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
          url = "/user";
          window.location.replace(url);
        }
      }});
    });
  });
</script>
@endsection