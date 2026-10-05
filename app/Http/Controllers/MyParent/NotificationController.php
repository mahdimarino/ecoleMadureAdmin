<?php

namespace App\Http\Controllers\MyParent;

use App\Http\Controllers\Controller;
use App\Models\ParentNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('my_parent');
    }

    public function index()
    {
        $notifications = ParentNotification::where(
            'parent_id',
            Auth::id()
        )
            ->with([
                'student.user'
            ])
            ->latest()
            ->paginate(15);

        return view(
            'pages.parent.notifications',
            compact('notifications')
        );
    }

    public function read($id)
    {
        $notification = ParentNotification::where(
            'parent_id',
            Auth::id()
        )
            ->findOrFail($id);

        $notification->update([
            'read_at' => now(),
        ]);

        return back();
    }
}
