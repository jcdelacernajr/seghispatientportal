<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    
    public function markRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['status' => 'Read']);

        return response()->json(['message' => 'Notification marked as read']);
    }

}
