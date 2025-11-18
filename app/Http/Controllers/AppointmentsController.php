<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

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
                 return $appt->patient ? $appt->patient->name : $appt->user->email; // this is null 
            })
            ->addColumn('title', function ($appt) {
                return $appt->title;
            })
            ->addColumn('appointment_date', function ($appt) {
                return date('M d, Y', strtotime($appt->appointment_date));
            })
            ->addColumn('appointment_time', function ($appt) {
                return date('h:i A', strtotime($appt->appointment_time));
            })
            ->addColumn('notes', function ($appt) {
                return $appt->notes ?? '';
            })
            ->addColumn('status', function ($appt) {
                $statusText = ucfirst($appt->status);

                $buttons = '';
                $user = auth()->user();
                // Admin or Doctor can Confirm and Cancel Pending appointments
                if ($appt->status === 'Pending' && ($user->hasRole('admin') || $user->hasRole('doctor'))) {

                    $buttons .= '<div class="ms-auto">';
                    // Cancel button
                    $buttons .= ' <button 
                        class="btn btn-sm btn-warning cancelAppointment" 
                        data-id="' . $appt->id . '">
                        Cancel
                    </button>';

                    // Confirm button
                    $buttons .= ' <button 
                        class="btn btn-sm btn-success confirmAppointment" 
                        data-id="' . $appt->id . '">
                        Confirm
                    </button>';

                    $buttons .= '</div>';
                }

                // Patient (appointment owner) can Cancel their own Pending appointment
                if ($appt->status === 'Pending' && $user->id === $appt->user_id) {
                    $buttons .= ' <button 
                        class="btn btn-sm btn-warning cancelAppointment ms-auto" 
                        data-id="' . $appt->id . '">
                        Cancel
                    </button>';
                }

                // Wrap status text and buttons in a flex container
                return '<div class="d-flex align-items-center">' . $statusText . $buttons . '</div>';
            })
            ->addColumn('action', function ($appt) {
                return '
                <button 
                    class="btn btn-sm btn-warning editAppointment"
                    data-id="' . $appt->id . '">
                    Edit
                </button>

                <button 
                    class="btn btn-sm btn-danger deleteBtn"
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
            ->rawColumns(['status','action'])
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

        $validated['user_id'] = Auth::id();

        Appointment::create($validated);

        return response()->json(['message' => 'Appointment created successfully!']);
    }

    public function show($id)
    {
        $data = Appointment::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
         try {

            $appoitnmentId = $request->input('appointment_id');

            $validated = $request->validate([
                'title'             => 'required|string',
                'appointment_date'  => 'required|date',
                'appointment_time'  => 'required',
                'notes'             => 'required|string|max:1000',
            ]);

            DB::beginTransaction();
            $appointment = Appointment::findOrFail($appoitnmentId);
            $appointment->update([
                'title'            => $validated['title'],
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
                'notes'            => $validated['notes'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Patient appointment updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update patient appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        Appointment::destroy($id);
        return response()->json(['message' => 'Patient Appointment deleted successfully!']);
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'Cancelled';
        $appointment->save();

        return response()->json(['message' => 'Appointment cancelled successfully.']);
    }

    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'Confirmed';
        $appointment->save();

        return response()->json(['message' => 'Appointment confirmed successfully.']);
    }

}
