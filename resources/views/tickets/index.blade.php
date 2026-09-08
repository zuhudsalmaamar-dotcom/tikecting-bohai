<x-app-layout>
    <!-- CSS Tambahan untuk menyembunyikan modal sebelum diklik -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-cyan-400 tracking-wide font-mono flex items-center gap-2">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                    DAFTAR TIKET IT HELPDESK
                </h2>
                <p class="text-xs text-slate-400 mt-1 font-mono">
                    Pengelolaan & Pengawasan Seluruh Laporan Masalah Sistem — 
                    <span class="text-cyan-400 uppercase font-bold">[{{ Auth::user()->role }}]</span>
                </p>
                
            </div>

            <!-- FITUR BUAT TIKET BARU (Hanya untuk Role 'user') -->
            @if(Auth::user()->role === 'user')
                <div x-data="{ openModal: false }">
                    <!-- Tombol Pemicu Modal -->
                    <button @click="openModal = true" type="button" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs uppercase tracking-wider rounded-lg shadow-lg shadow-cyan-500/20 transition flex items-center gap-2 font-mono">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Tiket Baru
                    </button>

                    <!-- TELEPORT KE BODY (Agar modal dilepas dari pembungkus header dan tidak terpotong) -->
                    <template x-teleport="body">
                        <div x-show="openModal" 
                             x-cloak 
                             class="fixed inset-0 z-[99999] overflow-y-auto bg-slate-950/80 backdrop-blur-md flex justify-center items-center p-4 font-mono"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                            
                            <!-- Box Modal Form -->
                            <div @click.away="openModal = false" class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-lg p-6 shadow-2xl relative text-slate-200 my-auto">
                                
                                <!-- Header Modal -->
                                <div class="flex justify-between items-center pb-4 border-b border-slate-800">
                                    <h3 class="font-bold text-lg text-cyan-400 font-mono">Form Pelaporan Kendala IT</h3>
                                    <button @click="openModal = false" type="button" class="text-slate-400 hover:text-white text-xl font-bold">&times;</button>
                                </div>

                                <!-- Body Form -->
                                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4 text-xs">
                                    @csrf

                                    <!-- Judul Tiket -->
                                    <div>
                                        <label class="block text-slate-400 mb-1">Judul Kendala / Subjek</label>
                                        <input type="text" name="title" required placeholder="Contoh: Lampu Proyektor Mati" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                                    </div>

                                    <!-- Kategori -->
                                    <div>
                                        <label class="block text-slate-400 mb-1">Kategori Perangkat / Layanan</label>
                                        <select name="category_id" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Prioritas -->
                                    <div>
                                        <label class="block text-slate-400 mb-1">Tingkat Prioritas</label>
                                        <select name="priority" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                                            <option value="low">Rendah (Low)</option>
                                            <option value="medium" selected>Sedang (Medium)</option>
                                            <option value="high">Tinggi (High / Urgent)</option>
                                        </select>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div>
                                        <label class="block text-slate-400 mb-1">Deskripsi Detail Masalah</label>
                                        <textarea name="description" rows="3" required placeholder="Jelaskan kendala secara rinci..." class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"></textarea>
                                    </div>

                                    <!-- Attachment Foto -->
                                    <div>
                                        <label class="block text-slate-400 mb-1">Lampiran Foto/Screenshot (Opsional)</label>
                                        <input type="file" name="attachment" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-1.5 text-slate-400 file:mr-4 file:py-1 file:px-2 file:rounded-md file:border-0 file:bg-slate-800 file:text-cyan-400 hover:file:bg-slate-700">
                                    </div>

                                    <!-- Footer Tombol -->
                                    <div class="pt-4 flex justify-end gap-2 border-t border-slate-800">
                                        <button type="button" @click="openModal = false" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-lg font-bold hover:bg-slate-700 transition">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-cyan-500 text-slate-950 font-bold rounded-lg hover:bg-cyan-400 transition">Kirim Tiket</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </template>
                </div>
            @endif
        </div>
    </x-slot>

    <!-- KONTEN UTAMA HALAMAN -->
    <div class="py-8 bg-slate-950 min-h-screen text-slate-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert Notifikasi -->
            @if(session('success'))
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl text-xs font-mono">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-500/10 border border-rose-500/30 text-rose-400 rounded-xl text-xs font-mono">
                    {{ session('error') }}
                </div>
            @endif

            <!-- FITUR FILTER & SEARCHING -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 shadow-xl">
                <form method="GET" action="{{ route('tickets.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 font-mono text-xs">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-slate-400 mb-1">Cari Tiket / Subjek</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-1.5 text-slate-200 focus:border-cyan-500">
                    </div>

                    <!-- Filter Status -->
                    <div>
                        <label class="block text-slate-400 mb-1">Filter Status</label>
                        <select name="status" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-1.5 text-slate-200 focus:border-cyan-500">
                            <option value="">Semua Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <!-- Filter Prioritas -->
                    <div>
                        <label class="block text-slate-400 mb-1">Filter Prioritas</label>
                        <select name="priority" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-1.5 text-slate-200 focus:border-cyan-500">
                            <option value="">Semua Prioritas</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <!-- Tombol Filter & Reset -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="w-full px-4 py-2 bg-slate-800 hover:bg-slate-700 text-cyan-400 font-bold uppercase tracking-wider rounded-lg border border-slate-700 transition">
                            Filter Data
                        </button>
                        <a href="{{ route('tickets.index') }}" class="px-3 py-2 bg-slate-950 hover:bg-slate-800 text-slate-400 rounded-lg border border-slate-800 transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- TABEL DAFTAR TIKET -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-mono text-slate-300">
                        <thead class="bg-slate-950 text-slate-400 uppercase border-b border-slate-800">
                            <tr>
                                <th class="p-3">ID</th>
                                <th class="p-3">Pelapor</th>
                                <th class="p-3">Subjek Kendala</th>
                                <th class="p-3">Kategori</th>
                                <th class="p-3">Prioritas</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Tanggal Buat</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-slate-800/50 transition">
                                    <td class="p-3 text-cyan-400 font-bold">#{{ $ticket->id }}</td>
                                    <td class="p-3">{{ $ticket->user->name ?? 'N/A' }}</td>
                                    <td class="p-3 font-semibold text-white">{{ $ticket->title }}</td>
                                    <td class="p-3">{{ $ticket->category->name ?? '-' }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                            {{ $ticket->priority === 'high' ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30' : '' }}
                                            {{ $ticket->priority === 'medium' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : '' }}
                                            {{ $ticket->priority === 'low' ? 'bg-slate-700 text-slate-300' : '' }}">
                                            {{ $ticket->priority }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                            {{ $ticket->status === 'open' ? 'bg-amber-500/20 text-amber-400' : '' }}
                                            {{ $ticket->status === 'in_progress' ? 'bg-cyan-500/20 text-cyan-400' : '' }}
                                            {{ $ticket->status === 'resolved' ? 'bg-emerald-500/20 text-emerald-400' : '' }}
                                            {{ $ticket->status === 'closed' ? 'bg-slate-700 text-slate-400' : '' }}">
                                            {{ str_replace('_', ' ', $ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-slate-500">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="p-3 text-center">
                                        <a href="{{ route('tickets.show', $ticket->id) }}" class="px-2.5 py-1 bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 hover:bg-cyan-500 hover:text-slate-950 rounded text-[11px] font-bold transition">
                                            Detail / Kelola
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-6 text-center text-slate-500 font-mono">
                                        Tidak ada data tiket yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                @if(method_exists($tickets, 'links'))
                    <div class="mt-4">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>