@extends('layouts.app')

@section('content')

{{-- Create Shipping Address --}}
<section class="address section">
    <div class="container">
        <div class="left-panel">
            <div class="icon" style="background-image: url('{{ $user->photo }}');"></div>
            <h2>Create Shipping Address</h2>
            <p>Let's get you set up! It should only take a couple of minutes to pair with your watch</p>
            <a href="{{ route('backToCheckout') }}" class="btn-secondary" id="backButton">Back to Checkout</a>
        </div>
        <div class="right-panel">
            <form action="{{ route('shipping.address.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="recipient_name">Recipient's Name</label>
                        <input type="text" name="recipient_name" id="recipient_name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" maxlength="11" pattern="\d{11}" inputmode="numeric" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="customerType">Location</label>
                        <select name="country" id="customerType" required>
                            <option value="Philippines">Philippines</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="region">Region</label>
                        <select name="region" id="region" onchange="fetchCities();" required>
                            <option value="">Select Region</option>
                        </select>
                    </div>
                </div>
                <div id="localAddressFields" style="display: none;">
                    <div class="form-group" id="cityGroup" style="display: none;">
                        <label for="city">City or Municipality</label>
                        <select name="city" id="city" onchange="fetchBarangays();" required>
                            <option value="">Select City/Municipality</option>
                        </select>
                    </div>
                    <div class="form-group" id="barangayGroup" style="display: none;">
                        <label for="barangay">Barangay</label>
                        <select name="barangay" id="barangay" required>
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="street_building">Street/Bldg.</label>
                        <input type="text" class="form-control" id="street_building" name="street_building" required>
                    </div>
                    <div class="form-group">
                        <label for="unit_floor">Unit/Floor</label>
                        <input type="text" class="form-control" id="unit_floor" name="unit_floor" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="additional_info">Additional Information (Optional)</label>
                    <input type="text" class="form-control" id="additional_info" name="additional_info">
                </div>
                <div class="form-group">
                    <label for="address_category">Address Category</label>
                    <select class="form-control" id="address_category" name="address_category" required>
                        <option value="home">Home</option>
                        <option value="office">Office</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="default_shipping">Default Shipping Address</label>
                    <select class="form-control" id="default_shipping" name="default_shipping" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="default_billing">Default Billing Address</label>
                    <select class="form-control" id="default_billing" name="default_billing" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Save Address</button>
            </form>
        </div>
    </div>
</section>
{{-- End Create Shipping Address --}}

<style>
    /* Background Circles */
    .address.section::before,
    .address.section::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(0, 143, 62, 0.2);
        z-index: -1; /* Ensure circles are behind other elements */
    }

    .address.section::before {
        width: 400px;
        height: 400px;
        top: -100px;
        left: -100px;
    }

    /* .address.section::after {
        width: 300px;
        height: 300px;
        bottom: -150px;
        right: -150px;
    } */

    /* CSS styles here */
    body {
        font-family: Arial, sans-serif;
    }

    .container {
        display: flex;
        flex-direction: column;
        max-width: 85%;
        margin: auto;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        position: relative; /* Ensure container is positioned correctly */
        z-index: 0; /* Ensure form elements are above background circles */
    }

    .left-panel {
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

    .left-panel .icon {
        background-size: cover;
        width: 100px;
        height: 100px;
        margin-bottom: 20px;
        border-radius: 50%;
        background-position: center;
    }

    .left-panel h2 {
        color: rgb(24, 43, 2);
    font-weight: bold;
    margin-bottom: 10px;
    font-size: 24px;
    }

    .left-panel p {
        font-size: 14px;
    color: rgb(24, 43, 2);
    margin-bottom: 20px;
    }

    .right-panel {
        padding: 20px;
        background-color: #fff;
        flex: 1;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        color: #333;
        margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-row {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .form-row .form-group {
        flex: 1;
    }

    .btn-primary {
        width: 100%;
        padding: 10px;
        background-color: #008004; /* Light green */
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #00ea0c;
    }

    /* Styles for Back to Checkout button */
    .btn-secondary {
        background-color: #ffdd40;
    color: black;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
    }

    .btn-secondary a {
        color: #c24a4a;
    }

    .btn-secondary:hover {
        background-color: #88b10d;
        border: 1px solid #3ca944;
        color: #ffffff;
    }

    @media (min-width: 300px) {
        .container {
            flex-direction: row;
        }

        .form-row {
            flex-direction: row;
        }
    }
</style>


</style>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    fetchRegions();

    document.getElementById("customerType").addEventListener("change", function () {
        if (this.value === "Philippines") {
            document.getElementById("localAddressFields").style.display = "block";
        } else {
            document.getElementById("localAddressFields").style.display = "none";
        }
    });

    document.getElementById("customerType").dispatchEvent(new Event("change"));
});

function fetchRegions() {
    fetch('https://psgc.cloud/api/regions')
        .then(response => response.json())
        .then(data => {
            const regionDropdown = document.getElementById('region');
            regionDropdown.innerHTML = '<option value="">Select Region</option>';
            data.forEach(region => {
                regionDropdown.innerHTML += `<option value="${region.name}" data-code="${region.code}">${region.name}</option>`;
            });
        })
        .catch(error => {
            console.error('Error fetching regions:', error);
        });
}

function fetchCities() {
    const regionCode = document.querySelector('#region option:checked').dataset.code;
    if (!regionCode) return;

    fetch('https://psgc.cloud/api/regions/' + regionCode + '/cities')
        .then(response => response.json())
        .then(data => {
            const cityDropdown = document.getElementById('city');
            cityDropdown.innerHTML = '<option value="">Select City/Municipality</option>';
            data.forEach(city => {
                cityDropdown.innerHTML += `<option value="${city.name}" data-code="${city.code}">${city.name}</option>`;
            });
            document.getElementById('cityGroup').style.display = "block";
        })
        .catch(error => {
            console.error('Error fetching cities:', error);
            document.getElementById('cityGroup').style.display = "none";
        });
}

function fetchBarangays() {
    const cityCode = document.querySelector('#city option:checked').dataset.code;
    if (!cityCode) return;

    fetch('https://psgc.cloud/api/cities/' + cityCode + '/barangays')
        .then(response => response.json())
        .then(data => {
            const barangayDropdown = document.getElementById('barangay');
            barangayDropdown.innerHTML = '<option value="">Select Barangay</option>';
            data.forEach(barangay => {
                barangayDropdown.innerHTML += `<option value="${barangay.name}" data-code="${barangay.code}">${barangay.name}</option>`;
            });
            document.getElementById('barangayGroup').style.display = "block";
        })
        .catch(error => {
            console.error('Error fetching barangays:', error);
            document.getElementById('barangayGroup').style.display = "none";
        });
}

</script>

@endsection
