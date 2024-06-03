<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\ShippingAddress;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    /**
     * Show the form for creating a new shipping address.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('frontend.pages.shipping-address', compact('user'));
    }

    /**
     * Store a newly created shipping address in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street_building' => 'required|string|max:255',
            'unit_floor' => 'required|string|max:255',
            'additional_info' => 'nullable|string|max:255',
            'address_category' => 'required|in:home,office',
            'default_shipping' => 'required|boolean',
            'default_billing' => 'required|boolean',
        ]);

        $user = Auth::user();

        // Ensure only one default shipping and billing address
        if ($request->default_shipping) {
            $user->shippingAddresses()->update(['default_shipping' => false]);
        }
        if ($request->default_billing) {
            $user->shippingAddresses()->update(['default_billing' => false]);
        }

        $user->shippingAddresses()->create($request->all());

        return redirect()->route('checkout')->with('success', 'Shipping Address saved successfully!');
    }

    public function backToCheckout()
    {
        $user = Auth::user();

        // Ensure to check the correct relationship or field that indicates if the user has a shipping address
        if ($user->shippingAddresses()->exists()) {
            $shippingAddresses = $user->shippingAddresses;
            return view('frontend.pages.checkout', compact('shippingAddresses'));
        } else {
            return redirect()->route('frontend.pages.shipping-address')->with('warning', 'You need to add a shipping address before proceeding to checkout.');;
        }

        // $user = Auth::user();
        // if (!$user->shippingAddress) {  // Adjust this condition based on your data structure
        //     return redirect()->route('shipping.address')->with('warning', 'You need to add a shipping address before proceeding to checkout.');
        // }
        // return redirect()->route('checkout');
    }


    // Add methods for updating and deleting addresses if needed

    /**
     * Show the form for editing the specified shipping address.
     *
     * @param  \App\Models\ShippingAddress  $shippingAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingAddress $shippingAddress)
    {
        $user = Auth::user();
        $shippingAddresses = $user->shippingAddresses;
        return view('frontend.pages.edit-shipping-address', compact('shippingAddress', 'user'));
    }


    /**
     * Update the specified shipping address in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShippingAddress  $shippingAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingAddress $shippingAddress)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'street_building' => 'required|string|max:255',
            'unit_floor' => 'required|string|max:255',
            'additional_info' => 'nullable|string|max:255',
            'address_category' => 'required|in:home,office',
            'default_shipping' => 'required|boolean',
            'default_billing' => 'required|boolean',
        ]);

        $user = Auth::user();

        // Ensure only one default shipping and billing address
        if ($request->default_shipping) {
            $user->shippingAddresses()->update(['default_shipping' => false]);
        }
        if ($request->default_billing) {
            $user->shippingAddresses()->update(['default_billing' => false]);
        }

        $shippingAddress->update($request->all());

        return redirect()->route('checkout')->with('success', 'Shipping Address saved successfully!');
    }

    /**
     * Remove the specified shipping address from storage.
     *
     * @param  \App\Models\ShippingAddress  $shippingAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingAddress $shippingAddress)
    {
        try {
            $shippingAddress->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Failed to delete address: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete address'], 500);
        }
    }




    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getRegions()
    {
        $response = $this->client->get('https://psgc.gitlab.io/api/regions/');
        $regions = json_decode($response->getBody(), true);

        return response()->json($regions);
    }

    public function getProvinces($regionCode)
    {
        $response = $this->client->get("https://psgc.gitlab.io/api/regions/{$regionCode}/provinces/");
        $provinces = json_decode($response->getBody(), true);

        return response()->json($provinces);
    }

    public function getCitiesMunicipalities($provinceCode)
    {
        $response = $this->client->get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities/");
        $citiesMunicipalities = json_decode($response->getBody(), true);

        return response()->json($citiesMunicipalities);
    }

}

