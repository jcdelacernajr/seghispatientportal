<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing an appointment.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'appointment_date',
        'appointment_time',
        'notes',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        // user_id in appointments matches user_id in patients table.
        return $this->belongsTo(Patients::class, 'user_id', 'user_id');
    }
}
