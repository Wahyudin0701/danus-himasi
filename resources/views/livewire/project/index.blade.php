<div class="w-full">
    
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Program Kerja Divisi <span class="text-blue-600">DANA DAN USAHA</span></h1>
            <p class="text-sm font-medium text-gray-500 mt-1">{{ in_array(auth()->user()->role, ['kadiv', 'wakadiv']) ? 'Kelola seluruh program kerja divisi Anda pada periode ini.' : 'Daftar program kerja divisi Anda pada periode ini.' }}</p>
        </div>
        {{-- Only Pimpinan Divisi and above can add projects. But let's say kadiv & wakadiv --}}
        @if(in_array(auth()->user()->role, ['kadiv', 'wakadiv']))
        <a href="{{ route('projects.create') }}" wire:navigate
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Proker
        </a>
        @endif
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-2 mb-5">
        <button wire:click="$set('filter', 'all')"
            class="px-4 py-2 text-sm font-bold rounded-xl transition-colors {{ $filter === 'all' ? 'bg-blue-600 text-white shadow-sm shadow-blue-200' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            Semua Proker
        </button>
        <button wire:click="$set('filter', 'mine')"
            class="px-4 py-2 text-sm font-bold rounded-xl transition-colors {{ $filter === 'mine' ? 'bg-blue-600 text-white shadow-sm shadow-blue-200' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            Proker Saya
        </button>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 whitespace-nowrap">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-[11px] uppercase font-bold text-gray-500 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4 w-1/3">Nama Program Kerja</th>
                        <th scope="col" class="px-6 py-4 text-center">Tanggal Pelaksanaan</th>
                        <th scope="col" class="px-6 py-4 text-center">Jenis Program</th>
                        <th scope="col" class="px-6 py-4 text-center">PJ</th>
                        <th scope="col" class="px-6 py-4 text-center">Status</th>
                        <th scope="col" class="px-6 py-4 text-center">Keuntungan</th>
                        <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($projects as $project)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        {{-- Nama Proker --}}
                        <td class="px-6 py-5 font-bold text-gray-900 whitespace-normal">
                            {{ $project->name }}
                        </td>
                        
                        {{-- Tanggal Pelaksanaan --}}
                        <td class="px-6 py-5 text-center">
                            @if($project->start_date)
                                {{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }} 
                                @if($project->end_date)
                                    - {{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}
                                @endif
                            @else
                                <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        
                        {{-- Jenis Program --}}
                        <td class="px-6 py-5 text-center font-medium">
                            {{ str_replace('_', ' ', ucwords($project->category, '_')) }}
                        </td>
                        
                        {{-- PJ / Ketupel --}}
                        <td class="px-6 py-5 text-center">
                            @php
                                $pj = $project->members->where('is_pic', true)->first();
                            @endphp
                            @if($pj)
                                {{ explode(' ', $pj->user->name)[0] }}
                            @else
                                <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        
                        {{-- Status Badge --}}
                        <td class="px-6 py-5 text-center">
                            <span class="text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider
                                {{ $project->status === 'active' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $project->status === 'draft' ? 'bg-blue-50 text-blue-600' : '' }}
                                {{ $project->status === 'completed' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                {{ $project->status === 'archived' ? 'bg-gray-100 text-gray-600' : '' }}">
                                {{ $project->status === 'draft' ? 'PLANNING' : $project->status }}
                            </span>
                        </td>
                        
                        {{-- Keuntungan --}}
                        <td class="px-6 py-5 text-center">
                            @php
                                $modal = $project->modal ?? 0;
                                $pendapatan = $project->pendapatan ?? 0;
                                $keuntungan = $pendapatan - $modal;
                            @endphp
                            @if($keuntungan > 0)
                                <span class="text-green-600 font-bold">+Rp {{ number_format($keuntungan, 0, ',', '.') }}</span>
                            @elseif($keuntungan < 0)
                                <span class="text-red-600 font-bold">-Rp {{ number_format(abs($keuntungan), 0, ',', '.') }}</span>
                            @else
                                <span class="text-gray-400 font-bold">Rp 0</span>
                            @endif
                        </td>
                        
                        {{-- Aksi Buttons --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('projects.show', $project->id) }}" wire:navigate class="px-3 py-1.5 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-lg text-xs font-bold transition-colors">Detail</a>
                                @if(in_array(auth()->user()->role, ['kadiv', 'wakadiv']))
                                <a href="{{ route('projects.edit', $project->id) }}" wire:navigate class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-xs font-bold transition-colors">Edit</a>
                                <button class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold transition-colors">Batalkan</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-medium">
                            Belum ada program kerja yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-50/80 border-t border-gray-100 font-black text-gray-900">
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-right text-xs uppercase tracking-wider text-gray-500">Total Keuntungan Keseluruhan</td>
                        <td class="px-6 py-4 text-center text-base">
                            
                            @if($totalKeuntungan > 0)
                                <span class="text-green-600">+Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</span>
                            @elseif($totalKeuntungan < 0)
                                <span class="text-red-600">-Rp {{ number_format(abs($totalKeuntungan), 0, ',', '.') }}</span>
                            @else
                                <span class="text-gray-400">Rp 0</span>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
