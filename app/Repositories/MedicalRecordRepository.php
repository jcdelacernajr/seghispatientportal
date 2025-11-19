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

    public function attachFiles($medicalRecord, $uploadedFiles)
    {
        // Ensure $uploadedFiles is always an array
        if ($uploadedFiles instanceof \Illuminate\Http\UploadedFile) {
            $uploadedFiles = [$uploadedFiles];
        }
        
        foreach ($uploadedFiles as $file) {

            // Store the file in storage/app/medical_records/
            $path = $file->store('medical_records');

            $medicalRecord->files()->create([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }
    }
}
