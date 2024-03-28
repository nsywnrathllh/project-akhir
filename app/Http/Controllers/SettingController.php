<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\SettingStoreRequest;
use App\Http\Requests\Setting\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //

    public function index()
    {
        $settings = Setting::all();
        return view('setting.index', compact('settings'));
    }

    public function store(SettingStoreRequest $request)
    {
        $setting = Setting::create($request->validated());
        return redirect()->route('setting.index')->with('success', 'Setting created successfully.');
    }

    public function edit(Setting $setting)
    {
        return view('setting.edit', compact('setting'));
    }

    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        $setting->update($request->validated());
        return redirect()->route('setting.index')->with('success', 'Setting updated successfully.');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('setting.index')->with('success', 'Setting deleted successfully.');
    }
}
