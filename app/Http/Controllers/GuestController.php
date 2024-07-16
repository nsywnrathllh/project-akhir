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
    public function index(Request $request)
    {
        $guest = Guest::when($request->start && $request->end, function ($query) use ($request) {
            $query->whereDate('checkin', '>=', $request->start)
                ->whereDate('checkin', '<=', $request->end);
        })->get();

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

        session()->put('guest_id', $guest);

        $settings = Setting::first();
        $message = "Halo, {$guest->destination}\n";
        $message .= "Anda akan mendapatkan tamu pada hari ini.\n\n";
        $message .= "Nama : {$guest->name}\n";
        $message .= "Asal Aliansi : {$guest->alliance}\n";
        $message .= "Tujuan : {$guest->purpose}";

        $targetNotifications = $guest->targetNotifications;
        foreach ($targetNotifications as $targetNotification) {
            $recipientNumber = $targetNotification->phone;
        }

        $imageName = basename($guest->image_path);

        Http::baseUrl('https://app.japati.id')
            ->withHeader('X-Requested-With', 'XMLHttpRequest')
            ->withToken('API-TOKEN-06epaMy7uzNOJeTat3iDXH1yhKusqkQO8ipwhwwJ9QAPbGZWqzpjeo')
            ->attach('media_file', file_get_contents($guest->image_path), $imageName)
            ->post('/api/send-message', [
                'gateway' => '6289683958855',
                'number' => $recipientNumber,
                'type' => 'media',
                'message' => $message,
        ]);

        notify()->success('Guest created successfully!', 'Success');
        return redirect()->route('guests.print', $guest);
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
    public function showScanPage()
    {
        return view('guest.logout');
    }

    public function scan(Request $request)
    {
        try {
            $guestId = $request->input('guest_id');
            Log::info('Received scanned guest ID: ' . $guestId);

            $guest = Guest::find($guestId);

            if ($guest) {
                Log::info('Found guest with ID: ' . $guestId);

                if ($guest->status === 'Still Inside') {
                    // Ubah status tamu menjadi "Check Out"
                    $guest->update(['status' => 'Check Out', 'checkout' => now()]);
                    Log::info('Status updated to "checkout" for guest with ID: ' . $guestId);

                    // Kirim notifikasi WhatsApp ke pengguna terkait
                    // (Ubah sesuai kebutuhan Anda, jika Anda ingin mengirim notifikasi kepada pihak lain)

                    return redirect()->route('logs')->with('success', 'Status tamu berhasil diubah menjadi checkout.');

                } else {
                    Log::warning('Status is not "still inside" for guest with ID: ' . $guestId);
                    return back()->with('warning', 'Status tamu tidak sesuai untuk checkout.');
                }
            } else {
                Log::warning('Guest not found for ID: ' . $guestId);
                return redirect()->back()->with('failed', 'Data tamu tidak ditemukan');
            }

        } catch (\Exception $e) {
            Log::error('Error in scan method: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan dalam pemindaian.');
        }
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
