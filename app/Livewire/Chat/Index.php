<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public string $messageInput = '';
    public int $pollInterval = 3000; // 3 seconds

    public function sendMessage()
    {
        if (trim($this->messageInput) === '') return;

        $this->validate(['messageInput' => 'required|string|max:2000']);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => null, // null means group chat
            'body'        => $this->messageInput,
        ]);

        $this->messageInput = '';

        // Log activity
        \App\Models\ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'SEND_GROUP_MESSAGE',
            'description' => Auth::user()->name . ' mengirim pesan di grup chat.',
            'ip_address'  => request()->ip(),
        ]);
    }

    public function render()
    {
        // Get all group messages
        $messages = Message::with('sender')
            ->whereNull('receiver_id')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.chat.index', [
            'messages' => $messages,
        ])->layout('layouts.app');
    }
}