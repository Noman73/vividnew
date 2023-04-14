@extends('layouts.master')
@section('content')
   <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Balance</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Balance</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              @if (session('status'))
                  <div class="alert alert-success">
                      {{ session('status') }}
                  </div>
              @endif
              @if($errors->any())
                  {!! implode('', $errors->all('<div>:message</div>')) !!}
              @endif
              <form action="{{URL::to('/admin/balance')}}" method="POST">
                @csrf
                <!-- User Select  -->
                <div class="mb-3 row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">User Select</label>
                  <div class="col-sm-10">
                    <select class="form-select form-control" aria-label="Default select example" id="user" name="user">
                  </select>
                  </div>
                </div>
                <!-- Amount  -->
                <div class="mb-3 row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">Amount:</label>
                  <div class="col-sm-10">
                    <input type="text"  class="form-control" id="" placeholder="Amount" name="ammount" value='{{$data->ammount}}'>
                  </div>
                </div>
                  <div class="col-sm-10">
                    <button class="btn btn-primary">Send</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection
  @section('script')
<script type="text/javascript">
  $(document).ready(function(){
    let data="{{$data->name}}";
    let id="{{$data->id}}";
    let option="<option value='"+id+"'>"+data+"</option>";
    $('#user').html(option);
  })
  $('#user').select2({
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