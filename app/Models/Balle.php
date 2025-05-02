<?php

// app/Models/Balle.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balle extends Model
{
    protected $table = 'balles';
    protected $fillable = [
        'reference', 'date_sortie', 'poids_brut', 'poids_net', 
        'variete', 'marquage', 'longueur_soie', 'type_vente',
        'est_classe', 'date_classement', 'usine', 'qr_code_id'
    ];

    public function qrCode()
    {
        return $this->hasOne(QrCode::class, 'id', 'qr_code_id');
    }
}