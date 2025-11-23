<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patients;

/**
 * Model representing a medical record.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class MedicalRecord extends Model
{
    use HasFactory;

      // Specify the table (optional if naming follows convention)
    protected $table = 'medical_records';

    // Fields that can be mass-assigned
    protected $fillable = [
        'patient_id',
        'record_type',
        'description',
        'record_date',
    ];

    /**
     * Relationship: Each medical record belongs to a patient
     */
    public function patient()
    {
        return $this->belongsTo(Patients::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

}
