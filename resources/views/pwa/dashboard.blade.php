<x-pwa.main title="Dashboard">
    <div class="space-y-6">
        
        <div class="flex items-center justify-between bg-gradient-to-br from-primary/10 to-base-100 p-4 rounded-3xl border border-primary/10">
            <div class="flex items-center gap-3">
                <div class="avatar">
                    <div class="w-12 h-12 rounded-2xl ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4f46e5&color=fff" />
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-black tracking-tight">{{ auth()->user()->name }}</h2>
                    <p class="text-[10px] opacity-50 uppercase font-bold tracking-widest">
                        {{ auth()->user()->employee->position->name ?? 'Staff' }}
                    </p>
                </div>
            </div>
            <button class="btn btn-ghost btn-circle">
                <x-lucide-scan-face class="size-6 opacity-50" />
            </button>
        </div>

        <div class="card bg-base-100 shadow-xl shadow-base-300/50 rounded-[2rem] overflow-hidden border border-base-content/5">
            <div class="card-body p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <x-lucide-calendar class="size-4 text-primary" />
                        <span class="text-xs font-bold opacity-60">{{ now()->isoFormat('dddd, D MMM Y') }}</span>
                    </div>
                    <span class="badge badge-ghost badge-sm font-mono text-[10px] uppercase">
                        {{ auth()->user()->employee->current_shift->name ?? 'Regular Shift' }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 bg-base-200/50 p-4 rounded-2xl border border-base-content/5">
                    <div class="text-center space-y-1">
                        <div class="flex items-center justify-center gap-1 text-emerald-500 font-black">
                            <x-lucide-clock class="size-4" />
                            <span class="text-xl">

                            </span>
                        </div>
                        <p class="text-[10px] font-bold opacity-40 uppercase tracking-tighter">{{ __('pwa.clock_in') }}</p>
                    </div>
                    <div class="text-center space-y-1 border-l border-base-content/10">
                        <div class="flex items-center justify-center gap-1 text-rose-500 font-black">
                            <x-lucide-clock class="size-4" />
                            <span class="text-xl">

                            </span>
                        </div>
                        <p class="text-[10px] font-bold opacity-40 uppercase tracking-tighter">{{ __('pwa.clock_out') }}</p>
                    </div>
                </div>
                
                <div class="mt-4 flex gap-2">
                    <button class="btn btn-primary flex-1 rounded-xl shadow-lg shadow-primary/20 text-white font-black uppercase text-xs" 

                        {{ __('pwa.btn_in') }}
                    </button>
                    <button class="btn btn-outline flex-1 rounded-xl border-base-content/10 font-black uppercase text-xs"

                        {{ __('pwa.btn_out') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4 px-2">
            @php
                $menus = [
                    ['icon' => 'user-round', 'label' => __('pwa.menu.info'), 'color' => 'bg-blue-500/10 text-blue-600'],
                    ['icon' => 'briefcase', 'label' => __('pwa.menu.career'), 'color' => 'bg-purple-500/10 text-purple-600'],
                    ['icon' => 'heart-pulse', 'label' => __('pwa.menu.medical'), 'color' => 'bg-rose-500/10 text-rose-600'],
                    ['icon' => 'banknote', 'label' => __('pwa.menu.payslip'), 'color' => 'bg-emerald-500/10 text-emerald-600'],
                    ['icon' => 'shield-check', 'label' => __('pwa.menu.benefit'), 'color' => 'bg-orange-500/10 text-orange-600'],
                    ['icon' => 'pencil-line', 'label' => __('pwa.menu.edit'), 'color' => 'bg-gray-500/10 text-gray-600'],
                ];
            @endphp

            @foreach($menus as $menu)
                <a href="#" class="flex flex-col items-center gap-2 group">
                    <div class="size-14 {{ $menu['color'] }} rounded-2xl flex items-center justify-center shadow-sm group-active:scale-90 transition-transform">
                        <x-dynamic-component :component="'lucide-' . $menu['icon']" class="size-6" />
                    </div>
                    <span class="text-[10px] font-bold text-center leading-tight opacity-70">{{ $menu['label'] }}</span>
                </a>
            @endforeach
        </div>


    </div>
</x-pwa.main>