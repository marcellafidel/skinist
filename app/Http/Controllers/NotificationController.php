<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
                                     ->latest()
                                     ->get();

        // Mark all as read
        Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->update(['is_read' => true]);

        return view('notifications', compact('notifications'));
    }

    public function destroy($id)
    {
        Notification::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->delete();

        return back()->with('success', 'Notifikasi dihapus!');
    }
}