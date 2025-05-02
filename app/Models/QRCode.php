<?php

// app/Models/QrCode.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $table = 'qr_codes';
    protected $fillable = [
        'reference', 'qr_data', 'url', 'file_path', 'id_balles'
    ];

    public function balle()
    {
        return $this->belongsTo(Balle::class, 'id_balles');
    }
}