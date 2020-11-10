@extends('layouts.master')
@section('title')
    <title>User Profile</title>
@endsection
@section('menu')
<li><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard </a></li>
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
      User Profile
    </h1>
</section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">User Profile</h3>
      </div>
      <div class="box-body">
        <table class="table">
              <tr>
                <td rowspan="5" style="vertical-align: middle; text-align: center; width: 50px;"><img src="/display_picture/{{Auth::user()->photo}}" class="img-rounded" alt="User Image" width="170px"></td>
              </tr>
              <tr>
                <th style="width: 10px;">Name</th>
                <td style="width: 10px;">:</td>
                <td>{{Auth::user()->name}}</td>
              </tr>
              <tr>
                <th style="width: 10px;">Address</th>
                <td style="width: 10px;">:</td>
                <td>{{Auth::user()->address}}</td>
              </tr>
              <tr>
                <th style="width: 10px;">Gender</th>
                <td style="width: 10px;">:</td>
                <td>{{Auth::user()->gender}}</td>
              </tr>
              <tr>
                <th style="width: 10px;">Email</th>
                <td style="width: 10px;">:</td>
                <td>{{Auth::user()->email}}</td>
              </tr>
          </table>
          <a style="margin-left: 190px;" href="#" 
            data-d_id ="{{Auth::user()->id }}"
            data-d_name ="{{Auth::user()->name }}"
            data-d_address ="{{Auth::user()->address }}"
            data-d_gender ="{{Auth::user()->gender }}"
            data-d_email ="{{Auth::user()->email }}"
          class="btn btn-primary btn-sm modalMd " title="Edit Data" data-toggle="modal" data-target="#modalEdit">Update Profile</a>  
          <a style="margin-left: 10px;" href="#" 
          class="btn btn-primary btn-sm modalMd " title="Update Password" data-toggle="modal" data-target="#modalEditPwd">Change Password</a>
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
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialogs" aria-labelledby="myModalLabels">
  <div class="modal-dialog" role="document">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Data User</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="edit_form" role="form" action="/user/update/profile" method="post" enctype="multipart/form-data">
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
            <input type="email" class="form-control" id="edit_email" name="edit_email" placeholder="Input email address" maxlength="50">
          </div>
          <div class="form-group">
            <label for="edit_photo">Photo</label>
            <input type="file" class="form-control" id="edit_photo" name="edit_photo">
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

<div class="modal fade" id="modalEditPwd" tabindex="-1" role="dialogs" aria-labelledby="myModalLabels">
  <div class="modal-dialog" role="document">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Change Password</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="edit_pwd" role="form" action="/user/update/password" method="post">
        @csrf
        <div class="box-body">
          <span class="form_result"></span>
          <div class="form-group">
            <label for="edit_old_password">Old Password</label>
            <input type="password" class="form-control" id="edit_old_password" name="edit_old_password" placeholder="Input old password">
          </div>
          <div class="form-group">
            <label for="edit_new_password">New Password</label>
            <input type="password" class="form-control" id="edit_new_password" name="edit_new_password" placeholder="Input new password">
          </div>
          <div class="form-group">
            <label for="edit_new_password_confirmation">New Password Confirmation</label>
            <input type="password" class="form-control" id="edit_new_password_confirmation" name="edit_new_password_confirmation" placeholder="Input new password">
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
    $('.form_result').text('');
  });

  $('#modalEdit').on('shown.bs.modal', function (event) {

    var button    = $(event.relatedTarget)
    var v_id      = button.data('d_id')
    var v_name    = button.data('d_name')
    var v_address = button.data('d_address')
    var v_email   = button.data('d_email')
    var v_gender  = button.data('d_gender')

    var modal = $(this)

    modal.find('.box-body #edit_id').val(v_id);
    modal.find('.box-body #edit_name').val(v_name);
    modal.find('.box-body #edit_address').val(v_address);
    modal.find('.box-body #edit_email').val(v_email);

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

  $('#edit_pwd').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"{{ url('/user/update/password') }}",
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
          $('#edit_pwd')[0].reset();
          html = '<div class="alert alert-danger">';
          for(var count = 0; count < data.errors.length; count++){
            html += '<p>' + data.errors[count] + '</p>';
          }
          html += '</div>';
        }
        else if(data.notmatch)
        {
          $('#edit_pwd')[0].reset();
          html = '<div class="alert alert-danger">';
          html += 'The old password not match with our records. Please try again.';
          html += '</div>';
        }
        else if(data.matchold)
        {
          swal({
              title: "Something went wrong!",
              text: "Something wrong with your data!",
              icon: "error",
          });
          $('#edit_pwd')[0].reset();
          html = '<div class="alert alert-danger">';
          html += 'New Password cannot be same as your current password.';
          html += '</div>';
        }else{          
          event.preventDefault();
          swal("Success", "Password changed successfully!", "success").then((value) => {
            $('#edit_pwd')[0].reset();
            $('#modalEditPwd').modal('hide');
            url = "/user/profile";
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
      url:"{{ url('/user/update/profile') }}",
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
          swal("Success", "Profile changed successfully!", "success").then((value) => {
            $('#edit_form')[0].reset();
            $('#modalEdit').modal('hide');
            url = "/user/profile";
            window.location.replace(url);
          });
        }
        $('.form_result').html(html);
      }
   })
  });
</script>
@endsection