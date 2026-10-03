<div class="text-center">
    <div class="mx-auto w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center mb-6">
        <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    </div>
    
    <h2 class="text-2xl font-black text-gray-900 mb-2">Akses Dibatasi</h2>
    
    <p class="text-sm text-gray-500 font-medium mb-6">
        Maaf, akun Anda terdaftar pada periode <span class="font-bold text-gray-900">{{ $userPeriode ? $userPeriode->name : 'Tidak Diketahui' }}</span>. Saat ini, sistem sedang aktif pada periode kepengurusan <span class="font-bold text-blue-600">{{ $activePeriode ? $activePeriode->name : 'Belum Ada' }}</span>.
    </p>

    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-8 text-left text-sm text-blue-800 font-medium leading-relaxed">
        <p>Sistem ini dirancang untuk memisahkan data setiap periode secara independen.</p>
        <p class="mt-2">Jika Anda merupakan pengurus di periode aktif saat ini, mohon hubungi Administrator untuk mendaftarkan akun baru Anda di periode ini.</p>
    </div>

    <button wire:click="logout" class="w-full inline-flex justify-center items-center px-4 py-3.5 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md shadow-blue-200">
        Kembali ke Halaman Login
    </button>
</div>
