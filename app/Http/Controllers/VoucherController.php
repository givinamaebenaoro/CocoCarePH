<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::paginate(10);
        return view('backend.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        $parent_cats = Voucher::orderBy('title', 'ASC')->get();
        return view('backend.voucher.create')->with('parent_cats', $parent_cats);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|nullable',
            'photo' => 'string|nullable',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Voucher::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }

        $data['slug'] = $slug;

        $status = Voucher::create($data);

        if ($status) {
            request()->session()->flash('success', 'Voucher added successfully');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }

        return redirect()->route('voucher.index');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        $parent_cats = Voucher::orderBy('title', 'ASC')->get();
        return view('backend.voucher.edit', compact('voucher', 'parent_cats'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|nullable',
            'photo' => 'string|nullable',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $status = $voucher->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Voucher updated successfully');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }

        return redirect()->route('voucher.index');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $status = $voucher->delete();

        if ($status) {
            request()->session()->flash('success', 'Voucher deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting voucher');
        }

        return redirect()->route('voucher.index');
    }
}
