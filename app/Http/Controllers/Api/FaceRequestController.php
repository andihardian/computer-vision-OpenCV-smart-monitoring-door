<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FaceRegistrationRequest;
use App\Models\UserIdentifier;
use Illuminate\Http\Request;

class FaceRequestController extends Controller
{
    public function pending()
    {
        $requests = FaceRegistrationRequest::with('user')
            ->where('status', 'pending')
            ->get()
            ->map(fn($r) => [
                'id'      => $r->id,
                'user_id' => $r->user_id,
                'name'    => $r->user->name,
            ]);

        return response()->json($requests);
    }

    public function processing($id)
    {
        FaceRegistrationRequest::findOrFail($id)->update([
            'status'   => 'processing',
            'progress' => 0,
        ]);
        return response()->json(['status' => 'ok']);
    }

    public function updateProgress($id, Request $request)
    {
        $req = FaceRegistrationRequest::findOrFail($id);

        // Cek apakah dibatalkan
        if ($req->status === 'cancelled') {
            return response()->json(['status' => 'cancelled']);
        }

        $req->update(['progress' => $request->progress]);
        return response()->json(['status' => 'ok']);
    }

    public function checkCancelled($id)
    {
        $req = FaceRegistrationRequest::findOrFail($id);
        return response()->json([
            'cancelled' => $req->status === 'cancelled'
        ]);
    }

    public function done($id)
    {
        $req = FaceRegistrationRequest::findOrFail($id);
        $req->update([
            'status'   => 'done',
            'progress' => 30,
            'message'  => 'Wajah berhasil didaftarkan',
        ]);

        UserIdentifier::firstOrCreate(
            ['user_id' => $req->user_id, 'type' => 'face'],
            ['identifier' => 'FACE-user_' . $req->user_id, 'is_active' => true]
        );

        return response()->json(['status' => 'ok']);
    }

    public function failed($id)
    {
        FaceRegistrationRequest::findOrFail($id)->update([
            'status'  => 'failed',
            'message' => 'Gagal mendeteksi wajah. Coba lagi.',
        ]);
        return response()->json(['status' => 'ok']);
    }

    public function status($id)
    {
        $req = FaceRegistrationRequest::findOrFail($id);
        return response()->json([
            'status'   => $req->status,
            'progress' => $req->progress,
            'message'  => $req->message,
        ]);
    }
}