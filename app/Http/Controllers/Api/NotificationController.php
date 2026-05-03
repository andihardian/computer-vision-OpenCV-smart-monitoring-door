<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Return log akses terbaru sejak timestamp tertentu
     * Dipakai oleh dashboard untuk polling notifikasi
     */
    public function latest(Request $request)
    {
        $since = $request->query('since'); // timestamp unix

        $query = AccessLog::with('device')->latest();

        if ($since) {
            $query->where('created_at', '>', date('Y-m-d H:i:s', $since));
        } else {
            // Kalau tidak ada since, return 5 terbaru
            $query->limit(5);
        }

        $logs = $query->get()->map(function ($log) {
            return [
                'id'         => $log->id,
                'identifier' => $log->identifier,
                'method'     => strtoupper($log->method),
                'status'     => $log->status,
                'device'     => $log->device->name ?? 'Unknown',
                'waktu'      => $log->created_at->format('d M Y H:i:s'),
                'timestamp'  => $log->created_at->timestamp,
            ];
        });

        return response()->json([
            'logs'      => $logs,
            'server_time' => now()->timestamp,
        ]);
    }
}