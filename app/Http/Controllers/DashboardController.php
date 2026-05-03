<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\Device;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Summary Stats ────────────────────────────────────────────────
        $total         = AccessLog::count();
        $granted       = AccessLog::where('status', 'granted')->count();
        $denied        = AccessLog::where('status', 'denied')->count();
        $totalDevices  = Device::count();
        $activeDevices = Device::where('is_active', true)->count();
        $totalUsers    = User::count();

        // ── Recent Logs (10 terbaru) ─────────────────────────────────────
        $logs    = AccessLog::with('device')->latest()->limit(10)->get();

        // ── Devices dengan jumlah log ────────────────────────────────────
        $devices = Device::withCount('accessLogs')->get();

        // ── Telegram Notification Settings ───────────────────────────────
        $notifGranted = config('smartdoor.notif_granted', true);
        $notifDenied  = config('smartdoor.notif_denied', true);

        // ── Line Chart — Akses per 7 Hari Terakhir ───────────────────────
        $days = collect(range(6, 0))->map(fn ($i) => now()->subDays($i)->format('Y-m-d'));

        $startOfWeek = now()->subDays(6)->startOfDay();

        $grantedPerDay = AccessLog::where('status', 'granted')
            ->where('created_at', '>=', $startOfWeek)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $deniedPerDay = AccessLog::where('status', 'denied')
            ->where('created_at', '>=', $startOfWeek)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $chartData = [
            'labels'  => $days->map(fn ($d) => Carbon::parse($d)->format('d M'))->values(),
            'granted' => $days->map(fn ($d) => (int) ($grantedPerDay[$d] ?? 0))->values(),
            'denied'  => $days->map(fn ($d) => (int) ($deniedPerDay[$d] ?? 0))->values(),
        ];

        // ── Donut Chart — Per Metode Akses ───────────────────────────────
        $methodData = [
            'face' => AccessLog::where('method', 'face')->count(),
            'rfid' => AccessLog::where('method', 'rfid')->count(),
            'pin'  => AccessLog::where('method', 'pin')->count(),
        ];

        return view('dashboard', compact(
            'logs',
            'devices',
            'granted',
            'denied',
            'total',
            'totalDevices',
            'activeDevices',
            'totalUsers',
            'notifGranted',
            'notifDenied',
            'chartData',
            'methodData',
        ));
    }
}