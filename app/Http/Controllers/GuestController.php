<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guest\GuestStoreRequest;
use App\Http\Requests\Guest\GuestUpdateRequest;
use App\Models\Guest;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


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
        DB::transaction(function () use ($request) {
            $guest = new Guest($request->validated());

            // if ($request->has('scan_ktp')) {
            //     $scanKtpPath = $this->saveImage($request->file('scan_ktp'), 'scan_ktp');
            //     $guest->scan_ktp = $scanKtpPath;
            // }

            if ($request->has('image_data')) {
                $imagePath = $this->saveImage($request->input('image_data'));
                $guest->image_path = $imagePath;
            }

            $guest->save();

            if ($request->has('has_vehicle') && $request->input('has_vehicle') == 'Yes') {
                $guest->vehicles()->create([
                    'type' => $request->input('type'),
                    'license_plate' => $request->input('license_plate')
                ]);
            }
        });

        notify()->success('Guest created successfully!', 'Success');
        return redirect()->route('guests.create');
    }


    public function showScanPage(Guest $guest)
    {
        return view('guest.logout', compact('guest'));
    }

    public function checkoutByBarcode(Guest $guest)
    {
        // Misalkan kode barcode yang discan adalah kode tamu, maka Anda bisa membandingkannya dengan ID tamu
        if ($guest) {
            // Lakukan proses checkout hanya jika status masih 'Still Inside'
            if ($guest->status == 'Still Inside') {
                $guest->update([
                    'status' => 'Check Out',
                    'checkout' => now(),
                ]);

                return redirect()->route('guests.index')->with('success', 'Guest checked out successfully.');
            } else {
                return redirect()->route('guests.index')->with('error', 'Guest already checked out.');
            }
        } else {
            return redirect()->route('guests.index')->with('error', 'Guest not found.');
        }
    }


    private function saveImage($imageData, $folder = 'guests')
    {
        $folderPath = 'images/' . $folder . '/';
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

    public function destroy(Guest $guest)
    {
        // $guest = Guest::find($id);
        $guest->delete();
        return redirect()->route('guests.index')->with('success', 'Guest deleted successfully.');
    }
}
