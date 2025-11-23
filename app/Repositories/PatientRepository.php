<?php

namespace App\Repositories;

use App\Models\Patients;

class PatientRepository
{
    public function createPatient(array $data)
    {
        return Patients::create($data);
    }

    public function findByUserId($userId)
    {
        return Patients::where('user_id', $userId)->firstOrFail();
    }

    public function updatePatient($userId, array $data)
    {
        $patient = $this->findByUserId($userId);
        $patient->update($data);
        return $patient;
    }

    public function deleteByUserId($userId)
    {
        return Patients::where('user_id', $userId)->delete();
    }
}
