<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\SettingStoreRequest;
use App\Http\Requests\Setting\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    //

    public function index()
    {
        $setting = Setting::first();

        return view('setting.edit', compact('setting'));
    }


    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $setting = Setting::firstOrFail($id);

        return view('setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        $validated = $request->validated();

        $this->updateImage($request, 'logo', $setting);

        // Update other fields
        $setting->name = $validated['name'];
        $setting->address = $validated['address'];
        $setting->wa_endpoint = $validated['wa_endpoint'];
        $setting->wa_api_key = $validated['wa_api_key'];
        $setting->wa_sender = $validated['wa_sender'];

        // Simpan perubahan ke database
        $setting->save();

        
        notify()->success('Setting updated successfully!', 'Success');
        return redirect()->route('settings.index');
    }


    private function updateImage(Request $request, $inputName, $model)
    {
        if ($request->hasFile($inputName)) {
            $imagePath = 'logo'; // Sesuaikan dengan direktori yang diinginkan

            // Delete old image
            if ($model->logo) {
                Storage::delete($imagePath . '/' . $model->logo);
            }

            $uploadedImage = $request->file($inputName);
            $newImageName = $inputName . '.' . $uploadedImage->getClientOriginalExtension();

            // Store new image with a fixed name directly in public directory
            $uploadedImage->move(public_path($imagePath), $newImageName);

            // Update the image file name in the model
            $model->logo = $newImageName;
        }
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('setting.index')->with('success', 'Setting deleted successfully.');
    }
}
