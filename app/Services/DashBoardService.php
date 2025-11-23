<?php

namespace App\Services;

use App\Repositories\AppointmentRepository;
use App\Repositories\NotificationRepository;

class DashboardService
{
    protected $appointments;
    protected $notifications;

    public function __construct(
        AppointmentRepository $appointments,
        NotificationRepository $notifications
    ) {
        $this->appointments = $appointments;
        $this->notifications = $notifications;
    }

    public function getDashboardData($user)
    {
        // Appointments
        $appointments = $this->appointments->getUpcommingAppointmentsForUser($user);

        // Notifications (only for patients)
        $notifications = collect();
        if ($user->hasRole('patient')) {
            $notifications = $this->notifications->getUnreadNotificationsForPatient(
                $user->patient->id ?? 0
            );
        }

        return [
            'user'          => $user,
            'appointments'  => $appointments,
            'notifications' => $notifications,
        ];
    }
}
