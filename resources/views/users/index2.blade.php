@extends('layouts.layout')

@section('title')
  
<title>Simply Apartment | Data User</title>

@endsection

@section('menu')

<li><a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a></li>
<li class="active"><a href="/user"><i class="fa fa-table"></i> <span>Data User</span> </a></li>
<li><a href="/room"><i class="fa fa-table"></i> <span>Data Room</span> </a></li>
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
          <h3 class="box-title">Data User</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data_users as $datus)
                <tr>
                  <td>{{ $datus->name }}</td>
                  <td>{{ $datus->address }}</td>
                  <td>{{ $datus->gender }}</td>
                  <td>{{ $datus->email }}</td>
                  <td>
                    <a href="#" 
                      data-d_id ="{{ $datus->id }}"
                      data-d_name ="{{ $datus->name }}"
                      data-d_address ="{{ $datus->address }}"
                      data-d_gender ="{{ $datus->gender }}"
                      data-d_email ="{{ $datus->email }}"
                      data-d_password ="{{ $datus->password }}" 
                      class="btn btn-warning btn-sm modalMd " title="Edit Data" data-toggle="modal" data-target="#modalEdit"><i class="glyphicon glyphicon-cog"></i></a>
                    <a href="/user/destroy/{{ $datus->id }}" class="btn btn-danger btn-sm btnDelete" title="Delete Data"><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Email</th>
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
        <h3 class="box-title">Input New Data User</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="/user/store" method="post">
        <div class="box-body">
          <div class="form-group">
            <label for="add_name">Name</label>
            <input type="text" class="form-control" id="add_name" name="add_name" placeholder="Input name" required="required">
          </div>
          <div class="form-group">
            <label for="add_address">Address</label>
            <input type="text" class="form-control" id="add_address" name="add_address" placeholder="Input address" required="required">
          </div>
          <div class="form-group">
            <label>Gender</label>
            <div class="form-group">
              <div>
                <input type="radio" class="flat-red a_c_a" name="add_gender" value="Laki-laki" checked>
                Laki-laki
              </div>
              <div>
                <input type="radio" class="flat-red a_c_a" name="add_gender" value="Perempuan">
                Perempuan
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="add_email">Email</label>
            <input type="email" class="form-control" id="add_email" name="add_email" placeholder="Input email address" required="required">
          </div>
          <div class="form-group">
            <label for="add_password">Password</label>
            <input type="password" class="form-control" id="add_password" name="add_password" required="required">
          </div>
          <input type="hidden" class="form-control" id="add_role" name="add_role" value="Admin">
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