<?php

namespace App\Http\Controllers;

use App\Models\FaceRegistrationRequest;
use App\Models\UserIdentifier;
use Illuminate\Http\Request;

class FaceRegistrationController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $request = FaceRegistrationRequest::where('user_id', $user->id)
                                          ->latest()
                                          ->first();
        return view('face.index', compact('request'));
    }

    public function store()
    {
        $user = auth()->user();

        $existing = FaceRegistrationRequest::where('user_id', $user->id)
                                           ->whereIn('status', ['pending', 'processing'])
                                           ->first();
        if ($existing) {
            return redirect()->route('face.index')
                             ->with('error', 'Masih ada request yang sedang diproses.');
        }

        $req = FaceRegistrationRequest::create([
            'user_id'  => $user->id,
            'status'   => 'pending',
            'progress' => 0,
            'message'  => null,
        ]);

        return redirect()->route('face.index')
                         ->with('success', 'Permintaan dikirim! Hadap ke kamera.');
    }

    public function cancel()
    {
        $user = auth()->user();

        $req = FaceRegistrationRequest::where('user_id', $user->id)
                                      ->whereIn('status', ['pending', 'processing'])
                                      ->latest()
                                      ->first();

        if ($req) {
            $req->update(['status' => 'cancelled', 'message' => 'Dibatalkan oleh user.']);
        }

        return redirect()->route('face.index')
                         ->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}