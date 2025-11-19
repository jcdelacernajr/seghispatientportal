<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('app.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

       // $user->update($request->only('name', 'email', 'phone', 'address'));

        // Return JSON response for AJAX
        return response()->json(['message' => 'Profile updated successfully!']);
    }

    public function edit()
    {
       
    } 
}
