<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('balles', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->date('date_sortie');
            $table->decimal('poids_brut', 10, 2);
            $table->decimal('poids_net', 10, 2);
            $table->string('variete', 50);
            $table->string('marquage', 50);
            $table->decimal('longueur_soie', 5, 2);
            $table->string('type_vente', 50);
            $table->boolean('est_classe')->default(false);
            $table->date('date_classement')->nullable();
            $table->string('usine', 100);
            $table->foreignId('qr_code_id')->nullable()->constrained('qr_codes')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('balles', function (Blueprint $table) {
            $table->dropForeign(['qr_code_id']);
        });
        Schema::dropIfExists('balles');
    }
};