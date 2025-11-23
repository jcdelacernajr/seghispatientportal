<?php

namespace App\Repositories;

use App\Models\Notification;

class NotificationRepository
{
    public function getUnreadNotificationsForPatient($patientId)
    {
        return Notification::where('patient_id', $patientId)
            ->with('medicalRecordsFiles.files')
            ->where('status', 'Unread')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(array $data)
    {
        return Notification::create($data);
    }

}
