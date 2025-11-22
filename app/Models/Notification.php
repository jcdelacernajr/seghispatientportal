<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing a notification.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'type',
        'message',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicalRecords()
    {
         return $this->belongsTo(MedicalRecord::class, 'patient_id', 'patient_id');
    }

    public function medicalRecordsFiles()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id', 'patient_id');
    }
}
