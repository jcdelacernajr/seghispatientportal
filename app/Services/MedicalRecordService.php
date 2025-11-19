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
        $record = $this->medicalRecordRepo->create($data);

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
}
