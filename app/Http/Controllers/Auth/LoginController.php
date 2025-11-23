<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\LoginService;
use Illuminate\Http\Request;

// Laravel’s authentication features
use Illuminate\Support\Facades\Auth;

/**
 * Controller handling user login.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class LoginController extends Controller
{
    protected $service;

    public function __construct(LoginService $service)
    {
        $this->service = $service;
    }

    public function show()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($this->service->execute($credentials, $request->boolean('remember'))) {

            $this->service->sessionRegenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Welcome!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ])->onlyInput('email'); // Repopulates email only
    }

}
