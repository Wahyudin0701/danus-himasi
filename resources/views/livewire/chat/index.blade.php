<div class="w-full h-[calc(100vh-8rem)] min-h-[600px] flex flex-col bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ init() { 
    window.addEventListener('chat-error', e => alert(e.detail[0])); 
} }">
    
    {{-- Chat Header --}}
    <div class="px-6 py-4 border-b border-gray-100 bg-white flex items-center gap-4 flex-shrink-0 z-10 shadow-sm">
        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg border border-blue-200 overflow-hidden shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        
        <div>
            <h3 class="text-base font-black text-gray-900">Grup Chat Divisi</h3>
            <p class="text-xs font-medium text-gray-500">Ruang diskusi internal pengurus dan anggota</p>
        </div>
    </div>

    {{-- Messages Area --}}
    <div class="flex-1 overflow-y-auto p-6 bg-gray-50/50" id="chat-messages" wire:poll.{{ $pollInterval }}ms>
        <div class="space-y-6">
            @forelse($messages as $message)
                @php
                    $isMe = $message->sender_id === auth()->id();
                    $isEditing = $editingMessageId === $message->id;
                    $canModify = $isMe && $message->created_at->diffInMinutes(now()) <= 15;
                @endphp
                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                    <div class="flex gap-3 max-w-[90%] md:max-w-[75%] {{ $isMe ? 'flex-row-reverse' : 'flex-row' }}">
                        
                        {{-- Avatar --}}
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs border border-blue-200 overflow-hidden shrink-0 mt-1">
                            @if($message->sender && $message->sender->photo)
                                <img src="{{ asset('storage/' . $message->sender->photo) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($message->sender->name ?? '?', 0, 1) }}
                            @endif
                        </div>

                        {{-- Bubble --}}
                        <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }} w-full min-w-0 group" x-data="{ menuOpen: false }">
                            <span class="text-[11px] font-bold text-gray-600 mb-1 {{ $isMe ? 'mr-1' : 'ml-1' }}">
                                {{ $isMe ? 'Anda' : ($message->sender->name ?? 'User') }}
                            </span>
                            
                            @if($isEditing)
                                {{-- Edit Mode --}}
                                <div class="w-full bg-white border-2 border-blue-400 p-2 rounded-2xl shadow-sm min-w-[250px]">
                                    <textarea wire:model="editMessageInput" rows="2" class="w-full text-sm border-0 focus:ring-0 p-1 resize-none" oninput="this.style.height = ''; this.style.height = Math.min(this.scrollHeight, 120) + 'px'"></textarea>
                                    <div class="flex justify-end gap-2 mt-2">
                                        <button wire:click="cancelEdit" class="px-3 py-1.5 text-xs font-bold text-gray-500 hover:bg-gray-100 rounded-lg">Batal</button>
                                        <button wire:click="updateMessage" class="px-3 py-1.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">Simpan</button>
                                    </div>
                                </div>
                            @else
                                {{-- Normal Mode --}}
                                <div class="relative flex items-center gap-2 {{ $isMe ? 'flex-row-reverse' : 'flex-row' }}">
                                    
                                    {{-- The Bubble Content --}}
                                    <div class="px-4 py-2.5 rounded-2xl text-sm font-medium shadow-sm {{ $isMe ? 'bg-blue-600 text-white rounded-tr-sm' : 'bg-white border border-gray-100 text-gray-800 rounded-tl-sm' }}" style="word-break: break-word;">
                                        {{ $message->body }}
                                    </div>
                                    
                                    {{-- Actions Menu (3 dots) - Only for own messages within 15 mins --}}
                                    @if($canModify && !$isEditing)
                                        <div class="relative opacity-0 group-hover:opacity-100 transition-opacity" @click.outside="menuOpen = false">
                                            <button @click="menuOpen = !menuOpen" class="p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-700 rounded-full transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                            </button>
                                            
                                            {{-- Dropdown --}}
                                            <div x-show="menuOpen" x-cloak 
                                                 class="absolute {{ $isMe ? 'right-0 mr-6' : 'left-0 ml-6' }} top-0 w-32 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-20">
                                                <button @click="menuOpen = false; $wire.startEdit({{ $message->id }})" class="w-full text-left px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                    Edit
                                                </button>
                                                <button @click="menuOpen = false" wire:click="deleteMessage({{ $message->id }})" wire:confirm="Hapus pesan ini?" class="w-full text-left px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="flex items-center gap-1 mt-1 px-1">
                                <span class="text-[10px] text-gray-400 font-medium">{{ $message->created_at->format('H:i') }}</span>
                                @if($message->is_edited)
                                    <span class="text-[9px] text-gray-400 font-medium italic">(diedit)</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="h-full flex flex-col items-center justify-center text-center p-8">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                    </div>
                    <h4 class="text-sm font-bold text-gray-900 mb-1">Mulai Obrolan</h4>
                    <p class="text-xs text-gray-500 font-medium max-w-sm">Kirim pesan pertama di grup untuk menyapa pengurus dan anggota divisi lainnya.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Input Area (hide when editing a message) --}}
    @if(!$editingMessageId)
    <div class="p-4 border-t border-gray-100 bg-white flex-shrink-0">
        <form wire:submit="sendMessage" class="flex items-end gap-3 max-w-5xl mx-auto">
            <div class="flex-1 bg-gray-50 border border-gray-200 rounded-2xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-100 focus-within:border-blue-400 transition-all">
                <textarea 
                    wire:model="messageInput" 
                    rows="1" 
                    placeholder="Ketik pesan ke grup..." 
                    class="w-full bg-transparent border-0 px-4 py-3 text-sm font-medium focus:ring-0 resize-none max-h-32"
                    oninput="this.style.height = ''; this.style.height = Math.min(this.scrollHeight, 120) + 'px'"
                    wire:keydown.enter.prevent="sendMessage"
                ></textarea>
            </div>
            <button type="submit" class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center flex-shrink-0 hover:bg-blue-700 transition-colors shadow-sm shadow-blue-200" {{ empty(trim($messageInput)) ? 'disabled' : '' }}>
                <svg class="w-5 h-5 translate-x-px -translate-y-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
        </form>
    </div>
    @endif

    {{-- Scroll to bottom script --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            const scrollToBottom = () => {
                const container = document.getElementById('chat-messages');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            };

            Livewire.hook('morph.updated', (el, component) => {
                scrollToBottom();
            });

            // Scroll initially
            setTimeout(scrollToBottom, 50);
        });
    </script>
</div>