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
                'phone' => $validated['phone_no'],
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

    public function patient($id)
    {
        $user = User::with('patient', 'roles')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request)
    {
        try {

            $id = $request->input('user_id');

            $validated = $request->validate([
                'name'       => 'required|string|max:255',
                'email'      => 'required|email|unique:users,email,' . $id,
                'phone_no'   => 'required|string|max:11',
                'address'    => 'required|string|max:255',
                'password'   => 'nullable|string|min:6|confirmed',
                'role_id'    => 'required|exists:roles,id'
            ]);

            DB::beginTransaction();

            // Fetch the user
            $user = User::findOrFail($id);

            // Update user email
            $user->email = $validated['email'];

            // Update password only if provided
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            // Sync role
            $user->roles()->sync([$validated['role_id']]);

            // Update patient record
            $patient = Patients::where('user_id', $user->id)->firstOrFail();
            $patient->update([
                'name'    => $validated['name'],
                'phone'   => $validated['phone_no'],
                'address' => $validated['address'],
                'email'   => $validated['email'], // Keep sync with user
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Patient profile updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update patient profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            // Delete patient record first
            Patients::where('user_id', $id)->delete();

            // Detach roles
            $user->roles()->detach();

            // Delete user
            $user->delete();

            DB::commit();

            return response()->json(['message' => 'Patient profile deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to delete patient profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function list()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['patient', 'doctor']);
        })
        ->with('roles')
        ->orderBy('id', 'desc');

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
                    <button class="btn btn-sm btn-primary editProfilePatient" data-bs-toggle="modal" data-bs-target="#editProfileModal" data-id="' . $user->id . '">
                        Edit
                    </button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $user->id . '">
                        Delete
                    </button>
                ';
            })
            ->filter(function ($query) {
                if ($search = request('search')['value'] ?? false) {
                    $query->where(function ($q) use ($search) {
                        $q->whereHas('patient', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhere('email', 'like', "%{$search}%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
