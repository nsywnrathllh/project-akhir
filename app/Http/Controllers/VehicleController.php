<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\VehicleStoreRequest;
use App\Http\Requests\Vehicle\VehicleUpdateRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    //

    public function index()
    {
        $vehicle = Vehicle::all();
        return view('vehicle.index', compact('vehicle'));
    }

    public function create()
    {
        $vehicle = Vehicle::all();
        return view('vehicle.create', compact('vehicle'));
    }

    public function store(VehicleStoreRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());
        return redirect()->route('vehicles.index', compact('vehicle'))->with('success', 'Vehicle created successfully.');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicle.edit', compact('vehicle'));
    }

    public function update(VehicleUpdateRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());
        return redirect()->route('vehicles.index', compact('vehicle'))->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index', compact('vehicle'))->with('success', 'Vehicle deleted successfully.');
    }
}
