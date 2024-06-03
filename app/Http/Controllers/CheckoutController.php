<?php

// namespace App\Http\Controllers;

// use App\Models\Checkout;
// use App\Models\UserDetails;
// use Illuminate\Http\Request;

// class CheckoutController extends Controller
// {

//     public function showCheckout()
//     {
//         $checkouts = Checkout::all(); // Example: Retrieve all checkouts from the database
//         return view('frontend.pages.checkout')->with('checkouts', $checkouts);
//     }
//     public function storeCheckout(Request $request)
//     {
//         $request->validate([
//             'first_name' => 'required|string|max:255',
//             'last_name' => 'required|string|max:255',
//             'email' => 'required|email|max:255',
//             'phone' => 'required|numeric',
//             'country' => 'required|string|max:255',
//             'address1' => 'required|string|max:255',
//             'address2' => 'nullable|string|max:255',
//             'post_code' => 'nullable|string|max:255',
//         ]);

//         // Assuming you have a model called UserDetails
//         $checkouts = new UserDetails();
//         $checkouts->first_name = $request->first_name;
//         $checkouts->last_name = $request->last_name;
//         $checkouts->email = $request->email;
//         $checkouts->phone = $request->phone;
//         $checkouts->country = $request->country;
//         $checkouts->address1 = $request->address1;
//         $checkouts->address2 = $request->address2;
//         $checkouts->post_code = $request->post_code;
//         $checkouts->save();

//         return redirect()->back()->with('success', 'Data saved successfully!');
//     }
// }
