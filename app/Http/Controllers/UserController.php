<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->get();

        // Count received messages per sender for the current user
        $messageCounts = \App\Models\Message::where('receiver_id', Auth::id())
            ->selectRaw('sender_id, count(*) as count')
            ->groupBy('sender_id')
            ->pluck('count', 'sender_id');

        return view('users.index', compact('users', 'messageCounts'));
    }

    /**
     * Display the specified user's profile with messages.
     */
    public function show(User $user)
    {
        $isOwnProfile = $user->id === Auth::id();

        if ($isOwnProfile) {
            // Viewing own profile: show all received messages from everyone
            $messages = \App\Models\Message::where('receiver_id', Auth::id())
                ->with('sender')
                ->latest()
                ->get();
        } else {
            // Viewing another user: show conversation between current user and that user
            $messages = \App\Models\Message::where(function ($query) use ($user) {
                    $query->where('sender_id', Auth::id())
                          ->where('receiver_id', $user->id);
                })
                ->orWhere(function ($query) use ($user) {
                    $query->where('sender_id', $user->id)
                          ->where('receiver_id', Auth::id());
                })
                ->with('sender')
                ->latest()
                ->get();
        }

        return view('users.show', compact('user', 'messages', 'isOwnProfile'));
    }
}
