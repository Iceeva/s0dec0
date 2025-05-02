<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    protected $fillable = [
        'immatriculation', 'chauffeur', 'date_heure', 
        'poids_total_brut', 'poids_total_net', 'statut'
    ];

    public function balles()
    {
        return $this->belongsToMany(Balle::class);
    }
}