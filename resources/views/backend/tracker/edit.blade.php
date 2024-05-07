@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
  <h5 class="card-header">Order Edit</h5>
  <div class="card-body">
    <form action="{{route('order.update',$order->id)}}" method="POST">
      @csrf
      @method('PATCH')
      @foreach($users as $user)
      <div>
          User ID: {{ $user->id }} | Name: {{ $user->name }} | Email: {{ $user->email }} | Completed Tasks: {{ $user->tasksCompletedCount() }}
          <form action="{{ route('update.status', $user) }}" method="post">
              @csrf
              @method('PUT')
              <label for="completed">Update Status:</label>
              <select name="completed" id="completed">
                  <option value="1">Successfully completed</option>
                  <option value="0">Failed to complete</option>
              </select>
              <button type="submit">Submit</button>
          </form>
          @error('completed')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </div>
      @endforeach

      @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      @if(session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
      @endif
  </div>
</div>
</div>
<!--/ End Form -->
      <div class="form-group">
        <label for="status">Status :</label>
        <select name="status" id="" class="form-control">
          <option value="new" {{($order->status=='delivered' || $order->status=="process" || $order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='new')? 'selected' : '')}}>New</option>
          <option value="process" {{($order->status=='delivered'|| $order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='process')? 'selected' : '')}}>Processing</option>
          <option value="delivered" {{($order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='delivered')? 'selected' : '')}}>Delivered</option>
          <option value="cancel" {{($order->status=='delivered') ? 'disabled' : ''}}  {{(($order->status=='cancel')? 'selected' : '')}}>Cancel</option>
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
