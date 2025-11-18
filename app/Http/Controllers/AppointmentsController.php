<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AppointmentsController extends Controller
{
    public function index()
    {
        return view('app.appointments.appointments');
    }

    public function list()
    {
        $user = Auth::user();
      
        if ($user->hasAnyRole(['admin', 'doctor'])) {
            // Admin/Doctor: show all appointments
            $appointments = Appointment::with('patient')->orderBy('id', 'desc');
        } else {
            // Patient: show only their own appointments
            $appointments = Appointment::with('patient')
                ->where('user_id', $user->id)
                ->orderBy('id', 'desc');
        }

       // dd($appointments->toSql());

        return DataTables::of($appointments)
            ->addColumn('name', function ($appt) {
                 return $appt->patient ? $appt->patient->name : ''; // this is null 
            })
            ->addColumn('title', function ($appt) {
                return $appt->title;
            })
            ->addColumn('appointment_date', function ($appt) {
                return date('Y-m-d', strtotime($appt->appointment_date));
            })
            ->addColumn('appointment_time', function ($appt) {
                return date('h:i A', strtotime($appt->appointment_time));
            })
            ->addColumn('notes', function ($appt) {
                return $appt->notes ?? '';
            })
            ->addColumn('status', function ($appt) {
                return ucfirst($appt->status);
            })
            ->addColumn('action', function ($appt) {
                return '
                <button 
                    class="btn btn-sm btn-warning editAppointment"
                    data-bs-toggle="modal"
                    data-bs-target="#editAppointmentModal"
                    data-id="' . $appt->id . '">
                    Edit
                </button>

                <button 
                    class="btn btn-sm btn-danger deleteAppointment"
                    data-id="' . $appt->id . '">
                    Delete
                </button>
            ';
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
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Appointment::create($validated);

        return response()->json(['message' => 'Appointment created successfully!']);
    }

    public function show($id)
    {
        $data = Appointment::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->update($request->all());

        return response()->json(['message' => 'Appointment updated successfully!']);
    }

    public function destroy($id)
    {
        Appointment::destroy($id);
        return response()->json(['message' => 'Appointment deleted successfully!']);
    }
}
