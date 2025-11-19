<?php

namespace App\Repositories;

use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Storage;

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
            $path = $file->store('medical_records', 'public');

            $medicalRecord->files()->create([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }
    }

    public function find($id)
    {
        return MedicalRecord::findOrFail($id);
    }

    public function updateRecord($medicalRecord)
    {
        // Update basic fields
        $medicalRecord->update([
            'patient_id'  => $medicalRecord->patient_id,
            'record_type' => $medicalRecord->record_type,
            'description' => $medicalRecord->description,
            'record_date' => $medicalRecord->record_date,
        ]);

        // Attach new files if provided
        if (!empty($data['medical_record_file'])) {
            $this->attachFiles($medicalRecord, $data['files']);
        }

        return $medicalRecord;
    }

    public function delete($medicalRecord)
    {
        // Delete associated files from storage and database
        foreach ($medicalRecord->files as $file) {
            if (Storage::exists($file->file_path)) {
                Storage::delete($file->file_path); // delete file from storage
            }
            $file->delete(); // delete DB record
        }

        // Delete the medical record itself
        $medicalRecord->delete();
    }

}
