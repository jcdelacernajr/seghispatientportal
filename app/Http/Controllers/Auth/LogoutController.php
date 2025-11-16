<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function destroy(Request $request)
    {
        // Log out the authenticated user
        Auth::logout();

        // Invalidate the current session (removes all session data)
        $request->session()->invalidate();
        // Regenerate CSRF token to prevent CSRF attacks
        $request->session()->regenerateToken();

        // Redirect to login page
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
