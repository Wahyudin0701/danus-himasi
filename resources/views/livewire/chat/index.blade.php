<div class="max-w-[1400px] mx-auto h-[calc(100vh-8rem)] min-h-[600px] flex overflow-hidden bg-white rounded-3xl shadow-sm border border-gray-100">
    
    {{-- Sidebar / Users List --}}
    <div class="w-full md:w-80 lg:w-96 flex flex-col border-r border-gray-100 {{ $activeChatUserId ? 'hidden md:flex' : 'flex' }}">
        
        {{-- Header Sidebar --}}
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex-shrink-0">
            <h2 class="text-xl font-black text-gray-900">Pesan</h2>
            <p class="text-xs text-gray-500 mt-1 font-medium">Obrolan internal divisi</p>
        </div>

        {{-- Search (Optional/Static for now) --}}
        <div class="p-4 border-b border-gray-100">
            <div class="relative">
                <input type="text" placeholder="Cari kontak..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>

        {{-- Users List (Polling for new messages/counts) --}}
        <div class="flex-1 overflow-y-auto" wire:poll.{{ $pollInterval }}ms>
            @if($users->isEmpty())
                <div class="p-6 text-center text-sm text-gray-500 font-medium">
                    Belum ada kontak.
                </div>
            @else
                @foreach($users as $user)
                    <button wire:click="selectUser({{ $user->id }})" class="w-full text-left p-4 flex items-start gap-4 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0 {{ $activeChatUserId === $user->id ? 'bg-blue-50/50 hover:bg-blue-50/80 relative before:absolute before:left-0 before:top-0 before:bottom-0 before:w-1 before:bg-blue-600' : '' }}">
                        
                        {{-- Avatar --}}
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg flex-shrink-0 border border-blue-200 overflow-hidden">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($user->name, 0, 1) }}
                                @endif
                            </div>
                            @if($user->unread_count > 0)
                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-[10px] font-bold text-white border-2 border-white shadow-sm">
                                    {{ $user->unread_count > 99 ? '99+' : $user->unread_count }}
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="text-sm font-bold text-gray-900 truncate pr-2 {{ $user->unread_count > 0 ? 'text-black' : '' }}">{{ $user->name }}</h3>
                                @if($user->last_message_at)
                                    <span class="text-[10px] text-gray-400 whitespace-nowrap {{ $user->unread_count > 0 ? 'font-bold text-blue-600' : '' }}">{{ \Carbon\Carbon::parse($user->last_message_at)->diffForHumans(null, true, true) }}</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-1">
                                @if($user->role === 'admin')
                                    <span class="px-1.5 py-0.5 bg-purple-100 text-purple-700 rounded text-[9px] font-bold tracking-wide">ADMIN</span>
                                @endif
                                <p class="text-xs truncate {{ $user->unread_count > 0 ? 'font-bold text-gray-800' : 'text-gray-500 font-medium' }}">
                                    {{ $user->last_message ?: 'Belum ada pesan' }}
                                </p>
                            </div>
                        </div>
                    </button>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Main Chat Area --}}
    <div class="flex-1 flex flex-col bg-gray-50/30 relative {{ !$activeChatUserId ? 'hidden md:flex' : 'flex' }}">
        
        @if($activeChatUserId)
            {{-- Chat Header --}}
            <div class="px-6 py-4 border-b border-gray-100 bg-white flex items-center gap-4 flex-shrink-0">
                <button wire:click="$set('activeChatUserId', null)" class="md:hidden p-2 -ml-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>

                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm border border-blue-200 overflow-hidden">
                    @if($this->activeUser->photo)
                        <img src="{{ asset('storage/' . $this->activeUser->photo) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($this->activeUser->name, 0, 1) }}
                    @endif
                </div>
                
                <div>
                    <h3 class="text-sm font-bold text-gray-900">{{ $this->activeUser->name }}</h3>
                    <p class="text-[11px] font-medium text-gray-500">{{ strtoupper($this->activeUser->role) }}</p>
                </div>
            </div>

            {{-- Messages Area --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-4" id="chat-messages" wire:poll.{{ $pollInterval }}ms>
                @forelse($messages as $message)
                    @php
                        $isMe = $message->sender_id === auth()->id();
                    @endphp
                    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] md:max-w-[60%] flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                            <div class="px-4 py-2.5 rounded-2xl text-sm font-medium shadow-sm {{ $isMe ? 'bg-blue-600 text-white rounded-br-sm' : 'bg-white border border-gray-100 text-gray-800 rounded-bl-sm' }}">
                                {{ $message->body }}
                            </div>
                            <div class="flex items-center gap-1 mt-1 px-1">
                                <span class="text-[10px] text-gray-400 font-medium">{{ $message->created_at->format('H:i') }}</span>
                                @if($isMe)
                                    @if($message->is_read)
                                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7 M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-center p-8">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h4 class="text-sm font-bold text-gray-900 mb-1">Mulai Obrolan</h4>
                        <p class="text-xs text-gray-500 font-medium">Kirim pesan pertama ke {{ $this->activeUser->name }}.</p>
                    </div>
                @endforelse
            </div>

            {{-- Input Area --}}
            <div class="p-4 border-t border-gray-100 bg-white flex-shrink-0">
                <form wire:submit="sendMessage" class="flex items-end gap-3">
                    <div class="flex-1 bg-gray-50 border border-gray-200 rounded-2xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-100 focus-within:border-blue-400 transition-all">
                        <textarea 
                            wire:model="messageInput" 
                            rows="1" 
                            placeholder="Ketik pesan..." 
                            class="w-full bg-transparent border-0 px-4 py-3 text-sm font-medium focus:ring-0 resize-none max-h-32"
                            oninput="this.style.height = ''; this.style.height = Math.min(this.scrollHeight, 120) + 'px'"
                            wire:keydown.enter.prevent="sendMessage"
                        ></textarea>
                    </div>
                    <button type="submit" class="w-11 h-11 bg-blue-600 text-white rounded-xl flex items-center justify-center flex-shrink-0 hover:bg-blue-700 transition-colors shadow-sm shadow-blue-200" {{ empty(trim($messageInput)) ? 'disabled' : '' }}>
                        <svg class="w-5 h-5 translate-x-px -translate-y-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </form>
            </div>

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
        @else
            {{-- Empty State (No chat selected) --}}
            <div class="flex-1 flex flex-col items-center justify-center text-center p-8 bg-white/50">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-5 border border-blue-100">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                </div>
                <h3 class="text-lg font-black text-gray-900 mb-2">Pesan Internal</h3>
                <p class="text-sm font-medium text-gray-500 max-w-sm">Pilih kontak di sebelah kiri untuk mulai mengobrol dengan pengurus atau anggota divisi lainnya.</p>
            </div>
        @endif

    </div>
</div>
