<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patients;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Services\RegisterService;
use Illuminate\Support\Facades\Validator;

/**
 * Controller handling user registration.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class RegisterController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
         $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required','email','unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/'
            ],
        ];

        $messages = [
            'password.regex' => 'Password must be at least 8 characters and include at least one uppercase letter, one lowercase letter,
                                     one number, and one special character.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least :min characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];

        $validated = $request->validate($rules, $messages);

        $this->registerService->registerUser($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Account created successfully!')
            ->onlyInput('name', 'email');
    }

}
