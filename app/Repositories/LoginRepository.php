<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

/**
 * Repository for managing user login.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class LoginRepository
{
    /**
     * Attempt to authenticate a user using the given credentials.
     * 
     * @param  array  $credentials  
     * @param  bool   $rememberMe   
     * @return bool  Returns true if authentication succeeds, otherwise false.
     */
    public function attempt(array $credentials, bool $rememberMe): bool
    {
        return Auth::attempt($credentials, $rememberMe);
    }

    /**
     * Regenerate the session ID.
     * 
     * @return void
     */
    public function regenerate()
    {
        session()->regenerate();
    }
}
