<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function update(Request $request)
    {
        Setting::set('telegram_notif_granted', $request->has('telegram_notif_granted') ? '1' : '0');
        Setting::set('telegram_notif_denied',  $request->has('telegram_notif_denied')  ? '1' : '0');

        return redirect()->route('dashboard')->with('success', 'Pengaturan notifikasi berhasil disimpan!');
    }
}