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

    {{-- Calendar Container --}}
    <div class="bg-white rounded-3xl p-4 md:p-6 shadow-sm border border-gray-100" wire:ignore>
        <div id="calendar" class="min-h-[600px]"></div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
    document.addEventListener('livewire:navigated', function () {
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
                        // Navigate using Livewire if possible, or standard link
                        Livewire.navigate(info.event.url);
                    }
                },
                height: 'auto',
                themeSystem: 'standard'
            });
            calendar.render();
        }
    });
</script>
<style>
    /* Tailwind UI Adjustments for FullCalendar */
    .fc { font-family: inherit; }
    .fc-theme-standard .fc-scrollgrid { border-color: #f3f4f6; border-radius: 0.75rem; overflow: hidden; }
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f3f4f6; }
    .fc .fc-toolbar-title { font-size: 1.25rem; font-weight: 900; color: #111827; }
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
        
        .fc .fc-toolbar-title { font-size: 1.125rem !important; text-align: center; }
        .fc .fc-button { padding: 0.25rem 0.5rem !important; font-size: 0.75rem !important; }
        .fc-daygrid-event { font-size: 0.65rem; padding: 0.1rem 0.2rem; }
    }
</style>
@endpush