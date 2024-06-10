<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings = Shipping::orderBy('id', 'DESC')->paginate(10);
        return view('backend.shipping.index', compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'price_per_kg' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['type', 'base_price', 'weight', 'price_per_kg', 'status']);

        $status = Shipping::create($data);

        if ($status) {
            $request->session()->flash('success', 'Shipping created successfully');
        } else {
            $request->session()->flash('error', 'Error, Please try again');
        }

        return redirect()->route('shipping.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipping = Shipping::find($id);

        if (!$shipping) {
            request()->session()->flash('error', 'Shipping not found');
            return redirect()->back();
        }

        return view('backend.shipping.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shipping = Shipping::find($id);

        if (!$shipping) {
            request()->session()->flash('error', 'Shipping not found');
            return redirect()->route('shipping.index');
        }

        $request->validate([
            'type' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'price_per_kg' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $status = $shipping->update($data);

        if ($status) {
            $request->session()->flash('success', 'Shipping updated successfully');
        } else {
            $request->session()->flash('error', 'Error, Please try again');
        }

        return redirect()->route('shipping.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping = Shipping::find($id);

        if (!$shipping) {
            request()->session()->flash('error', 'Shipping not found');
            return redirect()->back();
        }

        $status = $shipping->delete();

        if ($status) {
            request()->session()->flash('success', 'Shipping deleted successfully');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }

        return redirect()->route('shipping.index');
    }
}
