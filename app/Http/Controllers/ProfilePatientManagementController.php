<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\RoleRepository;
use App\Services\ProfilePatientService;

class ProfilePatientManagementController extends Controller
{
    protected $roleRepo;
    protected $service;

    public function __construct(RoleRepository $roleRepo, ProfilePatientService $service)
    {
        $this->roleRepo = $roleRepo;
        $this->service = $service;
    }

    public function index()
    {
        $roles = $this->roleRepo->getAllRoles();
        return view('app.profile_patient_management', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_no' => 'required|string|max:11',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);

        try {
            // Create patient profile
            $this->service->createPatient($validated);

            // Create Admin and Doctor profiles if needed
            // TODO ...

            return response()->json(['message' => 'Patient profile created successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create patient profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('user_id');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_no' => 'required|string|max:11',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);

        try {
            $this->service->updatePatient($id, $validated);
            return response()->json(['message' => 'Patient profile updated successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update patient profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function patient($id)
    {
        try {
            $user = $this->service->getPatientById($id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Patient not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }


    public function delete($id)
    {
        try {
            $this->service->deletePatient($id);
            return response()->json(['message' => 'Patient profile deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete patient profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function list()
    {
        $users = $this->service->listPatients();

        return DataTables::of($users)
            ->addColumn('name', fn($user) => $user->patient?->name ?? '')
            ->addColumn('email', fn($user) => $user->patient?->email ?? $user->email)
            ->addColumn('roles', fn($user) => $user->roles->pluck('name')->implode(', '))
            ->addColumn('created_at', fn($user) => date('M d, Y', strtotime($user->created_at)))
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
