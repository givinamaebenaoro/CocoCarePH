@extends('backend.layouts.master')
@section('main-content')
<div class="card">
  <div class="row">
    <div class="col-md-12">
       @include('backend.layouts.notification')
    </div>
  </div>
  <h5 class="card-header">Eco-Tracker</h5>
  <div class="card-body">
    @if(count($ecotrackers)>0)
    <table class="table message-table" id="message-dataTable">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Date</th>
          <th scope="col">Answer Count</th>
          <th scope="col">Last Answered Date</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($ecotrackers as $ecotracker)
        <tr class="@if($ecotracker->read_at) border-left-success @else bg-light border-left-warning @endif">
            <td scope="row">{{$loop->index + 1}}</td>
            <td>{{ Auth::user()->name }} {{$ecotracker->read_at}}</td>
            <td>{{$ecotracker->created_at->format('F d, Y h:i A')}}</td>
            <td>{{$ecotracker->answer_count}}</td>
            <td>{{$ecotracker->last_completed_date}}</td>
            <td>{{$ecotracker->status}}</td>
            <td>
                <a href="{{route('tracker.edit',$ecotracker->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                <a href="{{route('tracker.show', $ecotracker->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                <form method="POST" action="{{route('tracker.destroy', [$ecotracker->id])}}">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger btn-sm dltBtn" data-id="{{$ecotracker->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
    @endforeach

      </tbody>
    </table>
    <nav class="blog-pagination justify-content-center d-flex">
        {{$ecotrackers->links()}}
      </nav>
    @else
      <h2>Eco-Tracker Empty!</h2>
    @endif
  </div>
</div>
@endsection
@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(3.2);
      }
  </style>
@endpush
@push('scripts')
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#message-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[4]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
    $(document).ready(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
        $('.dltBtn').click(function(e){
          var form=$(this).closest('form');
            var dataID=$(this).data('id');
            // alert(dataID);
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
                    form.submit();
                  } else {
                      swal("Your data is safe!");
                  }
              });
        })
    })
  </script>
@endpush
