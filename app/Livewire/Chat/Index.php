<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public string $messageInput = '';
    public int $pollInterval = 3000; // 3 seconds

    // Reply & Edit state
    public ?int $replyingToMessageId = null;
    public ?int $editingMessageId = null;
    public string $editMessageInput = '';

    public function sendMessage()
    {
        if (trim($this->messageInput) === '') return;

        $this->validate(['messageInput' => 'required|string|max:2000']);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => null, // null = group chat
            'reply_to_id' => $this->replyingToMessageId,
            'body'        => $this->messageInput,
            'periode_id'  => optional(Periode::active())->id,
        ]);

        $this->messageInput = '';
        $this->replyingToMessageId = null;
    }

    public function getReplyingToMessageProperty()
    {
        return $this->replyingToMessageId
            ? Message::withTrashed()->with(['sender', 'replyTo' => function ($q) {
                $q->withTrashed()->with('sender');
            }])->find($this->replyingToMessageId)
            : null;
    }

    public function startReply(int $messageId)
    {
        $this->replyingToMessageId = $messageId;
        $this->cancelEdit();
    }

    public function cancelReply()
    {
        $this->replyingToMessageId = null;
    }

    public function startEdit(int $messageId)
    {
        $message = Message::find($messageId);

        if ($message && $message->sender_id === Auth::id() && $message->created_at->diffInMinutes(now()) <= 15) {
            $this->editingMessageId = $message->id;
            $this->editMessageInput = $message->body;
        } else {
            $this->cancelEdit();
            $this->dispatch('chat-error', 'Waktu edit sudah habis (maks 15 menit) atau pesan tidak ditemukan.');
        }
    }

    public function cancelEdit()
    {
        $this->editingMessageId = null;
        $this->editMessageInput = '';
    }

    public function updateMessage()
    {
        if (trim($this->editMessageInput) === '' || !$this->editingMessageId) return;

        $this->validate(['editMessageInput' => 'required|string|max:2000']);

        $message = Message::find($this->editingMessageId);

        if ($message && $message->sender_id === Auth::id() && $message->created_at->diffInMinutes(now()) <= 15) {
            $message->update([
                'body'      => $this->editMessageInput,
                'is_edited' => true,
            ]);
        }

        $this->cancelEdit();
    }

    public function deleteMessage(int $messageId)
    {
        $message = Message::find($messageId);

        if ($message && $message->sender_id === Auth::id() && $message->created_at->diffInMinutes(now()) <= 15) {
            $message->delete();
        } else {
            $this->dispatch('chat-error', 'Waktu hapus sudah habis (maks 15 menit) atau pesan tidak ditemukan.');
        }
    }

    public function render()
    {
        $activePeriodeId = optional(Periode::active())->id;

        $messages = Message::withTrashed()
            ->with(['sender', 'replyTo' => function ($q) {
                $q->withTrashed()->with('sender');
            }])
            ->whereNull('receiver_id')
            ->where('periode_id', $activePeriodeId)
            ->orderBy('created_at', 'asc')
            ->get();

        $latestMessage = $messages->last();
        if ($latestMessage && Auth::user()->last_read_message_id !== $latestMessage->id) {
            Auth::user()->update(['last_read_message_id' => $latestMessage->id]);
        }

        $users = \App\Models\User::where('periode_id', $activePeriodeId)->get(['id', 'name']);

        return view('livewire.chat.index', [
            'messages' => $messages,
            'users'    => $users,
        ])->layout('layouts.app');
    }
}
