@props(['priority'])

@php
    $priorityMap = [
        'low' => [
            'label'  => 'LOW',
            'bg'     => 'bg-slate-800',
            'text'   => 'text-slate-300',
            'border' => 'border-slate-700',
        ],
        'medium' => [
            'label'  => 'MEDIUM',
            'bg'     => 'bg-blue-950/60',
            'text'   => 'text-blue-400',
            'border' => 'border-blue-500/30',
        ],
        'high' => [
            'label'  => 'HIGH',
            'bg'     => 'bg-rose-950/60',
            'text'   => 'text-rose-400',
            'border' => 'border-rose-500/30',
        ],
    ];

    $current = $priorityMap[strtolower($priority)] ?? $priorityMap['low'];
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold font-mono uppercase tracking-wider border {{ $current['bg'] }} {{ $current['text'] }} {{ $current['border'] }}">
    {{ $current['label'] }}
</span>