@extends('user.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('user.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Daily Eco-tracker</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($ecotrackers)>0)
        <table class="table table-bordered table-hover" id="order-dataTable" width="100%" cellspacing="0">
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
                <td>{{$ecotracker->name}} {{$ecotracker->read_at}}</td>
                <td>{{$ecotracker->created_at->format('F d, Y h:i A')}}</td>
                <td>{{$ecotracker->answer_count}}</td>
                <td>{{$ecotracker->last_answered_date}}</td>
                <td>{{$ecotracker->status}}</td>
                <td>
                    <a href="{{route('user.ecotrack.ecoshow', $ecotracker->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                        @csrf
                    </form>
                </td>
            </tr>
        @endforeach

          </tbody>
        </table>
        <span style="float:right">{{$ecotrackers->links()}}</span>
        @else
          <h6 class="text-center">No orders found!!! Please order some products</h6>
        @endif
      </div>
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
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>


@endpush
