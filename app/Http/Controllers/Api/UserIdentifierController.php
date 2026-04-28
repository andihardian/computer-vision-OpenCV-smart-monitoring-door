<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserIdentifier;

class UserIdentifierController extends Controller
{
    /**
     * Return daftar identifier yang aktif untuk Python
     * Format: { "1": "hardi", "2": "budi", ... }
     */
    public function index()
    {
        $identifiers = UserIdentifier::with('user')
            ->where('is_active', true)
            ->where('type', 'face')
            ->get();

        $result = [];
        foreach ($identifiers as $item) {
            // Ambil angka dari identifier, contoh: FACE-user_1 → 1
            preg_match('/FACE-user_(\d+)/', $item->identifier, $matches);
            if (isset($matches[1])) {
                $result[$matches[1]] = $item->user->name ?? 'Unknown';
            }
        }

        return response()->json($result);
    }
}
