@extends('layouts.master')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Password Change User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">Home</a></li>
              <li class="breadcrumb-item">password change</li>
              <li class="breadcrumb-item active">password change</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<div class="container">
	<div class="card m-0">
    <div class="card-header pt-3  flex-row align-items-center justify-content-between">
      <h5 class="m-0 font-weight-bold">User Password Change</h5>
     </div>
    <div class="card-body px-3 px-md-5">
		{{-- <button type="button" class="btn btn-primary" onclick="addNew()">
          Add New <i class="fas fa-plus"></i>
        </button> --}}
        <!-- Modal -->
        {{-- datatable start --}}
        {{-- <div class="container-fluid" id="container-wrapper"> --}}
            <!-- Datatables -->
                {{-- <div class="table-responsive mt-2">
                  <table class="table table-sm table-bordered table-striped align-items-center display table-flush data-table">
                    <thead class="thead-light">
                     <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Comission</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div> --}}

                <div class="container">
                    <form action="{{route('user-pass-change.store')}}" method="POST">
                        @csrf
                        <div class="container">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                 @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if($errors->any())
                                    {!! implode('', $errors->all("<div class='text-danger'>:message</div>")) !!}
                                @endif
                            <div class="form-group">
                                <label for="user">Select User Name</label>
                                <select name="user" id="fuser" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="user">Password</label>
                                <input type="password" name='password' class="form-control" placeholder="Write password">
                            </div>
                            <div class="form-group">
                                <label for="user">Confirm Password</label>
                                <input type="password" name='password_confirmation' class="form-control" placeholder="Confirm password">
                            </div>
                            <button class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
        {{-- datatable end --}}
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
   $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }

    });
    $('.data-table').DataTable({
        processing:true,
        serverSide:true,
        ajax:{
          url:"{{ URL::to('/admin/refarral_comission') }}"
        },
        columns:[
          {
            data:'DT_RowIndex',
            name:'DT_RowIndex',
            orderable:false,
            searchable:false
          },
          {
            data:'name',
            name:'name',
          },
          {
            data:'mobile',
            name:'mobile',
          },
           {
            data:'comission',
            name:'comission',
          },
        ]
    });
$(document).on('click','.edit',function(){
  $('#exampleModalLabel').text('Update Bank Account');
  $('.submit').text('Update');
  $('#balance').attr('disabled',true);
$('#exampleModal').modal('show');
  ModalClose();
  id=$(this).data('id');
  $('#id').val(id);
  axios.get('admin/get_banks/'+id)
  .then(function(response){
    keys=Object.keys(response.data);
    for (var i = 0; i < keys.length; i++) {
      $('#'+keys[i]).val(response.data[keys[i]]);
    }
  })
})
 //ajax request from employee.js

 $('#fuser').select2({
    theme:'bootstrap4',
    placeholder:'select',
    allowClear:true,
    ajax:{
      url:"{{URL::to('admin/get_refarral')}}",
      type:'post',
      dataType:'json',
      delay:20,
      data:function(params){
        return {
          searchTerm:params.term,
          _token:"{{csrf_token()}}",
          }
      },
      processResults:function(response){
        return {
          results:response,
        }
      },
      cache:true,
    }
  })
 </script>
@endsection
