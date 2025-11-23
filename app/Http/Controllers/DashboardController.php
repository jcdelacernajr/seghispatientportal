<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Services\DashboardService;

/**
 * Controller for the user dashboard.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class DashboardController extends Controller
{
    protected $dashboard;

    public function __construct(DashboardService $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function index()
    {
        $user = Auth::user();

        $data = $this->dashboard->getDashboardData($user);

        return view('app.dashboard', $data);
    }
}
