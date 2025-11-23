<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model representing a file associated with a medical record.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
