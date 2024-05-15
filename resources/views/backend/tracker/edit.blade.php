@extends('backend.layouts.master')

@section('title','Tracker Details')

@section('main-content')
<div class="card">
  <h5 class="card-header">Tracker Edit</h5>
  <div class="card-body">
    <form action="{{route('tracker.update',$ecotrackers->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="status">Status :</label>
        <select name="status" id="status" class="form-control">
            <option value="new" {{ ($ecotrackers->status == "complete" || $ecotrackers->status == "failed") ? 'disabled' : '' }}>New</option>
            <option value="complete" {{ ($ecotrackers->status == "failed") ? 'disabled' : '' }} {{ ($ecotrackers->status == 'complete') ? 'selected' : '' }}>Successfully Completed 30 days Track. You will receive rewards.</option>
            <option value="failed" {{ ($ecotrackers->status == 'complete') ? 'disabled' : '' }} {{ ($ecotrackers->status == 'failed') ? 'selected' : '' }}>You missed a day. Sorry, you will not receive rewards.</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
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
