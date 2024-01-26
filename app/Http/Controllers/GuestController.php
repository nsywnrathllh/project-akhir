<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::all();

        return view('guest.index', compact('guests'));
    }

    public function create()
    {
        return view('guest.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'destination' => 'required',
            'purpose' => 'required',
            'checkin' => 'required',
            'checkout' => 'nullable',
            'image' => 'nullable',
            'status' => 'required',
        ]);

        Guest::create($request->all());

        return redirect()->route('guest.index')->with('success', 'Guest created successfully');
    }

    public function edit($id)
    {
        $guest = Guest::findOrFail($id);
        return view('guest.edit', compact('guests'));
    }

    public function update(Request $request, Guest $guest)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'destination' => 'required',
            'purpose' => 'required',
            'checkin' => 'required',
            'checkout' => 'nullable',
            'image' => 'nullable',
            'status' => 'required',
        ]);

        $guest->update($request->all());

        return redirect()->route('guest.index')->with('success', "$guest->name has been updated");
    }

    public function destroy($id)
    {
        $guest = Guest::find($id);
        $guest->delete();

        return redirect()->route('guest.index')->with('success', "$guest->name has been deleted");
    }
}
