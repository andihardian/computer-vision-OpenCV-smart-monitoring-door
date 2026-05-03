<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingApiController extends Controller
{
    public function notifications()
    {
        return response()->json([
            'granted' => Setting::get('telegram_notif_granted', '1') === '1',
            'denied'  => Setting::get('telegram_notif_denied',  '1') === '1',
        ]);
    }
}