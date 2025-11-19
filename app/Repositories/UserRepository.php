<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function findById($id)
    {
        return User::with('patient', 'roles')->findOrFail($id);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();
        return true;
    }

    public function listPatients()
    {
        return User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['patient']);
        })
        ->with('roles')
        ->orderBy('id', 'desc');
    }

    public function getPatients()
    {
        return User::whereHas('roles', function ($q) {
            $q->where('name', 'Patient');
        })->with('patient')->get();
    }
}
