<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expeditions', function (Blueprint $table) {
            $table->integer('oc')->primary(); // Numéro OC comme clé primaire
            $table->string('ic', 20); // Numéro IC
            $table->dateTime('date_heure'); // Date et heure
            $table->string('type_vente', 100)->nullable(); // Type de vente
            $table->string('longueur_soie', 50)->nullable(); // Longueur de soie
            $table->integer('nbr_balles'); // Nombre de balles
            $table->decimal('poids_brut', 10, 2); // Poids brut
            $table->decimal('poids_net', 10, 2); // Poids net
            $table->string('immatriculation', 20); // Immatriculation
            $table->string('chauffeur_nom', 100); // Nom du chauffeur
            $table->string('usine_provenance', 100)->nullable(); // Usine de provenance
            $table->enum('etape', ['Synchronisé', 'Réceptionné'])->default('Synchronisé'); // Étape
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expeditions'); 
    }
};