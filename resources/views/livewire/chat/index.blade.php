<div class="w-full h-[calc(100vh-8rem)] min-h-[600px] flex flex-col bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    
    {{-- Chat Header --}}
    <div class="px-6 py-4 border-b border-gray-100 bg-white flex items-center gap-4 flex-shrink-0 z-10 shadow-sm">
        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg border border-blue-200 overflow-hidden shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
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
                    $canModify = $isMe && !$message->trashed() && $message->created_at->diffInMinutes(now()) <= 15;
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
                                    <div class="px-4 py-2.5 rounded-2xl text-sm font-medium shadow-sm {{ $message->trashed() ? 'bg-gray-100/80 text-gray-400 border border-gray-200 italic' : ($isMe ? 'bg-blue-600 text-white rounded-tr-sm' : 'bg-white border border-gray-100 text-gray-800 rounded-tl-sm') }}" style="word-break: break-word;">
                                        
                                        {{-- Reply preview --}}
                                        @if($message->replyTo)
                                            <div class="mb-2 p-2 bg-black/10 rounded-lg border-l-4 {{ $isMe ? 'border-blue-300' : 'border-gray-400' }} text-xs" style="word-break: break-word;">
                                                <span class="font-bold {{ $isMe ? 'text-blue-100' : 'text-gray-700' }} block mb-0.5">
                                                    {{ $message->replyTo->sender_id === auth()->id() ? 'Anda' : ($message->replyTo->sender->name ?? 'User') }}
                                                </span>
                                                <span class="{{ $isMe ? 'text-blue-50' : 'text-gray-500' }} line-clamp-2">
                                                    @if($message->replyTo->trashed())
                                                        <em>Pesan ini telah dihapus</em>
                                                    @else
                                                        @php
                                                            $rbody = e($message->replyTo->body);
                                                            foreach($users as $u) {
                                                                $rbody = str_replace('@' . e($u->name), '<strong>@' . e($u->name) . '</strong>', $rbody);
                                                            }
                                                        @endphp
                                                        {!! $rbody !!}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif

                                        {{-- Message body --}}
                                        @if($message->trashed())
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                Pesan ini telah dihapus
                                            </span>
                                        @else
                                            @php
                                                $body = e($message->body);
                                                $mentionColor = $isMe ? 'color:#bfdbfe;' : 'color:#2563eb;';
                                                foreach($users as $u) {
                                                    $body = str_replace('@' . e($u->name), '<span style="font-weight:700;' . $mentionColor . '">@' . e($u->name) . '</span>', $body);
                                                }
                                            @endphp
                                            {!! $body !!}
                                        @endif
                                    </div>
                                    
                                    {{-- 3-dot actions menu --}}
                                    @if(!$message->trashed())
                                        <div class="relative flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity" @click.outside="menuOpen = false">
                                            <button @click="menuOpen = !menuOpen" class="p-1.5 text-gray-400 hover:bg-gray-200 hover:text-gray-700 rounded-full transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                                            </button>
                                            <div x-show="menuOpen" x-cloak
                                                 x-transition
                                                 class="absolute {{ $isMe ? 'right-7' : 'left-7' }} top-0 w-36 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-30">
                                                {{-- Reply --}}
                                                <button @click="menuOpen = false; $wire.startReply({{ $message->id }})" class="w-full text-left px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                                    Balas
                                                </button>
                                                @if($canModify)
                                                    {{-- Edit --}}
                                                    <button @click="menuOpen = false; $wire.startEdit({{ $message->id }})" class="w-full text-left px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                        Edit
                                                    </button>
                                                    {{-- Delete --}}
                                                    <button @click="menuOpen = false" wire:click="deleteMessage({{ $message->id }})" wire:confirm="Hapus pesan ini?" class="w-full text-left px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 flex items-center gap-2 border-t border-gray-100 mt-1 pt-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                        Hapus
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="flex items-center gap-1 mt-1 px-1">
                                <span class="text-[10px] text-gray-400 font-medium">{{ $message->created_at->format('H:i') }}</span>
                                @if($message->is_edited && !$message->trashed())
                                    <span class="text-[9px] text-gray-400 font-medium italic">(diedit)</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="h-64 flex flex-col items-center justify-center text-center p-8">
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
    @if(!$editingMessageId)
    <div class="border-t border-gray-100 bg-white flex-shrink-0">

        {{-- Reply Preview --}}
        @if($replyingToMessageId && $this->replyingToMessage)
            <div class="mx-4 mt-3 relative bg-blue-50 border-l-4 border-blue-500 rounded-lg p-3 pr-10 flex items-start gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-blue-600 mb-0.5">
                        Membalas {{ $this->replyingToMessage->sender_id === auth()->id() ? 'Anda' : ($this->replyingToMessage->sender->name ?? 'User') }}
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        @if($this->replyingToMessage->trashed())
                            Pesan ini telah dihapus
                        @else
                            {{ $this->replyingToMessage->body }}
                        @endif
                    </p>
                </div>
                <button wire:click="cancelReply" class="absolute right-2 top-2 p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-full transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        {{-- Input & Mention Dropdown --}}
        <div class="p-4" x-data="{
            allUsers: @json($users->values()),
            showMentions: false,
            mentionQuery: '',
            mentionStart: -1,

            get filteredUsers() {
                if (this.mentionQuery === '') return this.allUsers;
                return this.allUsers.filter(u => u.name.toLowerCase().includes(this.mentionQuery.toLowerCase()));
            },

            handleInput(e) {
                const ta = e.target;
                const val = ta.value;
                const pos = ta.selectionStart;
                const textBefore = val.substring(0, pos);

                // Find the last @ that is at start or after space/newline
                const match = textBefore.match(/(^|[\s\n])@([^\s@]*)$/);
                if (match) {
                    this.mentionQuery = match[2];
                    this.mentionStart = pos - match[2].length - 1; // position of @
                    this.showMentions = true;
                } else {
                    this.showMentions = false;
                    this.mentionQuery = '';
                    this.mentionStart = -1;
                }
            },

            selectUser(name) {
                const ta = this.\$refs.input;
                const val = ta.value;
                const before = val.substring(0, this.mentionStart);
                const after = val.substring(ta.selectionStart);
                const newVal = before + '@' + name + ' ' + after;
                ta.value = newVal;
                ta.dispatchEvent(new Event('input'));
                // Sync to Livewire
                @this.set('messageInput', newVal);
                this.showMentions = false;
                this.\$nextTick(() => ta.focus());
            }
        }" @click.outside="showMentions = false" class="relative">

            {{-- Mention dropdown --}}
            <div x-show="showMentions && filteredUsers.length > 0"
                 x-cloak
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute bottom-full left-0 right-0 mb-2 mx-0 bg-white border border-gray-200 rounded-xl shadow-2xl z-50 overflow-hidden max-h-52 overflow-y-auto">
                
                <div class="px-3 py-2 border-b border-gray-100 bg-gray-50">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Tag Anggota</span>
                </div>
                
                <template x-for="user in filteredUsers" :key="user.id">
                    <button type="button"
                        @click="selectUser(user.name)"
                        @mousedown.prevent
                        class="w-full text-left px-4 py-2.5 hover:bg-blue-50 flex items-center gap-3 transition-colors border-b border-gray-50 last:border-0">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-600 border border-blue-200 flex-shrink-0" x-text="user.name.charAt(0)"></div>
                        <span class="text-sm font-bold text-gray-800" x-text="user.name"></span>
                    </button>
                </template>
            </div>

            <form wire:submit="sendMessage" class="flex items-end gap-3">
                <div class="flex-1 bg-gray-50 border border-gray-200 rounded-2xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-100 focus-within:border-blue-400 transition-all">
                    <textarea
                        x-ref="input"
                        wire:model="messageInput"
                        @input="handleInput($event)"
                        rows="1"
                        placeholder="Ketik pesan... gunakan @ untuk tag anggota"
                        class="w-full bg-transparent border-0 px-4 py-3 text-sm font-medium focus:ring-0 resize-none max-h-32 rounded-2xl"
                        oninput="this.style.height = ''; this.style.height = Math.min(this.scrollHeight, 120) + 'px'"
                        wire:keydown.enter.prevent="sendMessage"
                    ></textarea>
                </div>
                <button type="submit" class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center flex-shrink-0 hover:bg-blue-700 active:scale-95 transition-all shadow-sm shadow-blue-200">
                    <svg class="w-5 h-5 translate-x-px -translate-y-px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </form>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mentionHandler', () => ({
                allUsers: @json($users->values()),
                showMentions: false,
                mentionQuery: '',
                mentionStart: -1,

                get filteredUsers() {
                    if (this.mentionQuery === '') return this.allUsers;
                    return this.allUsers.filter(u => u.name.toLowerCase().includes(this.mentionQuery.toLowerCase()));
                },

                handleInput(e) {
                    const ta = e.target;
                    const val = ta.value;
                    const pos = ta.selectionStart;
                    const textBefore = val.substring(0, pos);

                    const match = textBefore.match(/(^|[\s
])@([^\s@]*)$/);
                    if (match) {
                        this.mentionQuery = match[2];
                        this.mentionStart = pos - match[2].length - 1; 
                        this.showMentions = true;
                    } else {
                        this.showMentions = false;
                        this.mentionQuery = '';
                        this.mentionStart = -1;
                    }
                },

                selectUser(name) {
                    const ta = this.$refs.input;
                    const val = ta.value;
                    const before = val.substring(0, this.mentionStart);
                    const after = val.substring(ta.selectionStart);
                    const newVal = before + '@' + name + ' ' + after;
                    ta.value = newVal;
                    ta.dispatchEvent(new Event('input'));
                    this.$wire.set('messageInput', newVal);
                    this.showMentions = false;
                    this.$nextTick(() => ta.focus());
                }
            }));
        });

        document.addEventListener('livewire:initialized', () => {
            const scrollToBottom = () => {
                const container = document.getElementById('chat-messages');
                if (container) container.scrollTop = container.scrollHeight;
            };
            Livewire.hook('morph.updated', () => scrollToBottom());
            setTimeout(scrollToBottom, 100);
        });
    </script>
</div>