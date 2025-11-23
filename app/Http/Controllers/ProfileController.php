<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller managing user profiles.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class ProfileController extends Controller
{
    public function index()
    {
        return view('app.profile');
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            // Get user roles
            $isAdminOrDoctor = $user->hasAnyRole(['admin', 'doctor']);

            // Validation rules
            $rules = [
                'email' => 'required|email|max:50|unique:users,email,' . $user->id,
                'password' => 'nullable|min:6|confirmed',
            ];

            // Only require 'name' if user is NOT admin or doctor (i.e., is patient)
            if (!$isAdminOrDoctor) {
                $rules['name'] = 'required|string|max:50';
            }

            // Validate the input data
            $request->validate($rules);

            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // Save the user record
            $user->save();

            // Only update patient info if the user has a patient record
            if (!$isAdminOrDoctor && $user->patient) {
                $patient = $user->patient;
                $patient->name = $request->name;
                $patient->email = $request->email;
                $patient->save();
            }

            return response()->json(['message' => 'Profile updated successfully!']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update profile record.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
