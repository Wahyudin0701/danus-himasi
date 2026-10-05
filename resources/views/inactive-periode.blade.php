<x-guest-layout>
    <div class="text-center">
        <!-- Top accent line attached to the parent card -->
        <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>
        
        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 mt-2">
            <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        
        @php
            $userPeriode = auth()->user()->periode;
            $userPeriodeName = $userPeriode ? $userPeriode->name : 'Tidak Terdaftar';
            
            $activePeriode = \App\Models\Periode::active();
            $activePeriodeName = $activePeriode ? $activePeriode->name : 'Belum Ada Periode Aktif';
        @endphp

        <h1 class="text-2xl font-black text-gray-900 mb-3">Akses Dibatasi</h1>
        
        <p class="text-sm font-medium text-gray-500 leading-relaxed mb-4">
            Maaf, Anda tidak dapat mengakses sistem karena periode kepengurusan Anda (<strong class="text-gray-900">{{ $userPeriodeName }}</strong>) saat ini sedang <strong class="text-gray-900">tidak aktif</strong> atau sudah berakhir.
        </p>

        <p class="text-sm font-medium text-gray-500 leading-relaxed mb-8">
            Saat ini, sistem hanya membuka akses untuk anggota pengurus aktif dari periode <strong class="text-blue-600 font-bold bg-blue-50 px-1.5 py-0.5 rounded">{{ $activePeriodeName }}</strong>.
            Silakan hubungi Administrator jika terjadi kesalahan data.
        </p>
        
        <div class="flex justify-center">
            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="w-full flex justify-center py-3.5 px-4 rounded-xl text-sm font-bold text-white bg-red-600 hover:bg-red-700 shadow-lg shadow-red-200 transition-all focus:outline-none focus:ring-4 focus:ring-red-100">
                Keluar Sistem
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</x-guest-layout>
