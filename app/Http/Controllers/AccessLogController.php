<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\Device;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AccessLog::with('device')->latest();

        if ($request->filled('device_id')) {
            $query->where('device_id', $request->device_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        $logs = $query->paginate(20);

        return view('logs.index', compact('logs'));
    }
}