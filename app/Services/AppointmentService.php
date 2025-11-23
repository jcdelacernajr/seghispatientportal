<?php

namespace App\Services;

use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 *  Service for managing appointments.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class AppointmentService
{
    protected $appointmentRepo;

    public function __construct(AppointmentRepository $appointmentRepo)
    {
        $this->appointmentRepo = $appointmentRepo;
    }

    public function listAppointments()
    {
        $user = Auth::user();

        $query = $this->appointmentRepo->query()->orderBy('id', 'desc');

        if (!$user->hasAnyRole(['admin', 'doctor'])) {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public function createAppointment(array $data)
    {
        $data['user_id'] = Auth::id();
        return $this->appointmentRepo->create($data);
    }

    public function getAppointment($id)
    {
        return $this->appointmentRepo->find($id);
    }

    public function updateAppointment($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->appointmentRepo->update($id, $data);
        });
    }

    public function deleteAppointment($id)
    {
        return $this->appointmentRepo->delete($id);
    }

    public function changeStatus($id, string $status)
    {
        $appointment = $this->appointmentRepo->find($id);
        if (!$appointment) {
            throw new \Exception("Appointment not found");
        }
        $appointment->status = $status;
        $appointment->save();
        return $appointment;
    }
}
