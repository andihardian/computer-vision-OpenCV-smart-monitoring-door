<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use App\Models\Device;
use App\Models\UserIdentifier;
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

        // 1. Validasi device token
        $device = Device::where('token', $request->device_token)
                        ->where('is_active', true)
                        ->first();

        if (!$device) {
            return response()->json([
                'status'  => 'denied',
                'message' => 'Device tidak dikenal atau tidak aktif',
            ], 403);
        }

        // 2. Cek jam operasional
        if (!$device->isWithinOperationalHours()) {
            $schedule = $device->operationalHours()->where('is_active', true)->first();
            $reason   = $schedule
                ? "Akses di luar jam operasional ({$schedule->start_time}–{$schedule->end_time})"
                : 'Akses di luar jam operasional';

            AccessLog::create([
                'device_id'  => $device->id,
                'identifier' => $request->identifier,
                'status'     => 'denied',
                'method'     => $request->method ?? 'face',
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'status'  => 'denied',
                'message' => $reason,
                'reason'  => 'outside_operational_hours',
            ], 403);
        }

        // 3. Cek apakah identifier terdaftar & aktif di whitelist
        $identifierRecord = UserIdentifier::where('identifier', $request->identifier)
                                          ->where('is_active', true)
                                          ->first();

        $granted = $identifierRecord !== null;

        // 4. Simpan log akses
        AccessLog::create([
            'device_id'  => $device->id,
            'identifier' => $request->identifier,
            'status'     => $granted ? 'granted' : 'denied',
            'method'     => $request->method ?? 'face',
            'ip_address' => $request->ip(),
        ]);

        // 5. Return response
        return response()->json([
            'status'  => $granted ? 'granted' : 'denied',
            'message' => $granted ? 'Pintu dibuka' : 'Akses ditolak - identifier tidak terdaftar',
        ], $granted ? 200 : 403);
    }

    public function logs()
    {
        $logs = AccessLog::with('device')->latest()->paginate(20);
        return response()->json($logs);
    }
}