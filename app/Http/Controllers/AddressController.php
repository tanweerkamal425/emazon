<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $addresses = $user->addresses()->get();
        return view('address.index', [
            'addresses' =>  $addresses,
        ]);
    }

    public function show(int $id)
    {
        $address = Address::find($id);

        return view('address.show', [
            'address'   =>  $address,
        ]);
    }

    public function create()
    {
        return view('address.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|min:4|max:64',
            'full_name'         => 'required|min:4|max:64',
            'phone'             => 'required|size:10|unique:users,phone',
            'address_line_1'    => 'required|min:8|max:128',
            'town_id'           => 'required|integer',
            'user_id'           => 'required|integer|exists:users,id',
        ]);

        $address = Address::create($validated);

        return redirect("/address")->with('success', 'Address created successfully');
    }

    public function edit(int $id)
    {
        $address = Address::find($id);

        return view('address.edit', [
            'address'   =>  $address,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title'             => 'required|min:4|max:64',
            'full_name'         => 'required|min:4|max:64',
            'phone'             => 'required|size:10|unique:users,phone',
            'address_line_1'    => 'required|min:8|max:128',
            'town_id'           => 'required|integer',
            'user_id'           => 'required|integer|exists:users,id',
        ]);

        $address = Address::find($id);
        $address->update($validated);

        return redirect('/address')->with('success', 'Address updated succressfully');
    }
}
