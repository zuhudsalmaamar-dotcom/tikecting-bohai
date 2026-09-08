<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-cyan-400 tracking-wide font-mono flex items-center gap-2">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    DASHBOARD IT HELPDESK
                </h2>
                <p class="text-xs text-slate-400 mt-1 font-mono">
                    User: <span class="text-white font-bold">{{ Auth::user()->name }}</span> — 
                    <span class="text-cyan-400 font-bold uppercase">[{{ Auth::user()->role }}]</span>
                </p>
            </div>

            @if(Auth::user()->role === 'user')
                <a href="{{ route('tickets.index') }}" class="px-5 py-2.5 bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs uppercase tracking-widest rounded-xl shadow-lg shadow-cyan-500/20 hover:shadow-cyan-400/40 transition-all duration-300 font-mono flex items-center gap-2 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Tiket Baru
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 bg-slate-950 min-h-screen text-slate-200 font-mono">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 1. STATISTIC CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                
                <!-- Total Tiket -->
                <div class="group bg-slate-900/90 border border-slate-800 hover:border-slate-700 rounded-2xl p-5 shadow-xl transition-all duration-300 relative overflow-hidden">
                    <div class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Tiket</div>
                    <div class="text-3xl font-extrabold text-white mt-2">{{ $totalTickets ?? 0 }}</div>
                    <div class="text-[10px] text-slate-500 mt-2">
                        {{ Auth::user()->role === 'user' ? 'Laporan kamu' : 'Global tiket' }}
                    </div>
                </div>

                <!-- Open -->
                <div class="group bg-slate-900/90 border border-slate-800 hover:border-amber-500/50 rounded-2xl p-5 shadow-xl transition-all duration-300 relative overflow-hidden border-l-4 border-l-amber-500">
                    <div class="text-amber-400 text-xs font-bold uppercase tracking-wider">Open</div>
                    <div class="text-3xl font-extrabold text-amber-400 mt-2">{{ $openTickets ?? 0 }}</div>
                    <div class="text-[10px] text-slate-500 mt-2">Menunggu antrean</div>
                </div>

                <!-- In Progress -->
                <div class="group bg-slate-900/90 border border-slate-800 hover:border-cyan-500/50 rounded-2xl p-5 shadow-xl transition-all duration-300 relative overflow-hidden border-l-4 border-l-cyan-500">
                    <div class="text-cyan-400 text-xs font-bold uppercase tracking-wider">In Progress</div>
                    <div class="text-3xl font-extrabold text-cyan-400 mt-2">{{ $inProgressTickets ?? 0 }}</div>
                    <div class="text-[10px] text-slate-500 mt-2">Dalam pengerjaan</div>
                </div>

                <!-- Resolved -->
                <div class="group bg-slate-900/90 border border-slate-800 hover:border-emerald-500/50 rounded-2xl p-5 shadow-xl transition-all duration-300 relative overflow-hidden border-l-4 border-l-emerald-500">
                    <div class="text-emerald-400 text-xs font-bold uppercase tracking-wider">Resolved</div>
                    <div class="text-3xl font-extrabold text-emerald-400 mt-2">{{ $resolvedTickets ?? 0 }}</div>
                    <div class="text-[10px] text-slate-500 mt-2">Selesai dikerjakan</div>
                </div>

                <!-- Closed -->
                <div class="group bg-slate-900/90 border border-slate-800 hover:border-slate-600 rounded-2xl p-5 shadow-xl transition-all duration-300 relative overflow-hidden border-l-4 border-l-slate-600">
                    <div class="text-slate-400 text-xs font-bold uppercase tracking-wider">Closed</div>
                    <div class="text-3xl font-extrabold text-slate-400 mt-2">{{ $closedTickets ?? 0 }}</div>
                    <div class="text-[10px] text-slate-500 mt-2">Tiket ditutup</div>
                </div>

            </div>

            <!-- 2. CHART & RECENT TICKETS GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- GRAFIK CHART.JS (2 Kolom) -->
                <div class="lg:col-span-2 bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl relative">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="font-bold text-sm text-cyan-400 tracking-wider uppercase">
                                Tiket Per Kategori
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">
                                {{ Auth::user()->role === 'user' ? 'Distribusi laporan masalah kamu' : 'Distribusi statistik tiket sistem' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="relative h-72 w-full">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <!-- TABEL TIKET TERBARU (1 Kolom) -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-sm text-cyan-400 tracking-wider uppercase mb-4">
                            Tiket Terbaru
                        </h3>

                        <div class="space-y-3">
                            @forelse($recentTickets as $ticket)
                                <div class="p-3 bg-slate-950/60 border border-slate-800 hover:border-slate-700 rounded-xl transition duration-200 flex items-center justify-between gap-3">
                                    <div class="truncate">
                                        <div class="text-xs font-bold text-slate-200 truncate">{{ $ticket->title }}</div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">#{{ $ticket->ticket_number }} • {{ $ticket->category->name ?? 'Umum' }}</div>
                                    </div>
                                    <x-ticket-status :status="$ticket->status" />
                                </div>
                            @empty
                                <div class="text-center py-8 text-xs text-slate-500">
                                    Belum ada tiket tercatat.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <a href="{{ route('tickets.index') }}" class="mt-4 w-full text-center py-2 bg-slate-800 hover:bg-slate-700 text-xs font-bold text-cyan-400 rounded-xl transition font-mono border border-slate-700">
                        Lihat Semua Tiket →
                    </a>
                </div>

            </div>

        </div>
    </div>

    <!-- SCRIPT CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('categoryChart').getContext('2d');
            
            const labels = @json($categoryLabels ?? []);
            const data   = @json($categoryData ?? []);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Tiket',
                        data: data,
                        backgroundColor: '#06b6d4',
                        borderColor: '#22d3ee',
                        borderWidth: 1,
                        borderRadius: 8,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: '#94a3b8', font: { family: 'monospace' } },
                            grid: { color: '#1e293b' }
                        },
                        x: {
                            ticks: { color: '#94a3b8', font: { family: 'monospace' } },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#38bdf8',
                            bodyColor: '#f8fafc',
                            borderColor: '#334155',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>