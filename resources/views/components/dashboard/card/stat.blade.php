@props([
    'title',
    'value',
    'icon',
    'variant' => 'primary',
    'desc' => null
])

@php
    $variants = [
        'primary' => 'text-primary border-primary/10 hover:border-primary/30',
        'success' => 'text-success border-success/10 hover:border-success/30',
        'warning' => 'text-warning border-warning/10 hover:border-warning/30',
        'error'   => 'text-error border-error/10 hover:border-error/30',
    ];

    $iconBg = [
        'primary' => 'bg-primary/10',
        'success' => 'bg-success/10',
        'warning' => 'bg-warning/10',
        'error'   => 'bg-error/10',
    ];

    $currentVariant = $variants[$variant] ?? $variants['primary'];
    $currentIconBg = $iconBg[$variant] ?? $iconBg['primary'];
@endphp

<div class="stats bg-base-100 shadow-xl border {{ $currentVariant }} overflow-hidden group transition-all duration-300 rounded-[2rem]">
    <div class="stat p-6">
        <div class="stat-figure {{ $currentVariant }} group-hover:scale-110 transition-transform duration-500">
            <div class="p-4 {{ $currentIconBg }} rounded-2xl">
                @if($icon === 'users')
                    <x-lucide-users class="w-8 h-8" />
                @elseif($icon === 'user-check')
                    <x-lucide-user-check class="w-8 h-8" />
                @elseif($icon === 'plane-takeoff')
                    <x-lucide-plane-takeoff class="w-8 h-8" />
                @elseif($icon === 'alarm-clock')
                    <x-lucide-alarm-clock class="w-8 h-8" />
                @else
                    <x-lucide-activity class="w-8 h-8" />
                @endif
            </div>
        </div>
        <div class="stat-title text-[10px] font-black uppercase tracking-[0.2em] opacity-40 mb-1">{{ $title }}</div>
        <div class="stat-value {{ $currentVariant }} text-4xl font-black tracking-tighter">{{ $value }}</div>
        @if($desc)
            <div class="stat-desc text-[10px] mt-2 font-bold opacity-60 tracking-tight">{{ $desc }}</div>
        @endif
    </div>
</div>