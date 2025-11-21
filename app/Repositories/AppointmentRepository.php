<?php

namespace App\Repositories;

use App\Models\Appointment;

class AppointmentRepository
{
     public function query()
    {
        return Appointment::with('patient');
    }

    public function find($id)
    {
        return Appointment::findOrFail($id);
    }

    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function update($id, array $data)
    {
        $appointment = $this->find($id);
        $appointment->update($data);
        return $appointment;
    }

    public function delete($id)
    {
        return Appointment::destroy($id);
    }

    public function getUpcommingAppointmentsForUser($user, $limit = 10)
    {
        $query = Appointment::where('status', 'Confirmed')
            ->with('patient')
            ->orderBy('appointment_date', 'asc');

        if ($user->hasRole('patient')) {
            $query->where('user_id', $user->id);
        }

        return $query->take($limit)->get();
    }
}
