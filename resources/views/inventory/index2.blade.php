@extends('layouts.layout')

@section('title')
  
<title>Simply Apartment | Data Inventory</title>

@endsection

@section('menu')

<li><a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a></li>
<li><a href="/user"><i class="fa fa-table"></i> <span>Data User</span> </a></li>
<li><a href="/room"><i class="fa fa-table"></i> <span>Data Room</span> </a></li>
<li class="active"><a href="/inventory"><i class="fa fa-table"></i> <span>Data Inventory</span> </a></li>
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
          <h3 class="box-title">Data Inventory</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Room Number</th>
                <th>Product Name</th>
                <th>Model</th>
                <th>Product Serial Number</th>
                <th>Purchase Date</th>
                <th>Qty</th>
                <th>Condition</th>
                <th>Information</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data_inventory as $datin)
                <tr>
                  <td>{{ $datin->roomnumber }}</td>
                  <td>{{ $datin->product_name }}</td>
                  <td>{{ $datin->model }}</td>
                  <td>{{ $datin->product_serial_number }}</td>
                  <td>{{ $datin->purchase_date }}</td>
                  <td>{{ $datin->qty }}</td>
                  <td>{{ $datin->condition }}</td>
                  <td>{{ $datin->information }}</td>
                  <td>
                    <a href="#" 
                      data-d_id ="{{ $datin->id }}"
                      data-d_room_id ="{{ $datin->room_id }}"
                      data-d_product_name ="{{ $datin->product_name }}"
                      data-d_model ="{{ $datin->model }}"
                      data-d_product_serial_number ="{{ $datin->product_serial_number }}"
                      data-d_purchase_date ="{{ $datin->purchase_date }}"
                      data-d_qty ="{{ $datin->qty }}"
                      data-d_condition ="{{ $datin->condition }}"
                      data-d_information ="{{ $datin->information }}" 
                      class="btn btn-warning btn-sm modalMd " title="Edit Data" data-toggle="modal" data-target="#modalEdit"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="/inventory/destroy/{{ $datin->id }}" class="btn btn-danger btn-sm btnDelete" title="Delete Data"><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Room Number</th>
                <th>Product Name</th>
                <th>Model</th>
                <th>Product Serial Number</th>
                <th>Purchase Date</th>
                <th>Qty</th>
                <th>Condition</th>
                <th>Information</th>
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
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="box box-primary">
      <div class="box-header with-border">
        <div class="alert alert-danger" style="display:none"></div>
        <h3 class="box-title">Input New Data Inventory</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="/inventory/store" method="post">
        {{csrf_field()}}
        <div class="box-body">
          <div class="form-group">
            <label>Room Number</label>
            <select class="form-control select2" style="width : 100%;" name="add_room_id">
            @foreach($data_room as $darom)
              <option value="{{$darom->id}}">{{$darom->room_number}} - {{$darom->room_type}}</option>
            @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="add_product_name">Product Name</label>
            <input type="text" class="form-control" id="add_product_name" placeholder="Input product name" required="required" name="add_product_name">
          </div>
          <div class="form-group">
            <label for="add_model">Model</label>
            <input type="text" class="form-control" id="add_model" placeholder="Input model of product" required="required" name="add_model">
          </div>
          <div class="form-group">
            <label for="add_product_serial_number">Product Serial Number</label>
            <input type="text" class="form-control" id="add_product_serial_number" placeholder="Input product serial number" required="required" name="add_product_serial_number">
          </div>
          <div class="form-group">
            <label>Purchase Date</label>
            <div class="input-group date">
              <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
              </div>
            <input type="text" class="form-control pull-right datepicker_purchase_date" required="required" name="add_purchase_date">
            </div>
          </div>
          <div class="form-group">
            <label for="add_qty">Qty</label>
            <input type="text" class="form-control" id="add_qty" placeholder="Input quantity of product" required="required" name="add_qty">
          </div>
          <div class="form-group">
            <label>Condition</label>
            <div class="form-group">
              <div>
                <input type="radio" name="add_condition" id="a_c_a" value="Very Good" class="flat-red" checked>
                Very Good
              </div>
              <div>
                <input type="radio" name="add_condition" id="a_c_b" value="Good" class="flat-red">
                Good
              </div>
              <div>
                <input type="radio" name="add_condition" id="a_c_c" value="Bad" class="flat-red">
                Bad
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="add_information">Information</label>
            <input type="text" class="form-control" id="add_information" placeholder="Additional information" required="required" name="add_information">
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
        <h3 class="box-title">Edit Data Iventaris</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="/inventory/update" method="post">
        {{ csrf_field() }}
        <div class="box-body">
          
            <input type="hidden" class="form-control" id="edit_id" name="edit_id">
          
          <div class="form-group">
              <label>Room Number</label>
              <select class="form-control select2" style="width : 100%;" name="edit_room_id">
              @foreach($data_room as $darom)
              <option value="{{$darom->id}}">{{$darom->room_number}} - {{$darom->room_type}}</option>
              @endforeach
              </select>
            </div>
          <div class="form-group">
            <label for="edit_product_name">Product Name</label>
            <input type="text" class="form-control" id="edit_product_name" placeholder="Input product name" required="required" name="edit_product_name">
          </div>
          <div class="form-group">
            <label for="edit_model">Model</label>
            <input type="text" class="form-control" id="edit_model" placeholder="Input model of product" required="required" name="edit_model">
          </div>
          <div class="form-group">
            <label for="edit_product_serial_number">Product Serial Number</label>
            <input type="text" class="form-control" id="edit_product_serial_number" placeholder="Input product serial number" required="required" name="edit_product_serial_number">
          </div>
          <div class="form-group">
            <label>Purchase Date</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right datepicker_purchase_date" required="required" name="edit_purchase_date">
            </div>
          </div>
          <div class="form-group">
            <label for="edit_qty">Qty</label>
            <input type="text" class="form-control" id="edit_qty" placeholder="Input quantity of product" required="required" name="edit_qty">
          </div>
          <div class="form-group">
            <label>Condition</label>
            <div class="radio">
              <label>
                <input type="radio" name="edit_condition" id="e_c_a" value="Very Good" checked>
                Very good
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="edit_condition" id="e_c_b" value="Good">
                Good
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="edit_condition" id="e_c_c" value="Bad">
                Bad
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_information">Information</label>
            <input type="text" class="form-control" id="edit_information" placeholder="Additional information" required="required" name="edit_information">
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
    var v_room_id = button.data('d_room_id')
    var v_product_name = button.data('d_product_name')
    var v_model = button.data('d_model')
    var v_product_serial_number = button.data('d_product_serial_number')
    var v_purchase_date = button.data('d_purchase_date')
    var v_qty = button.data('d_qty')
    var v_information = button.data('d_information')

    var modal = $(this)

    modal.find('.box-body #edit_id').val(v_id);
    $('.select2').val(v_room_id).trigger('change');
    modal.find('.box-body #edit_product_name').val(v_product_name);
    modal.find('.box-body #edit_model').val(v_model);
    modal.find('.box-body #edit_product_serial_number').val(v_product_serial_number);
    modal.find('.box-body input[name="edit_purchase_date"]').val(v_purchase_date);
    modal.find('.box-body #edit_qty').val(v_qty);
    modal.find('.box-body #edit_information').val(v_information);

    if(button.data('d_condition') == "Very Good"){
      $("#e_c_a").attr('checked',true);
    }else if(button.data('d_condition') == "Good"){
      $("#e_c_b").attr('checked',true);
    }
    else{
      $("#e_c_c").attr('checked',true);
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
          url: "/inventory/destroy/"+itemId, // atau ke bisa ganti disini pake variable
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
    jQuery('#ajaxSubmit1').click(function(e){
      e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    jQuery.ajax({
      url: "{{ url('/inventory/store') }}",
      method: 'post',
      data: {
        add_model: jQuery('#add_model').val()
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
          $('#modalAdd1').modal('hide');
          url = "/inventory";
          window.location.replace(url);
        }
      }});
    });
  });
</script>
@endsection