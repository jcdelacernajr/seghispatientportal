<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

/**
 * Controller managing notifications.
 * 
 * @author Juanito Jr. Chavez Dela Cerna
 */
class NotificationController extends Controller
{
    
    public function markRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['status' => 'Read']);

        return response()->json(['message' => 'Notification marked as read']);
    }

}
