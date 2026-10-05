<div class="max-w-[1400px] mx-auto w-full">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-xl md:text-2xl font-black text-gray-900">Kalender Divisi <span class="text-blue-600">DANA DAN USAHA</span></h1>
            <p class="text-xs md:text-sm font-medium text-gray-500 mt-1">Jadwal pelaksanaan program kerja divisi dalam tampilan kalender.</p>
        </div>
        
        <div class="flex items-center gap-4 text-xs font-bold text-gray-500">
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-slate-500"></div> Planning</div>
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-green-500"></div> Active</div>
            <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-indigo-500"></div> Completed</div>
        </div>
    </div>

        {{-- Month/Year Picker Modal --}}
    <div x-data="{ 
            show: false, 
            month: new Date().getMonth() + 1, 
            year: new Date().getFullYear(),
            apply() {
                let m = this.month.toString().padStart(2, '0');
                let y = this.year;
                window.dispatchEvent(new CustomEvent('calendar-goto', { detail: { date: y + '-' + m + '-01' } }));
                this.show = false;
            }
        }" 
        @open-calendar-picker.window="show = true; month = $event.detail.month; year = $event.detail.year;"
        x-cloak 
        x-show="show" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm"
        x-transition.opacity>
        
        <div @click.away="show = false" class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden" x-transition.scale.origin.bottom>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-black text-gray-900">Pilih Bulan & Tahun</h3>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Bulan</label>
                    <select x-model="month" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Tahun</label>
                    <select x-model="year" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @for($i = date('Y') - 2; $i <= date('Y') + 3; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-2">
                <button @click="show = false" class="px-4 py-2 text-sm font-bold text-gray-600 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                <button @click="apply()" class="px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm shadow-blue-200">Terapkan</button>
            </div>
        </div>
    </div>

    {{-- Calendar Container --}}
    <div class="bg-white rounded-3xl p-4 md:p-6 shadow-sm border border-gray-100" wire:ignore>
        <div id="calendar" class="min-h-[600px]"></div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js" data-navigate-once></script>
<script>
    (function() {
        function initCalendar() {
            if (typeof FullCalendar === 'undefined') {
                setTimeout(initCalendar, 50);
                return;
            }
            
            var calendarEl = document.getElementById('calendar');
            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,listMonth'
                    },
                    buttonText: {
                        today: 'Hari Ini',
                        month: 'Bulan',
                        list: 'Agenda'
                    },
                    events: @json($events),
                    displayEventTime: false,
                    eventClick: function(info) {
                        if (info.event.url) {
                            info.jsEvent.preventDefault();
                            Livewire.navigate(info.event.url);
                        }
                    },
                    height: 'auto',
                    themeSystem: 'standard'
                });
                calendar.render();
                window.fullCalendarInstance = calendar;
            }
        }
        
        // Execute immediately upon injection
        initCalendar();

        // Register global events only once
        if (!window.calendarEventsRegistered) {
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('fc-toolbar-title') && window.fullCalendarInstance) {
                    var currentDate = window.fullCalendarInstance.getDate();
                    window.dispatchEvent(new CustomEvent('open-calendar-picker', { 
                        detail: { 
                            month: currentDate.getMonth() + 1, 
                            year: currentDate.getFullYear() 
                        } 
                    }));
                }
            });

            window.addEventListener('calendar-goto', function(e) {
                if (window.fullCalendarInstance) {
                    window.fullCalendarInstance.gotoDate(e.detail.date);
                }
            });
            window.calendarEventsRegistered = true;
        }
    })();
</script>
<style>
    /* Tailwind UI Adjustments for FullCalendar */
    .fc { font-family: inherit; }
    .fc-theme-standard .fc-scrollgrid { border-color: #f3f4f6; border-radius: 0.75rem; overflow: hidden; }
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f3f4f6; }
    .fc .fc-toolbar-title { font-size: 1.25rem; font-weight: 900; color: #111827; cursor: pointer; transition: color 0.2s; }
    .fc .fc-toolbar-title:hover { color: #2563eb; }
    .fc .fc-button-primary { background-color: #2563eb; border-color: #2563eb; font-weight: 700; text-transform: capitalize; border-radius: 0.5rem; }
    .fc .fc-button-primary:not(:disabled):active, .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #1d4ed8; border-color: #1d4ed8; }
    .fc .fc-button-primary:hover { background-color: #1d4ed8; }
    .fc .fc-button-primary:focus { box-shadow: none !important; outline: none !important; }
    .fc .fc-button:focus { box-shadow: none !important; outline: none !important; }
    .fc-daygrid-event { border-radius: 0.375rem; padding: 0.125rem 0.25rem; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: transform 0.15s ease; }
    .fc-daygrid-event:hover { transform: scale(1.02); opacity: 0.9; }
    .fc .fc-daygrid-day.fc-day-today { background-color: #eff6ff; }
    
    /* Mobile Responsive Adjustments */
    @media (max-width: 640px) {
        .fc .fc-toolbar { flex-direction: row !important; flex-wrap: wrap !important; gap: 0.5rem; justify-content: space-between !important; align-items: center !important; }
        .fc .fc-toolbar-chunk { display: flex; align-items: center; justify-content: center; gap: 0.25rem; }
        
        /* 1: Title full width on top */
        .fc .fc-toolbar-chunk:nth-child(2) { order: 1; width: 100%; margin-bottom: 0.25rem; }
        /* 2: Nav buttons on left */
        .fc .fc-toolbar-chunk:nth-child(1) { order: 2; }
        /* 3: View buttons on right */
        .fc .fc-toolbar-chunk:nth-child(3) { order: 3; }
        
        .fc .fc-toolbar-title { font-size: 1.125rem !important; text-align: center; cursor: pointer; transition: color 0.2s; }
        .fc .fc-toolbar-title:hover { color: #2563eb !important; }
        .fc .fc-button { padding: 0.25rem 0.5rem !important; font-size: 0.75rem !important; }
        .fc-daygrid-event { font-size: 0.65rem; padding: 0.1rem 0.2rem; }
    }
</style></div>
