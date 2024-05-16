@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
  <h5 class="card-header">Order Edit</h5>
  <div class="card-body">
    <form action="{{route('order.update',$order->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group row">
        <div class="col-md-6">
          <label for="payment_status">Payment Status :</label>
          <select name="payment_status" id="payment_status" class="form-control">
              <option value="unpaid"
                  {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}
                  {{ $order->payment_status == 'paid' ? 'disabled' : '' }}>
                  Unpaid
              </option>
              <option value="paid"
                  {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                  Paid
              </option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="status">Shipping Status :</label>
          <select name="status" id="status" class="form-control">
            <option value="new" {{($order->status=='delivered' || $order->status=="process" || $order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='new')? 'selected' : '')}}>New</option>
            <option value="process" {{($order->status=='delivered'|| $order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='process')? 'selected' : '')}}>Processing</option>
            <option value="delivered" {{($order->status=="cancel") ? 'disabled' : ''}}  {{(($order->status=='delivered')? 'selected' : '')}}>Delivered</option>
            <option value="cancel" {{($order->status=='delivered') ? 'disabled' : ''}}  {{(($order->status=='cancel')? 'selected' : '')}}>Cancel</option>
          </select>
        </div>
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
