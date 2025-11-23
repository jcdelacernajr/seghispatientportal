<?php

namespace App\Repositories;

use App\Models\Appointment;
use PhpParser\ErrorHandler\Collecting;

/**
 *  Repository for managing appointments.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
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

    /**
     * Retrieve upcoming confirmed appointments
     * 
     * This method fetches appointments with a status of "Confirmed",
     * If the user has the "patient" role, the results are limited to appointments
     * belonging specifically to that patient.
     * 
     * @param  User         $user 
     * @param  int          $limit (default: 10).
     * @return Collecting   A collection of upcoming confirmed appointments, optionally filtered by user.
     */
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
