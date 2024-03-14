<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guest\GuestStoreRequest;
use App\Http\Requests\Guest\GuestUpdateRequest;
use App\Models\Guest;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    public function index()
    {
        $guest = Guest::all();
        $vehicle = Vehicle::all();
        return view('guest.index', compact('guest', 'vehicle'));
    }

    public function create()
    {
        $vehicle = Vehicle::all();
        return view('guest.create', compact('vehicle'));
    }

    public function store(GuestStoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            $guest = new Guest($request->validated());

            if ($request->has('image_data')) {
                $imagePath = $this->saveImage($request->input('image_data'));
                $guest->image_path = $imagePath;
            }

            $guest->save();

            if ($request->has('has_vehicle') && $request->input('has_vehicle') == 'Yes') {
                $vehicle = new Vehicle([
                    'type' => $request->input('type'),
                    'license_plate' => $request->input('license_plate'),
                ]);

                // Simpan kendaraan dan hubungkan dengan tamu yang sesuai
                $guest->vehicles()->save($vehicle);
            }
        });

        return redirect()->route('guests.create')->with('success', 'Guest created successfully');
    }


    private function saveImage($imageData)
    {
        $folderPath = 'images/guests/';
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $imageName = 'guest_' . time() . '.png';
        $filePath = $folderPath . $imageName;
        file_put_contents($filePath, base64_decode($image));

        return $filePath;
    }

    public function edit(Guest $guest)
    {
        $vehicles = Vehicle::all(); // Gantilah dengan model kendaraan yang sesuai
        return view('guest.edit', compact('guest', 'vehicles'));
    }

    public function update(GuestUpdateRequest $request, Guest $guest)
    {
        $guest->update($request->validated());

        if ($request->has('image_data')) {
            $imagePath = $this->saveImage($request->input('image_data'));
            $guest->update(['image_path' => $imagePath]);
        }

        return redirect()->route('guests.index')->with('success', 'Guest updated successfully.');
    }

    private function save($imageData)
    {
        $folderPath = 'images/guests/';
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $imageName = 'guest_' . time() . '.png';
        $filePath = $folderPath . $imageName;
        file_put_contents($filePath, base64_decode($image));

        return $filePath;
    }

    public function destroy(Guest $guest)
    {
        // $guest = Guest::find($id);
        $guest->delete();
        return redirect()->route('guests.index')->with('success', 'Guest deleted successfully.');
    }
}
