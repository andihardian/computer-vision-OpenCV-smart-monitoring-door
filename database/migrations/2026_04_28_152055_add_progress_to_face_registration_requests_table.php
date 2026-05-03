<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('face_registration_requests', function (Blueprint $table) {
            $table->integer('progress')->default(0)->after('status'); // 0-30 foto
        });
    }

    public function down(): void
    {
        Schema::table('face_registration_requests', function (Blueprint $table) {
            $table->dropColumn('progress');
        });
    }
};