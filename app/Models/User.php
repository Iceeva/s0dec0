<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\QRCodeScanScan;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    
     // ...

     protected $fillable = [
        'name', 'email', 'password', 'role', 'phone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function is_admin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is an agent.
     *
     * @return bool
     */
    public function isAgent()
    {
        return $this->role === 'agent';
    }

    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    public function scans(): HasMany
    {
        return $this->hasMany(QRCodeScan::class);
    }
}
