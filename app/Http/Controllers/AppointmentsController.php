<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Services\AppointmentService;

/**
 * Controller managing appointments.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class AppointmentsController extends Controller
{
    protected $service;

    public function __construct(AppointmentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('app.appointments.appointments');
    }

    public function list()
    {
        $appointments = $this->service->listAppointments();

        return DataTables::of($appointments)
            ->addColumn('name', fn($appt) => $appt->patient?->name ?? $appt->user?->email ?? 'N/A')
            ->addColumn('title', fn($appt) => $appt->title)
            ->addColumn('appointment_date', fn($appt) => date('M d, Y', strtotime($appt->appointment_date)))
            ->addColumn('appointment_time', fn($appt) => date('h:i A', strtotime($appt->appointment_time)))
            ->addColumn('notes', fn($appt) => $appt->notes ?? '')
            ->addColumn('status', function ($appt) {
                $statusText = ucfirst($appt->status);
                $buttons = '';
                $user = auth()->user();

                if ($appt->status === 'Pending' && $user->hasAnyRole(['admin', 'doctor'])) {
                    $buttons .= '<div class="ms-auto">';
                    $buttons .= '<button class="btn btn-sm btn-warning cancelAppointment" data-id="' . $appt->id . '">Cancel</button> ';
                    $buttons .= '<button class="btn btn-sm btn-success confirmAppointment" data-id="' . $appt->id . '">Confirm</button>';
                    $buttons .= '</div>';
                }

                if ($appt->status === 'Pending' && $user->id === $appt->user_id) {
                    $buttons .= '<button class="btn btn-sm btn-warning cancelAppointment ms-auto" data-id="' . $appt->id . '">Cancel</button>';
                }

                return '<div class="d-flex align-items-center">' . $statusText . $buttons . '</div>';
            })
            ->addColumn('action', function ($appt) {
                if ($appt->status === 'Confirmed') {
                    return '...';
                } else if ($appt->status === 'Cancelled') {
                    return '<button class="btn btn-sm btn-danger deleteBtn" data-id="' . $appt->id . '">Delete</button>';
                } else if ($appt->status === 'Pending') {
                    return '
                        <button class="btn btn-sm btn-warning editAppointment" data-id="' . $appt->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $appt->id . '">Delete</button>
                    ';
                }
            })
            ->filter(function ($query) {
                if ($search = request('search')['value'] ?? false) {
                    $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                            ->orWhere('notes', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%");
                    });
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'required|string|max:1000',
        ]);

        $this->service->createAppointment($validated);

        return response()->json(['message' => 'Appointment created successfully!']);
    }

    public function show($id)
    {
        $data = $this->service->getAppointment($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'required|string|max:1000',
        ]);

        $this->service->updateAppointment($request->appointment_id, $validated);

        return response()->json(['message' => 'Appointment updated successfully']);
    }

    public function delete($id)
    {
        $this->service->deleteAppointment($id);
        return response()->json(['message' => 'Appointment deleted successfully']);
    }

    public function cancel($id)
    {
        $this->service->changeStatus($id, 'Cancelled');
        return response()->json(['message' => 'Appointment cancelled successfully']);
    }

    public function confirm($id)
    {
        $this->service->changeStatus($id, 'Confirmed');
        return response()->json(['message' => 'Appointment confirmed successfully']);
    }
}
