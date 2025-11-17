<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ProfilePatientManagementController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('app.profile_patient_management', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->roles()->attach($request->role_id);

        return response()->json(['message' => 'User profile created successfully']);
    }

    public function list()
    {
        // Get users who have 'patient' role, including patient info
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'patient');
        })->with('patient', 'roles');

        return DataTables::of($users)
            ->addColumn('name', function ($user) {
                return $user->patient ? $user->patient->name : '';
            })
            ->addColumn('email', function ($user) {
                return $user->patient ? $user->patient->email : $user->email;
            })
            ->addColumn('roles', function ($user) {
                return $user->roles->pluck('name')->implode(', ');
            })
            ->addColumn('created_at', function ($user) {
                return $user->created_at->format('Y-m-d H:i:s');
            })
            ->make(true);
    }
}
