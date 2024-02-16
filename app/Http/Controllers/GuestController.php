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
        $guest = Guest::create($request->validated());

        if ($request->has('image_data')) {
            $imagePath = $this->saveImage($request->input('image_data'));
            $guest->update(['image_path' => $imagePath]);
        }

        return redirect()->route('guests.index')->with('success', 'Guest created successfully');
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
