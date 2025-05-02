<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRCodeScan extends Model
{
    protected $fillable = [
        'user_id',
        'qr_code_id',
        'scanned_at',
        'location',
    ];

    protected $dates = [
        'scanned_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QRCode::class);
    }
}