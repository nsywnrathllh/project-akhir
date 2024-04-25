<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationTarget\NotificationTargetStoreRequest;
use App\Http\Requests\NotificationTarget\NotificationTargetUpdateRequest;
use App\Models\Guest;
use App\Models\NotificationTarget;
use Illuminate\Http\Request;

class NotificationTargetController extends Controller
{
    public function index()
    {
        $targets = NotificationTarget::all();
        return view('target-notification.index', compact('targets'));
    }

    public function create()
    {
        return view('target-notification.create');
    }

    public function store(NotificationTargetStoreRequest $request)
    {
        // Validasi data request untuk NotificationTarget
        $validatedData = $request->validated();

        // Buat instance NotificationTarget dan set data dari request
        $targets = new NotificationTarget($validatedData);

        // Simpan NotificationTarget
        $targets->save();

        notify()->success('Notification Target created successfully!', 'Success');
        return redirect()->route('notification-targets.index');
    }


    public function edit(NotificationTarget $target)
    {
        return view('target-notification.edit', compact('target'));
    }

    public function update(NotificationTargetUpdateRequest $request, NotificationTarget $target)
    {
        // Validasi data request untuk NotificationTarget
        $validatedData = $request->validated();

        // Update data NotificationTarget
        $target->update($validatedData);

        notify()->success('Notification Target updated successfully!', 'Success');
        return redirect()->route('target-notifications.index');
    }

    public function destroy(NotificationTarget $target)
    {
        // Hapus NotificationTarget
        $target->delete();

        notify()->success('Notification Target deleted successfully!', 'Success');
        return redirect()->route('target-notifications.index');
    }
}
