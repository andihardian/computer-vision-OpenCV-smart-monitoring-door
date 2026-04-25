<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\Device;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $logs          = AccessLog::with('device')->latest()->paginate(10);
        $devices       = Device::withCount('accessLogs')->get();
        $granted       = AccessLog::where('status', 'granted')->count();
        $denied        = AccessLog::where('status', 'denied')->count();
        $total         = AccessLog::count();
        $totalDevices  = Device::count();
        $activeDevices = Device::where('is_active', true)->count();
        $totalUsers    = User::count();

        return view('dashboard', compact(
            'logs', 'devices', 'granted', 'denied', 'total',
            'totalDevices', 'activeDevices', 'totalUsers'
        ));
    }
}