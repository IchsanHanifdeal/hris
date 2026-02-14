@props(['title', 'value', 'icon' => 'box', 'variant' => 'primary'])

@php
    $variants = [
        'primary' => 'from-primary/20 to-primary/5 text-primary border-primary/20',
        'success' => 'from-success/20 to-success/5 text-success border-success/20',
        'warning' => 'from-warning/20 to-warning/5 text-warning border-warning/20',
        'error'   => 'from-error/20 to-error/5 text-error border-error/20',
    ];
    $currentVariant = $variants[$variant] ?? $variants['primary'];
@endphp

<div class="flex items-center p-6 bg-base-100 border border-base-content/5 rounded-2xl shadow-xl hover:border-primary/30 transition-all group">
    <div class="p-4 mr-5 bg-gradient-to-br {{ $currentVariant }} rounded-2xl group-hover:scale-110 transition-transform">
        <x-dynamic-component :component="'lucide-' . $icon" class="size-6" />
    </div>

    <div>
        <p class="text-xs font-bold uppercase tracking-widest opacity-50 mb-1">
            {{ $title }}
        </p>
        <p class="text-2xl font-black text-base-content tracking-tight">
            {{ $value }}
        </p>
    </div>
</div>