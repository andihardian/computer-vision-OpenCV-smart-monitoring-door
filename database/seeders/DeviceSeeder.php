<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        Device::create([
            'name'      => 'Raspberry Pi - Pintu Utama',
            'location'  => 'Depan',
            'token'     => 'raspi-token-001',
            'is_active' => true,
        ]);
    }
}