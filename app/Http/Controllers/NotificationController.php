<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Get notifications for the authenticated user
        return Notification::where('user_id', Auth::id())->get();
    }

    public function markAsRead(Notification $notification)
    {
        // Logic to mark as read if you add a 'read_at' column later
        // For now just return it
        return $notification;
    }
}
