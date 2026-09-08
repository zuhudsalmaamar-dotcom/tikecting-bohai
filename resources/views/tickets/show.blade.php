<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-cyan-400 font-mono tracking-wide">
                DETAIL TIKET #{{ $ticket->id }}
            </h2>
            <a href="{{ route('tickets.index') }}" class="text-xs font-mono text-slate-400 hover:text-cyan-400 transition">
                &larr; Kembali ke Daftar Tiket
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-950 min-h-screen text-slate-200">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- NOTIFIKASI SUKSES / ERROR -->
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

            <!-- INFORMASI UTAMA TIKET -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-slate-800 pb-4 gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-white font-mono">{{ $ticket->title }}</h3>
                        <p class="text-xs text-slate-400 mt-1 font-mono">
                            Pelapor: <span class="text-cyan-400 font-bold">{{ $ticket->user->name ?? 'Anonim' }}</span> | 
                            Kategori: <span class="text-amber-400 font-bold">{{ $ticket->category->name ?? 'Umum' }}</span> | 
                            Dibuat: {{ $ticket->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold font-mono uppercase border
                            {{ $ticket->status === 'open' ? 'bg-amber-500/10 text-amber-400 border-amber-500/30' : '' }}
                            {{ $ticket->status === 'in_progress' ? 'bg-cyan-500/10 text-cyan-400 border-cyan-500/30' : '' }}
                            {{ $ticket->status === 'resolved' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30' : '' }}
                            {{ $ticket->status === 'closed' ? 'bg-slate-800 text-slate-400 border-slate-700' : '' }}">
                            {{ str_replace('_', ' ', $ticket->status) }}
                        </span>
                    </div>
                </div>

                <!-- DESKRIPSI -->
                <div class="text-xs font-mono text-slate-300">
                    <p class="text-slate-500 mb-1 uppercase tracking-wider font-bold">Deskripsi Masalah:</p>
                    <div class="bg-slate-950 p-4 rounded-xl border border-slate-800 text-slate-300 whitespace-pre-line">
                        {{ $ticket->description }}
                    </div>
                </div>

                <!-- LAMPIRAN (JIKA ADA) -->
                @if($ticket->attachment)
                    <div class="text-xs font-mono pt-2">
                        <p class="text-slate-500 mb-1 uppercase tracking-wider font-bold">Lampiran Gambar:</p>
                        <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="inline-block border border-slate-800 rounded-xl overflow-hidden hover:opacity-80 transition">
                            <img src="{{ asset('storage/' . $ticket->attachment) }}" alt="Lampiran Tiket" class="max-h-48 object-cover">
                        </a>
                    </div>
                @endif

                <!-- INFO TEKNISI PENANGGUNG JAWAB & CATATAN -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-mono pt-2 border-t border-slate-800/60">
                    <div>
                        <p class="text-slate-500 uppercase tracking-wider font-bold">Teknisi Penanggung Jawab:</p>
                        <p class="text-cyan-400 font-bold mt-1 text-sm">
                            {{ $ticket->technician_name ?? $ticket->technician->name ?? 'Belum Ditugaskan' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-500 uppercase tracking-wider font-bold">Catatan Pengerjaan:</p>
                        <p class="text-slate-300 mt-1 italic">
                            {{ $ticket->notes ?? 'Belum ada catatan pengerjaan.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- FORM UPDATE STATUS & PENUGASAN TEKNISI (HANYA ADMIN & TEKNISI) -->
            @if(in_array(Auth::user()->role, ['admin', 'technician', 'teknisi']))
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4">
                    <h3 class="text-sm font-bold text-cyan-400 font-mono uppercase tracking-wider">
                        Update Penugasan & Status Tiket
                    </h3>

                    <!-- Menggunakan route 'tickets.updateStatus' & method PATCH -->
                    <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST" class="space-y-4 font-mono text-xs">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- 1. PENUGASAN TEKNISI -->
                            <div class="space-y-2">
                                <label class="block text-slate-400 font-semibold">Teknisi Penanggung Jawab</label>
                                
                                <!-- Pilihan Dropdown dari DB User Teknisi -->
                                @if(isset($technicians) && $technicians->count() > 0)
                                    <select name="technician_id" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                                        <option value="">-- Pilih dari akun Teknisi DB --</option>
                                        @foreach($technicians as $tech)
                                            <option value="{{ $tech->id }}" {{ $ticket->technician_id == $tech->id ? 'selected' : '' }}>
                                                {{ $tech->name }} ({{ ucfirst($tech->role) }})
                                            </option>
                                        @endforeach
                                    </select>
                                @endif

                                <!-- Tulis Nama Manual jika tidak ada di akun DB -->
                                <input type="text" 
                                       name="technician_name" 
                                       value="{{ old('technician_name', $ticket->technician_name) }}" 
                                       placeholder="Atau ketik nama teknisi manual..." 
                                       class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 placeholder-slate-600">
                                <p class="text-[10px] text-slate-500">*Ketik nama manual jika teknisi tidak memiliki akun sistem.</p>
                            </div>

                            <!-- 2. STATUS TIKET -->
                            <div>
                                <label class="block text-slate-400 font-semibold mb-2">Status Tiket</label>
                                <select name="status" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                        </div>

                        <!-- 3. CATATAN PENGERJAAN -->
                        <div>
                            <label class="block text-slate-400 font-semibold mb-1">Catatan Pengerjaan / Tindakan Teknisi</label>
                            <textarea name="notes" rows="3" placeholder="Tuliskan tindakan perbaikan atau catatan penting di sini..." class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 placeholder-slate-600">{{ old('notes', $ticket->notes) }}</textarea>
                        </div>

                        <!-- TOMBOL SUBMIT -->
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="px-5 py-2.5 bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold uppercase rounded-lg transition shadow-lg shadow-cyan-500/10">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- SEKSI KOMENTAR TIKET -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl space-y-4 font-mono text-xs">
                <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider border-b border-slate-800 pb-3">
                    Diskusi / Komentar Tiket
                </h3>

                <!-- DAFTAR KOMENTAR -->
                <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                    @forelse($ticket->comments as $comment)
                        <div class="p-3 rounded-xl border border-slate-800/80 {{ $comment->user_id === Auth::id() ? 'bg-cyan-950/20 border-cyan-800/40 ml-6' : 'bg-slate-950 mr-6' }}">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-cyan-400">{{ $comment->user->name ?? 'User' }}</span>
                                <span class="text-[10px] text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-slate-300">{{ $comment->comment }}</p>
                        </div>
                    @empty
                        <p class="text-slate-500 text-center py-4">Belum ada komentar pada tiket ini.</p>
                    @endforelse
                </div>

                <!-- FORM TAMBAH KOMENTAR -->
                <form action="{{ route('comments.store') }}" method="POST" class="pt-2 border-t border-slate-800 space-y-3">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <textarea name="comment" rows="2" required placeholder="Tulis komentar atau pertanyaan di sini..." class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 placeholder-slate-600"></textarea>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold uppercase rounded-lg transition border border-slate-700">
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>