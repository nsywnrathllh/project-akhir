<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guest\GuestStoreRequest;
use App\Http\Requests\Guest\GuestUpdateRequest;
use App\Models\Guest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $guest = Guest::with('vehicles')->get();
        return view('guest.index', compact('guest'));
    }

    public function create()
    {
        $vehicles = Vehicle::all(); // Gantilah dengan model kendaraan yang sesuai
        return view('guest.create', compact('vehicles'));
    }

    public function store(GuestStoreRequest $request)
    {
        // $vehiclesId = $request->input('vehicles_id');
        Guest::create($request->validated());

        return redirect()->route('guests.index')->with('success', 'Guest created successfully');
    }

    public function edit(Guest $guest)
    {
        $vehicles = Vehicle::all(); // Gantilah dengan model kendaraan yang sesuai
        return view('guest.edit', compact('guest', 'vehicles'));
    }

    public function update(GuestUpdateRequest $request, Guest $guest)
    {
        $guest->update($request->validated());
        return redirect()->route('guests.index')->with('success', 'Guest updated successfully.');
    }

    public function destroy(Guest $guest)
    {
        // $guest = Guest::find($id);
        $guest->delete();
        return redirect()->route('guests.index')->with('success', 'Guest deleted successfully.');
    }
}
