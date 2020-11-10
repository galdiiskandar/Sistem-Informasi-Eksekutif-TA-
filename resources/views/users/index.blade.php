@extends('layouts.master')
@section('title')
    <title>Users</title>
@endsection
@section('menu')
<li><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard </a></li>
@if(Auth::user()->role == 2)
<li class="treeview active">
  <a href="#">
    <i class="fa fa-table"></i> <span>Master Data</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class="active"><a href="/user"><i class="fa fa-table"></i> <span>Data User</span> </a></li>
    <li><a href="/room"><i class="fa fa-table"></i> <span>Data Room</span> </a></li>
    <li><a href="/product"><i class="fa fa-table"></i> <span>Data Product</span> </a></li>
    <li><a href="/room-inventory"><i class="fa fa-table"></i> <span>Data Room Inventory</span> </a></li>
    <li><a href="/maintenance-cost"><i class="fa fa-table"></i> <span>Data Maintenance Cost</span> </a></li>
  </ul>
</li>
@endif
@endsection

@section('content')
<section class="content-header">
    <h1>
      Data User
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Master Data</a></li>
        <li class="active">Data User</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Table Data User</h3>
      </div>
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data_users as $index => $datus)
                <tr>
                  <td>{{ $index +1 }}.</td> 
                  <td>{{ $datus->name }}</td>
                  <td>{{ $datus->address }}</td>
                  <td>{{ $datus->gender }}</td>
                  <td>{{ $datus->email }}</td>
                  <td>{{ $datus->status }}</td>
                  <td align="center">
                    <a href="#" 
                      data-d_id ="{{ $datus->id }}"
                      data-d_name ="{{ $datus->name }}"
                      data-d_address ="{{ $datus->address }}"
                      data-d_gender ="{{ $datus->gender }}"
                      data-d_email ="{{ $datus->email }}"
                      data-d_status ="{{ $datus->status }}"
                      class="btn btn-warning btn-sm modalMd " title="Edit Data" data-toggle="modal" data-target="#modalEdit"><i class="glyphicon glyphicon-cog"></i></a>
                    {{-- <a href="/user/destroy/{{ $datus->id }}" class="btn btn-danger btn-sm btnDelete" title="Delete Data"><i class="glyphicon glyphicon-trash"></i></a> --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Email</th>
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
        <h3 class="box-title">Input New Data User</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="add_form" role="form" action="/user/store" method="post" enctype="multipart/form-data">
        @csrf
        <div class="box-body">
          <span class="form_result"></span>
          <div class="form-group">
            <label for="add_name">Name</label>
            <input type="text" class="form-control" id="add_name" name="add_name" placeholder="Input name" maxlength="30">
          </div>
          <div class="form-group">
            <label for="add_address">Address</label>
            <input type="text" class="form-control" id="add_address" name="add_address" placeholder="Input address" maxlength="35">
          </div>
          <div class="form-group">
            <label>Gender</label>
            <div class="form-group">
              <div>
                <input type="radio" class="flat-red" name="add_gender" value="Laki-laki" checked>
                Laki-laki
              </div>
              <div>
                <input type="radio" class="flat-red" name="add_gender" value="Perempuan">
                Perempuan
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="add_email">Email</label>
            <input type="email" class="form-control" id="add_email" name="add_email" placeholder="Input email address" maxlength="50">
          </div>
          <div class="form-group">
            <label for="add_password">Password</label>
            <input type="password" class="form-control" id="add_password" name="add_password" maxlength="80">
          </div>
          <div class="form-group">
            <label for="add_password_confirmation">Confirmation Password</label>
            <input type="password" class="form-control" id="add_password_confirmation" name="add_password_confirmation">
          </div>
          <div class="form-group">
            <label for="add_photo">Photo</label>
            <input type="file" class="form-control" id="add_photo" name="add_photo">
          </div>
          <div class="form-group">
            <label>Role</label>
            <select class="form-control" id="add_role" name="add_role">
                <option value="1">Top Level</option>
                <option value="2">Admin</option>
                <option value="3">Staff</option>
            </select>
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
        <h3 class="box-title">Edit Data User</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="edit_form" role="form" action="/user/update" method="post" enctype="multipart/form-data">
        @csrf
        <div class="box-body">
          <span class="form_result"></span>
          <input type="hidden" class="form-control" id="edit_id" name="edit_id">
          <div class="form-group">
            <label for="edit_name">Name</label>
            <input type="text" class="form-control" id="edit_name" name="edit_name" placeholder="Input name" maxlength="30">
          </div>
          <div class="form-group">
            <label for="edit_address">Address</label>
            <input type="text" class="form-control" id="edit_address" name="edit_address" placeholder="Input address" maxlength="35">
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
            <input type="text" class="form-control" id="edit_email" name="edit_email" placeholder="Input email address" readonly>
          </div>
          <div class="form-group">
            <label for="edit_password">Password</label>
            <input type="password" class="form-control" id="edit_password" name="edit_password">
          </div>
          <div class="form-group">
            <label for="edit_password_confirmation">Confirmation Password</label>
            <input type="password" class="form-control" id="edit_password_confirmation" name="edit_password_confirmation">
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
  $('.modalMd').on("click",function(){
    $('#add_form')[0].reset();
    $('.form_result').text('');
  });

  $('#modalEdit').on('shown.bs.modal', function (event) {

    var button    = $(event.relatedTarget)
    var v_id      = button.data('d_id')
    var v_name    = button.data('d_name')
    var v_address = button.data('d_address')
    var v_email   = button.data('d_email')
    var v_gender  = button.data('d_gender')
    var v_status  = button.data('d_status')

    var modal = $(this)

    modal.find('.box-body #edit_id').val(v_id);
    modal.find('.box-body #edit_name').val(v_name);
    modal.find('.box-body #edit_address').val(v_address);
    modal.find('.box-body #edit_email').val(v_email);
    modal.find('.box-body #edit_status').val(v_status);

    if(button.data('d_gender') == "Laki-laki"){
      $('#gender-radio > div:first-child > div').attr({'aria-checked':"true"}).addClass('checked');
      $('#gender-radio > div + div > div').attr({'aria-checked':"false"}).removeClass('checked');
      $('#e_c_a').attr('checked', true);
    } else {
      $('#gender-radio > div + div > div').attr({'aria-checked':"true"}).addClass('checked');
      $('#gender-radio > div:first-child > div').attr({'aria-checked':"false"}).removeClass('checked');
      $('#e_c_b').attr('checked', true);
    }
  });

  $('#add_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"{{ url('/user/store') }}",
      method:"POST",
      data: new FormData(this),
      contentType: false,
      cache:false,
      processData: false,
      dataType:"json",
      success:function(data)
      {
        var html = '';
        if(data.errors)
        {
          swal({
              title: "Something went wrong!",
              text: "Something wrong with your data!",
              icon: "error",
            });
          html = '<div class="alert alert-danger">';
          for(var count = 0; count < data.errors.length; count++){
            html += '<p>' + data.errors[count] + '</p>';
          }
          html += '</div>';
        }
        else
        {
            event.preventDefault();
            swal("Success", "Data user added successfully!", "success").then((value) => {
              $('#add_form')[0].reset();
              $('#modalAdd').modal('hide');
              url = "/user";
              window.location.replace(url);
          });
        }
        $('.form_result').html(html);
      }
   })
  });

  $('#edit_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"{{ url('/user/update') }}",
      method:"POST",
      data: new FormData(this),
      contentType: false,
      cache:false,
      processData: false,
      dataType:"json",
      success:function(data)
      {
        var html = '';
        if(data.errors)
        {
          swal({
              title: "Something went wrong!",
              text: "Something wrong with your data!",
              icon: "error",
          });
          html = '<div class="alert alert-danger">';
          for(var count = 0; count < data.errors.length; count++){
            html += '<p>' + data.errors[count] + '</p>';
          }
          html += '</div>';
        }
        else
        {
          event.preventDefault();
          swal("Success", "Data user changed successfully!", "success").then((value) => {
            $('#edit_form')[0].reset();
            $('#modalEdit').modal('hide');
            url = "/user";
            window.location.replace(url);
          });  
        }
        $('.form_result').html(html);
      }
   })
  });
</script>
@endsection