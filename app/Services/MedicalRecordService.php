<?php

namespace App\Services;

use App\Repositories\MedicalRecordRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class MedicalRecordService
{
    protected $medicalRecordRepo;
    protected $notificationRepo;
    protected $userRepo;

    public function __construct(
        MedicalRecordRepository $medicalRecordRepo,
        NotificationRepository $notificationRepo,
        UserRepository $userRepo
    ) {
        $this->medicalRecordRepo = $medicalRecordRepo;
        $this->notificationRepo = $notificationRepo;
        $this->userRepo = $userRepo;
    }

    public function getAllPatients()
    {
        return $this->userRepo->getPatients();
    }

    public function createMedicalRecord(array $data)
    {
        // Create the medical record
        $record = $this->medicalRecordRepo->create($data);

        // Saving the uploaded files if any
        $files = $data['medical_record_file'];

        if (!empty($files)) {
            $this->medicalRecordRepo->attachFiles($record, $files);
        }

        // Create notification
        $this->notificationRepo->create([
            'patient_id' => $data['patient_id'],
            'type' => 'info',
            'message' => 'Your ' . $data['record_type'] . ' result is now available.',
            'status' => 'Unread',
        ]);

        return $record;
    }

    public function getMedicalRecordsForDataTable($request)
    {
        $records = $this->medicalRecordRepo->query();

        // Restrict to logged-in patient's own records
        if (Auth::user()->hasRole('patient')) {
            $records->where('patient_id', Auth::user()->patient->id ?? 0);
        }

        $records->orderBy('created_at', 'desc');

        return $records;
    }

    public function getMedicalRecord($id)
    {
        return $this->medicalRecordRepo->find($id);
    }

   public function updateMedicalRecord(array $data)
    {
        // Find the medical record
        $record = $this->medicalRecordRepo->find($data['medical_record_id']);

        if (!$record) {
            throw new \Exception("Medical record not found.");
        }

        // Update the record fields
        $record->update([
            'patient_id'  => $data['patient_id'],
            'record_type' => $data['record_type'],
            'description' => $data['description'],
            'record_date' => $data['record_date'],
        ]);

        // Attach new file if provided
        if (!empty($data['medical_record_file'])) {
            $this->medicalRecordRepo->attachFiles($record, $data['medical_record_file']);
        }

        // Optional: create a new notification (if you want to notify patient on update)
        $this->notificationRepo->create([
            'patient_id' => $data['patient_id'],
            'type' => 'info',
            'message' => 'Your ' . $data['record_type'] . ' result has been updated.',
            'status' => 'Unread',
        ]);

        return $record;
    }


}
