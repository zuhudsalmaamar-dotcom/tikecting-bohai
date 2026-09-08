@props(['status'])

@php
    $statusMap = [
        'open' => [
            'label'  => 'OPEN',
            'bg'     => 'bg-amber-500/10',
            'text'   => 'text-amber-400',
            'border' => 'border-amber-500/30',
            'dot'    => 'bg-amber-400',
            'pulse'  => true,
            'shadow' => 'shadow-amber-500/10',
        ],
        'in_progress' => [
            'label'  => 'IN PROGRESS',
            'bg'     => 'bg-cyan-500/10',
            'text'   => 'text-cyan-400',
            'border' => 'border-cyan-500/30',
            'dot'    => 'bg-cyan-400',
            'pulse'  => true,
            'shadow' => 'shadow-cyan-500/10',
        ],
        'resolved' => [
            'label'  => 'RESOLVED',
            'bg'     => 'bg-emerald-500/10',
            'text'   => 'text-emerald-400',
            'border' => 'border-emerald-500/30',
            'dot'    => 'bg-emerald-400',
            'pulse'  => false,
            'shadow' => 'shadow-emerald-500/10',
        ],
        'closed' => [
            'label'  => 'CLOSED',
            'bg'     => 'bg-slate-500/10',
            'text'   => 'text-slate-400',
            'border' => 'border-slate-600/30',
            'dot'    => 'bg-slate-400',
            'pulse'  => false,
            'shadow' => 'shadow-slate-500/10',
        ],
    ];

    $current = $statusMap[$status] ?? $statusMap['open'];
@endphp

<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold font-mono uppercase tracking-wider border shadow-sm {{ $current['bg'] }} {{ $current['text'] }} {{ $current['border'] }} {{ $current['shadow'] }}">
    <span class="relative flex h-2 w-2">
        @if($current['pulse'])
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $current['dot'] }} opacity-75"></span>
        @endif
        <span class="relative inline-flex rounded-full h-2 w-2 {{ $current['dot'] }}"></span>
    </span>
    <span>{{ $current['label'] }}</span>
</span>