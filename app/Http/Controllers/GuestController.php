<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guest\GuestStoreRequest;
use App\Http\Requests\Guest\GuestUpdateRequest;
use App\Models\Guest;
use App\Models\Setting;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


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
                'license_plate' => $request->input('license_plate')
            ]);
        }

        // Simpan guest_id ke dalam sesi
        session()->put('guest_id', $guest);

        $message = "Halo, {$guest->destination}\n";
        $message .= "Anda akan mendapatkan tamu pada hari ini.\n\n";
        $message .= "Nama : {$guest->name}\n";
        $message .= "Asal Aliansi : {$guest->alliance}\n";
        $message .= "Tujuan : {$guest->purpose}";

        $targetNotifications = $guest->targetNotifications;
        foreach ($targetNotifications as $targetNotification) {
            $recipientNumber = $targetNotification->phone;
        }

        $this->sendMessage($message, $recipientNumber);


        notify()->success('Guest created successfully!', 'Success');
        return redirect()->route('guests.print', $guest);
    }

    public function sendMessage($message, $recipientNumber)
    {
        $setting = Setting::first();
        $endPoint = $setting->wa_endpoint;
        $apiKey = $setting->wa_api_key;
        $sender = $setting->wa_sender;

        try {
            // Kirim pesan teks
            $responseText = Http::post($endPoint, [
                'api_key' => $apiKey,
                'sender' => $sender,
                'number' => $recipientNumber,
                'message' => $message,
            ]);
            if (!$responseText->successful()) {
                throw new \Exception('Failed to send WhatsApp text message');
            }
        } catch (\Exception $e) {
            // Tangani jika gagal mengirim pesan WhatsApp
            // Anda bisa melakukan redirect atau tindakan lain di sini
        }
    }


    public function showScanPage()
    {
        return view('guest.logout');
    }

    public function checkoutByBarcode($barcode)
    {
        try {
            $guest = Guest::where('barcode', $barcode)->first();

            if (!$guest) {
                Log::warning('Guest not found for barcode: ' . $barcode);
                return redirect()->back()->with('failed', 'Data tamu tidak ditemukan');
            }

            if ($guest->status === 'still inside') {
                $guest->update([
                    'status' => 'checkout',
                    'checkout' => now()
                ]);
                Log::info('Status updated to "checkout" for guest with barcode: ' . $barcode);

                notify()->success('Check Out successfully!', 'Success');
                return redirect()->route('guests.index');
            } else {
                Log::warning('Status is not "still inside" for guest with barcode: ' . $barcode);
                return back()->with('warning', 'Status tidak sesuai untuk checkout.');
            }
        } catch (\Exception $e) {
            Log::error('Error in checkoutByBarcode method: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan dalam checkout berdasarkan barcode.');
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
