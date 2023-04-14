@extends('layouts.master')
@section('content')
@section('link')
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css"> --}}
@endsection
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>All Packages</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">Home</a></li>
              <li class="breadcrumb-item">Packages</li>
              <li class="breadcrumb-item active">All Packages</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<div class="container">
	<div class="card m-0">
    <div class="card-header pt-3  flex-row align-items-center justify-content-between">
      <h5 class="m-0 font-weight-bold">Packages</h5>
     </div>
    <div class="card-body px-3 px-md-5">
		<button type="button" class="btn btn-primary" onclick="addNew()">
          Add New <i class="fas fa-plus"></i>
        </button>
        <!-- Modal -->
        {{-- datatable start --}}
        {{-- <div class="container-fluid" id="container-wrapper"> --}}
            <!-- Datatables -->
                <div class="table-responsive mt-2">
                  <table class="table table-sm table-bordered table-striped align-items-center display table-flush data-table">
                    <thead class="thead-light">
                     <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Ammount</th>
                        <th>Comission Ammount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
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
          url:"{{ URL::to('/admin/all_packages') }}"
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
            data:'ammount',
            name:'ammount',
          },
          {
            data:'comission',
            name:'comission',
          },
          {
            data:'action',
            name:'action',
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
 </script>
@endsection
