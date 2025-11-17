<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Run: php artisan make:model Patient
 */
class Patients extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'date_of_birth',
    ];

    // Relation to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
