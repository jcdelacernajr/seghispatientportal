<?php

namespace App\Repositories;

use App\Models\MedicalRecord;

class MedicalRecordRepository
{
    public function create(array $data)
    {
        return MedicalRecord::create($data);
    }

    public function query()
    {
        return MedicalRecord::with('patient');
    }
}
