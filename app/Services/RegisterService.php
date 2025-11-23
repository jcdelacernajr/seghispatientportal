<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\PatientRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Service for manging user registration.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class RegisterService
{
    protected $users;
    protected $roles;
    protected $patients;

    public function __construct(
        UserRepository $users,
        RoleRepository $roles,
        PatientRepository $patients
    ) {
        $this->users    = $users;
        $this->roles    = $roles;
        $this->patients = $patients;
    }

    public function registerUser(array $data)
    {
        // 1. Create user
        $user = $this->users->createUser([
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // 2. Assign default patient role
        $patientRole = $this->roles->getByName('patient');
        if ($patientRole) {
            $this->users->attachRole($user, $patientRole->id);
        }

        // 3. Create patient record
        $this->patients->createPatient([
            'user_id' => $user->id,
            'name'    => $data['name'],
            'email'   => $user->email,
        ]);

        // 4. Login
        auth()->login($user);

        return $user;
    }
}
