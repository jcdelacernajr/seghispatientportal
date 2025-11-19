<?php

namespace App\Repository;

use App\Models\Appointment;

class AppointmentRepository
{
    public function getUpcommingAppointmentsForUser($user, $limit = 5)
    {
        $query = Appointment::where('status', 'Pending')
            ->with('patient')
            ->orderBy('appointment_date', 'asc');

        if ($user->hasRole('patient')) {
            $query->where('user_id', $user->id);
        }

        return $query->take($limit)->get();
    }
}
