<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Store a new message for a user.
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Gửi tin nhắn thành công!');
    }

    /**
     * Update the specified message.
     */
    public function update(Request $request, Message $message)
    {
        if ($message->sender_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ]);

        $message->update(['content' => $request->input('content')]);

        return back()->with('success', 'Cập nhật tin nhắn thành công!');
    }

    /**
     * Remove the specified message.
     */
    public function destroy(Message $message)
    {
        if ($message->sender_id !== Auth::id()) {
            abort(403);
        }

        $message->delete();

        return back()->with('success', 'Xóa tin nhắn thành công!');
    }
}
