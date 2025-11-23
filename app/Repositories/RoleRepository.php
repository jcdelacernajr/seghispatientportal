<?php

namespace App\Repositories;

use App\Models\Role;

/**
 *  Repository for managing roles.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class RoleRepository
{
    public function getAllRoles()
    {
        return Role::all();
    }

    public function getByName(string $name)
    {
        return Role::where('name', $name)->first();
    }
}
