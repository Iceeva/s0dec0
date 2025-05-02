<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->text('qr_data')->nullable();
            $table->string('url')->nullable();
            $table->string('file_path')->nullable();
            $table->foreignId('balle_id')->nullable()->constrained('balles')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->dropForeign(['balle_id']);
        });
        Schema::dropIfExists('qr_codes');
    }
};