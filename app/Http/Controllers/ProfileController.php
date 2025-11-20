<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|email|max:50|unique:users,email,' . $user->id,
                'password' => 'required|min:6|confirmed',
            ]);

            $user->email = $request->email;
            if ($request->filled('password')) {
                //$user->password = bcrypt($request->password);
                $user->password = Hash::make($request->password);
            }

            $user->save();

            $patient = $user->patient;
            if ($patient) {
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
