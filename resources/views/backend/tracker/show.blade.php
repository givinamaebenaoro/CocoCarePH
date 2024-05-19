@extends('backend.layouts.master')

@section('title', 'Show Eco-Tracker')

@section('main-content')
<div class="card">
    <h5 class="card-header">Eco-Tracker</h5>
    <div class="card-body">
        @if($ecotrackers)
        <table class="table table-striped table-hover">
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
                <tr class="@if($ecotrackers->read_at) border-left-success @else bg-light border-left-warning @endif">
                    <td scope="row">{{$ecotrackers->id}}</td>
                    <td>{{$ecotrackers->name}}</td>
                    <td>{{$ecotrackers->created_at->format('F d, Y h:i A')}}</td>
                    <td>{{$ecotrackers->answer_count}}</td>
                    <td>{{$ecotrackers->last_answered_date}}</td>
                    <td>{{$ecotrackers->status}}</td>
                    <td>
                        <a href="{{route('tracker.show', $ecotrackers->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                        <form method="POST" action="{{route('tracker.destroy', [$ecotrackers->id])}}">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id="{{$ecotrackers->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            </tbody>
            <section class="confirmation_part section_padding">
                <div class="order_boxes">
                    <div class="row">
                        <div class="col-lg-6 col-lx-4">
                                <table class="table">
                                <h4 class="text-center pb-4">ECO-TRACK INFORMATION</h4>
                                    <tr class="">
                                        <td>Name</td>
                                        <td> : {{$ecotrackers->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td> : {{$ecotrackers->created_at->format('D d M, Y')}} at {{$ecotrackers->created_at->format('g : i a')}} </td>
                                    </tr>
                                    <tr>
                                        <td>Answer Count</td>
                                        <td> : {{$ecotrackers->answer_count}}</td>
                                    </tr>
                                    <tr>
                                        <td>Last Answered Date</td>
                                        <td> : {{$ecotrackers->last_answered_date}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </table>
        @else
        <div class="alert alert-danger" role="alert">
            Eco-Tracker not found.
        </div>
        @endif
    </div>
</div>
@endsection



@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
