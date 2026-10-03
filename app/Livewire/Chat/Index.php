<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public ?int $activeChatUserId = null;
    public string $messageInput = '';
    public int $pollInterval = 3000; // 3 seconds

    public function getActiveUserProperty()
    {
        return $this->activeChatUserId ? User::find($this->activeChatUserId) : null;
    }

    public function selectUser(int $userId)
    {
        $this->activeChatUserId = $userId;
        $this->messageInput = '';

        // Mark all messages from this user as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function sendMessage()
    {
        if (!$this->activeChatUserId || trim($this->messageInput) === '') return;

        $this->validate(['messageInput' => 'required|string|max:2000']);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $this->activeChatUserId,
            'body'        => $this->messageInput,
        ]);

        $this->messageInput = '';

        // Log activity
        \App\Models\ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'SEND_MESSAGE',
            'description' => Auth::user()->name . ' mengirim pesan.',
            'ip_address'  => request()->ip(),
        ]);
    }

    public function render()
    {
        $currentUserId = Auth::id();

        // Get all users except admin and current user
        $users = User::where('id', '!=', $currentUserId)
            ->where('role', '!=', 'admin')
            ->orderBy('name')
            ->get()
            ->map(function ($user) use ($currentUserId) {
                $user->unread_count = Message::where('sender_id', $user->id)
                    ->where('receiver_id', $currentUserId)
                    ->where('is_read', false)
                    ->count();

                $lastMsg = Message::where(function ($q) use ($user, $currentUserId) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $currentUserId);
                })->orWhere(function ($q) use ($user, $currentUserId) {
                    $q->where('sender_id', $currentUserId)->where('receiver_id', $user->id);
                })->latest()->first();

                $user->last_message = $lastMsg?->body;
                $user->last_message_at = $lastMsg?->created_at;
                return $user;
            })
            ->sortByDesc('last_message_at')
            ->values();

        // Also include admin in the list if logged user is not admin
        if (Auth::user()->role !== 'admin') {
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->unread_count = Message::where('sender_id', $admin->id)
                    ->where('receiver_id', $currentUserId)
                    ->where('is_read', false)
                    ->count();
                $lastMsg = Message::where(function ($q) use ($admin, $currentUserId) {
                    $q->where('sender_id', $admin->id)->where('receiver_id', $currentUserId);
                })->orWhere(function ($q) use ($admin, $currentUserId) {
                    $q->where('sender_id', $currentUserId)->where('receiver_id', $admin->id);
                })->latest()->first();
                $admin->last_message = $lastMsg?->body;
                $admin->last_message_at = $lastMsg?->created_at;
                $users->prepend($admin);
            }
        }

        $messages = [];
        if ($this->activeChatUserId) {
            $messages = Message::where(function ($q) use ($currentUserId) {
                $q->where('sender_id', $currentUserId)->where('receiver_id', $this->activeChatUserId);
            })->orWhere(function ($q) use ($currentUserId) {
                $q->where('sender_id', $this->activeChatUserId)->where('receiver_id', $currentUserId);
            })->orderBy('created_at', 'asc')->get();
        }

        return view('livewire.chat.index', [
            'users'    => $users,
            'messages' => $messages,
        ])->layout('layouts.app');
    }
}
