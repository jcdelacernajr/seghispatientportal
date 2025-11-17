<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Patients;
use Illuminate\Support\Facades\DB;
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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone_no' => 'required|string|max:11',
                'address' => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
                'role_id' => 'required|exists:roles,id'
            ]);

            DB::beginTransaction();

            // Create the patient user data
            $user = User::create([
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Assign the selected role
            $user->roles()->attach($validated['role_id']);

            // Create patient record
            Patients::create([
                'user_id' => $user->id,
                'name'    => $validated['name'],
                'phone_no' => $validated['phone_no'],
                'address' => $validated['address'],
                'email'   => $user->email,
            ]);

            DB::commit();

            return response()->json(['message' => 'Patient profile created successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); // ROLLBACK if something fails
            return response()->json([
                'message' => 'Failed to create user profile',
                'error' => $e->getMessage()
            ], 500);
        }
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
            ->addColumn('action', function ($user) {
                return '
                    <button class="btn btn-sm btn-primary editUser" data-id="' . $user->id . '">
                        Edit
                    </button>
                    <button class="btn btn-sm btn-danger deleteUser" data-id="' . $user->id . '">
                        Delete
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
