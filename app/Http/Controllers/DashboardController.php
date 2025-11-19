<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Base query: pending appointments
        $query = Appointment::where('status', 'Pending')
            ->orderBy('appointment_date', 'asc');

        // Check user role
        if ($user->hasRole('patient')) {
            // Patient sees only their own appointments
            $query->where('user_id', $user->id);

            
        }

        // Get results (limit 5 for dashboard)
        $appointments = $query->take(5)->get();

        // Fetch notifications only if user is a patient
        $notifications = collect(); // default empty collection
        if ($user->hasRole('patient')) {
            $notifications = Notification::where('patient_id', $user->patient->id ?? 0)
                ->where('status', 'Unread')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('app.dashboard', compact('user', 'appointments', 'notifications'));
    }
}
