@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Shipping</h5>
    <div class="card-body">
        <form method="post" action="{{ route('shipping.store') }}">
            @csrf
            <div class="form-group">
                <label for="inputTitle" class="col-form-label">Type <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="type" placeholder="Enter title" value="{{ old('type') }}" class="form-control">
                @error('type')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="base_price" class="col-form-label">Base Price <span class="text-danger">*</span></label>
                <input id="base_price" type="number" step="0.01" name="base_price" placeholder="Enter base price" value="{{ old('base_price') }}" class="form-control">
                @error('base_price')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="weight" class="col-form-label">Weight <span class="text-danger">*</span></label>
                <input id="weight" type="number" step="0.01" name="weight" placeholder="Enter weight" value="{{ old('weight') }}" class="form-control">
                @error('weight')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price_per_kg" class="col-form-label">Price per KG <span class="text-danger">*</span></label>
                <input id="price_per_kg" type="number" step="0.01" name="price_per_kg" placeholder="Enter price per KG" value="{{ old('price_per_kg') }}" class="form-control">
                @error('price_per_kg')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <button type="reset" class="btn btn-warning">Reset</button>
                <button class="btn btn-success" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
        $('#description').summernote({
            placeholder: "Write short description.....",
            tabsize: 2,
            height: 150
        });
    });
</script>
@endpush
