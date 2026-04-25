<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use App\Models\Device;
use Illuminate\Http\Request;

class DoorController extends Controller
{
    public function unlock(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
            'identifier'   => 'required|string',
            'method'       => 'nullable|in:rfid,pin,face',
        ]);

        $device = Device::where('token', $request->device_token)
                        ->where('is_active', true)
                        ->first();

        if (!$device) {
            return response()->json([
                'status'  => 'denied',
                'message' => 'Device tidak dikenal atau tidak aktif',
            ], 403);
        }

        $granted = true;

        AccessLog::create([
            'device_id'  => $device->id,
            'identifier' => $request->identifier,
            'status'     => $granted ? 'granted' : 'denied',
            'method'     => $request->method ?? 'rfid',
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'status'  => $granted ? 'granted' : 'denied',
            'message' => $granted ? 'Pintu dibuka' : 'Akses ditolak',
        ]);
    }

    public function logs()
    {
        $logs = AccessLog::with('device')->latest()->paginate(20);
        return response()->json($logs);
    }
}