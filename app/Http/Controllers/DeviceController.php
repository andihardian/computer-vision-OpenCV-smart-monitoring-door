<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::withCount('accessLogs')->get();
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        Device::create([
            'name'      => $request->name,
            'location'  => $request->location,
            'token'     => 'raspi-token-' . Str::random(8),
            'is_active' => true,
        ]);

        return redirect()->route('devices.index')->with('success', 'Device berhasil ditambahkan');
    }

    public function show(Device $device)
    {
        $logs = $device->accessLogs()->latest()->paginate(15);
        return view('devices.show', compact('device', 'logs'));
    }

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'location'  => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $device->update([
            'name'      => $request->name,
            'location'  => $request->location,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('devices.index')->with('success', 'Device berhasil diupdate');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('success', 'Device berhasil dihapus');
    }

    public function regenerateToken(Device $device)
    {
        $device->update([
            'token' => 'raspi-token-' . Str::random(8),
        ]);

        return redirect()->route('devices.show', $device)->with('success', 'Token berhasil diperbarui');
    }
}