<div class="w-full h-[calc(100vh-8rem)] min-h-[600px] flex flex-col bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    
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
                @endphp
                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                    <div class="flex gap-3 max-w-[85%] md:max-w-[70%] {{ $isMe ? 'flex-row-reverse' : 'flex-row' }}">
                        
                        {{-- Avatar --}}
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs border border-blue-200 overflow-hidden shrink-0 mt-1">
                            @if($message->sender && $message->sender->photo)
                                <img src="{{ asset('storage/' . $message->sender->photo) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($message->sender->name ?? '?', 0, 1) }}
                            @endif
                        </div>

                        {{-- Bubble --}}
                        <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                            <span class="text-[11px] font-bold text-gray-600 mb-1 {{ $isMe ? 'mr-1' : 'ml-1' }}">
                                {{ $isMe ? 'Anda' : ($message->sender->name ?? 'User') }}
                            </span>
                            
                            <div class="px-4 py-2.5 rounded-2xl text-sm font-medium shadow-sm {{ $isMe ? 'bg-blue-600 text-white rounded-tr-sm' : 'bg-white border border-gray-100 text-gray-800 rounded-tl-sm' }}">
                                {{ $message->body }}
                            </div>
                            
                            <div class="flex items-center gap-1 mt-1 px-1">
                                <span class="text-[10px] text-gray-400 font-medium">{{ $message->created_at->format('H:i') }}</span>
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

    {{-- Input Area --}}
    <div class="p-4 border-t border-gray-100 bg-white flex-shrink-0">
        <form wire:submit="sendMessage" class="flex items-end gap-3 max-w-4xl mx-auto">
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