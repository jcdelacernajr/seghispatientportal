<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\PatientRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 *  Service for managing patient profiles.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class ProfilePatientService
{
    protected $userRepo;
    protected $patientRepo;

    public function __construct(UserRepository $userRepo, PatientRepository $patientRepo)
    {
        $this->userRepo = $userRepo;
        $this->patientRepo = $patientRepo;
    }

    public function createPatient(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = $this->userRepo->createUser([
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->roles()->attach($data['role_id']);

            // Only create patient record if role is 'patient'
            $role = $user->roles()->first();
            if ($role && strtolower($role->name) === 'patient') {
                $this->patientRepo->createPatient([
                    'user_id' => $user->id,
                    'name'    => $data['name'],
                    'phone'   => $data['phone_no'],
                    'address' => $data['address'],
                    'email'   => $user->email,
                ]);
            }

            return $user;
        });
    }

    public function updatePatient(int $userId, array $data)
    {
        return DB::transaction(function () use ($userId, $data) {
            $user = $this->userRepo->findById($userId);
            $user->email = $data['email'];

            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            $user->save();
            $user->roles()->sync([$data['role_id']]);

            $role = $user->roles()->first();
            if ($role && strtolower($role->name) === 'patient') {
                $this->patientRepo->updatePatient($userId, [
                    'name'    => $data['name'],
                    'phone'   => $data['phone_no'],
                    'address' => $data['address'],
                    'email'   => $data['email'],
                ]);
            }

            return $user;
        });
    }

    public function deletePatient(int $userId)
    {
        return DB::transaction(function () use ($userId) {
            $this->patientRepo->deleteByUserId($userId);
            $this->userRepo->deleteUser($userId);
        });
    }

    public function listPatients()
    {
        // Orchestrates repository call to get users
        return $this->userRepo->listPatients();
    }

    public function getPatientById(int $id)
    {
        // Service orchestrates repository call
        return $this->userRepo->findById($id);
    }

}
