@extends('layouts.app')

@section('content')
<section class="address section">
    <div class="container">
        <div class="form-left">
            <div class="icon" style="background-image: url('{{ $user->photo }}');"></div>
            <h2>Edit Shipping Address</h2>
            <p>Let's get you set up! It should only take a couple of minutes to pair with your watch</p>
            <a href="{{ route('backToCheckout') }}" class="btn-secondary" id="backButton">Back to Checkout</a>
        </div>
        <div class="form-right">
            <form action="{{ route('shipping.address.update', $shippingAddress->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="recipient_name">Recipient's Name</label>
                        <input type="text" class="form-control" id="recipient_name" name="recipient_name" value="{{ $shippingAddress->recipient_name }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $shippingAddress->phone_number }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="location">Location</label>
                        <select class="form-control" id="location" name="location" required>
                            <option value="Philippines" {{ $shippingAddress->location == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="region">Region</label>
                        <input type="text" class="form-control" id="region" name="region"  value="{{ $shippingAddress->region }}" required>
                    </div>
                </div>
            <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ $shippingAddress->city }}" required>
                    </div>
                <div class="form-group col-md-6">
                    <label for="district">Barangay</label>
                    <input type="text" class="form-control" id="barangay" name="barangay" value="{{ $shippingAddress->barangay }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street_building">Street/Building Name</label>
                    <input type="text" class="form-control" id="street_building" name="street_building" value="{{ $shippingAddress->street_building }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="unit_floor">Unit/Floor</label>
                    <input type="text" class="form-control" id="unit_floor" name="unit_floor" value="{{ $shippingAddress->unit_floor }}" required>
                </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="additional_info">Additional Information (Optional)</label>
                <input type="text" class="form-control" id="additional_info" name="additional_info" value="{{ $shippingAddress->additional_info }}">
            </div>
            <div class="form-group col-md-6">
                <label for="address_category">Address Category</label>
                <select class="form-control" id="address_category" name="address_category" required>
                    <option value="home" {{ $shippingAddress->address_category == 'home' ? 'selected' : '' }}>Home</option>
                    <option value="office" {{ $shippingAddress->address_category == 'office' ? 'selected' : '' }}>Office</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="default_shipping">Default Shipping Address</label>
                <select class="form-control" id="default_shipping" name="default_shipping" required>
                    <option value="1" {{ $shippingAddress->default_shipping ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$shippingAddress->default_shipping ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="default_billing">Default Billing Address</label>
                <select class="form-control" id="default_billing" name="default_billing" required>
                    <option value="1" {{ $shippingAddress->default_billing ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$shippingAddress->default_billing ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>
            {{-- <button type="submit" class="primary">UPDATE ADDRESS</button> --}}
        </form>
        <form method="POST" action="{{ route('frontend.pages.shipping-address.destroy', $shippingAddress->id) }}" class="d-inline delete-address-form">
            @csrf
            @method('DELETE')
            <button type="button" class="anger dltBtn" data-id="{{ $shippingAddress->id }}"  data-toggle="tooltip" data-placement="bottom" title="Delete"> DELETE</button>
        </form>
    </div>
</section>

@endsection
<style>
        /* Background Circles */
        .address.section::before,
    .address.section::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(0, 143, 62, 0.2);
    }

    .address.section::before {
        width: 400px;
        height: 400px;
        top: -100px;
        left: -100px;
    }

    .address.section::after {
        width: 300px;
        height: 300px;
        bottom: -150px;
        right: -150px;
    }

/* Container and form layout */
.container {
    display: flex;
    max-width: 90%;
    margin: 0 auto;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
}

.container h2 {
    text-align: center;
    width: 100%;
    padding: 20px 0;
    color: #333;
}

.form-left {
    background-color: #E9F6C8;
    color: white;
    padding: 40px;
    width: 40%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.form-left .icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    margin-bottom: 20px;
}

.form-left h2 {
    color: rgb(24, 43, 2);
    font-weight: bold;
    margin-bottom: 10px;
    font-size: 24px;
}

.form-left p {
    font-size: 14px;
    color: rgb(24, 43, 2);
    margin-bottom: 20px;
}

.form-left .btn-secondary {
    background-color: #ffdd40;
    color: black;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
}

.form-right {
    width: 60%;
    padding: 40px;
    display: flex;
    flex-direction: column;
}

.form-right {
    flex: 2;
    padding: 40px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    background-color: #fff;
    color: #333;
}

/* Row layout for form groups */
.form-row {
    display: flex;
    justify-content: space-between;
}

.form-group.col-md-6 {
    flex: 0 0 48%;
    max-width: 48%;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
}

.primary {
    width: 100%;
    padding: 10px;
    background-color: #008004;
    border: none;
    border-radius: 4px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.primary:hover {
    background-color: #00b300;
}

.anger {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    background-color: #dc3545;
    border-radius: 4px;
    font-size: 16px;
    border: none;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

.anger:hover {
    background-color: #c82333;
}

/* Add some spacing between buttons */
/* .btn + .btn {
    margin-left: 10px;
}

.delete-address-form {
    display: inline-block;
} */

/* .dltBtn {
    padding: 0;
    border: none;
    background: transparent;
    cursor: pointer;
}

.dltBtn:hover {
    background-color: #f8d7da;
}

[data-toggle="tooltip"] {
    position: relative;
} */

/* Background circles */
.form-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: -1;
}

.circle {
    position: absolute;
    border-radius: 50%;
    opacity: 0.5;
}

.circle-1 {
    width: 150px;
    height: 150px;
    background-color: #ffdd40;
    top: 10%;
    left: 5%;
}

.circle-2 {
    width: 200px;
    height: 200px;
    background-color: #f28e1c;
    top: 70%;
    left: 80%;
}

.circle-3 {
    width: 100px;
    height: 100px;
    background-color: #a1e44d;
    top: 40%;
    left: 20%;
}

.circle-4 {
    width: 120px;
    height: 120px;
    background-color: #d4d7dd;
    top: 80%;
    left: 10%;
}

    </style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.dltBtn').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                if (confirm('Are you sure you want to delete this address?')) {
                    let addressId = this.dataset.id;
                    let url = '{{ route('frontend.pages.shipping-address.destroy', ':id') }}';
                    url = url.replace(':id', addressId);

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }).then(response => {
                        if (response.ok) {
                            console.log('Address deleted successfully'); // For debugging
                            // Redirect to checkout page
                            window.location.href = '{{ route('checkout') }}'; // Replace with the actual checkout route
                        } else {
                            console.error('Failed to delete address', response); // For debugging
                            alert('Failed to delete address');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Failed to delete address');
                    });
                }
            });
        });
    });
</script>
