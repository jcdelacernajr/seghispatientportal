<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patients;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([ 
            'name' => 'required|string|max:255',
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assign default patient role
        $patientRole = Role::where('name', 'patient')->first();
        if ($patientRole) {
            $user->roles()->attach($patientRole->id);
        }

        // Create patient record
        Patients::create([
            'user_id' => $user->id,
            'name'    => $validated['name'] ?? 'Patient Name', // default if name not collected
            'email'   => $user->email,
        ]);

        auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Account created successfully!');
    }
}
