<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guest\GuestStoreRequest;
use App\Http\Requests\Guest\GuestUpdateRequest;
use App\Models\Guest;
use App\Models\Setting;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    public function index()
    {
        $guest = Guest::all();
        return view('guest.index', compact('guest'));
    }

    public function create()
    {
        return view('guest.create');
    }

    public function store(GuestStoreRequest $request)
    {
       
            $guest = new Guest($request->validated());

            if ($request->has('image_data')) {
                $imagePath = $this->saveImage($request->input('image_data'));
                $guest->image_path = $imagePath;
            }

            $guest->save();

            if ($request->has('has_vehicle') && $request->input('has_vehicle') == 'Yes') {
                $guest->vehicles()->create([
                    'type' => $request->input('type'), 
                    'license_plate' => $request->input('license_plate')]);

                // Simpan kendaraan dan hubungkan dengan tamu yang sesuai
                $guest->save();
            }

            // Simpan guest_id ke dalam sesi
            session()->put('guest_id', $guest);

        
        notify()->success('Guest created successfully!', 'Success');
        return redirect()->route('guests.print', $guest);
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
        return view('guest.edit', compact('guest'));
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

    public function print(Guest $guest)
    {

        $setting = Setting::firstOrFail();
        $userName = $guest->name;      
        $phoneUser = $guest->phone;
        $alliance = $guest->alliance;
        $purpose = $guest->purpose;
        $checkIn = $guest->checkin;

        $firstTwoDigits = substr($phoneUser, 0, 2);
        $lastTwoDigits = substr($phoneUser, -2);
        $maskedPhoneNumber = intval($firstTwoDigits) + intval($lastTwoDigits);
        $maskedPhoneNumber = $firstTwoDigits . str_repeat('*', max(0, strlen($phoneUser) - 4)) . $lastTwoDigits;

        return view('guest.print', compact('guest', 'setting', 'userName', 'phoneUser', 'purpose', 'checkIn', 'maskedPhoneNumber', 'alliance'));

    }

    public function destroy(Guest $guest)
    {
        // $guest = Guest::find($id);
        $guest->delete();
        return redirect()->route('guests.index')->with('success', 'Guest deleted successfully.');
    }
}
