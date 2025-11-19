<?php

namespace App\Repositories;

use App\Models\Notification;

class NotificationRepository
{
    public function getUnreadNotificationsForPatient($patientId)
    {
        return Notification::where('patient_id', $patientId)
            ->where('status', 'Unread')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
