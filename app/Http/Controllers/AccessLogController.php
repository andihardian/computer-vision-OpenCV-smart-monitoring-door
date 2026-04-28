<?php
namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\Device;
use App\Models\UserIdentifier;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{
    public function index(Request $request)
    {
        $user  = auth()->user();
        $query = AccessLog::with(['device', 'userIdentifier.user'])->latest();

        // Jika bukan admin → hanya tampil log milik sendiri
        if (!$user->isAdmin()) {
            $identifiers = UserIdentifier::where('user_id', $user->id)
                                         ->pluck('identifier')
                                         ->toArray();

            if (empty($identifiers)) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('identifier', $identifiers);
            }
        }

        // Filter tambahan
        if ($user->isAdmin() && $request->filled('device_id')) {
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

    public function destroy(AccessLog $log)
    {
        $log->delete();
        return redirect()->route('logs.index')->with('success', 'Log berhasil dihapus');
    }

    public function destroyAll()
    {
        AccessLog::truncate();
        return redirect()->route('logs.index')->with('success', 'Semua log berhasil dihapus');
    }
}