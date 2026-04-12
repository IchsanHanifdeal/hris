@php $setting = \App\Models\Setting::first(); @endphp
<header class="sticky top-0 z-50 w-full bg-base-100/60 backdrop-blur-2xl border-b border-base-content/5 px-4 h-16 flex items-center justify-between transition-all duration-500">
    <div class="flex items-center gap-3.5 group cursor-default">
        <div class="relative">
            <div class="relative w-11 h-11 rounded-2xl p-0.5 bg-gradient-to-tr from-primary/20 via-transparent to-secondary/20 border border-base-content/5 shadow-xl transform transition-all duration-500 overflow-hidden bg-base-100 ring-1 ring-base-content/5">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff&bold=true&size=128" 
                     alt="{{ auth()->user()->name }}"
                     class="w-full h-full object-cover rounded-[0.95rem] transition-all duration-700 group-hover:scale-110" />
            </div>
        </div>
        <div class="flex flex-col gap-0.5">
            <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em] leading-none opacity-80 mb-0.5">{{ $setting->app_name ?? config('app.name') }}</span>
            <h1 class="text-xs font-black text-base-content uppercase tracking-tight leading-none">{{ Auth::user()->name }}</h1>
        </div>
    </div>

    <div class="flex items-center gap-1">
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-sm h-9 px-2 gap-2 hover:bg-primary/10 rounded-xl transition-all duration-300 group">
                 <div class="flex items-center gap-1.5">
                    @if(app()->getLocale() == 'id')
                        <span class="text-base leading-none shadow-sm rounded-sm">🇮🇩</span>
                    @else
                        <span class="text-base leading-none shadow-sm rounded-sm">🇺🇸</span>
                    @endif
                    <span class="text-[10px] font-black uppercase opacity-40 group-hover:opacity-100 transition-opacity">{{ app()->getLocale() }}</span>
                 </div>
                 <x-lucide-chevron-down class="size-3 opacity-20 group-hover:opacity-50 transition-opacity" />
            </div>
            <ul tabindex="0" class="dropdown-content z-[100] menu p-2 shadow-2xl bg-base-100/95 backdrop-blur-xl border border-base-content/5 rounded-2xl w-44 mt-3 ring-1 ring-black/5 animate-in fade-in slide-in-from-top-2 duration-300">
                <li class="menu-title px-4 py-2 border-b border-base-content/5 mb-1">
                    <span class="text-[9px] font-black uppercase tracking-widest opacity-40">{{ __('menu.select_language') }}</span>
                </li>
                <li>
                    <a href="{{ route('lang.switch', 'id') }}" class="flex items-center justify-between py-2.5 px-4 rounded-xl {{ app()->getLocale() == 'id' ? 'bg-primary/10 text-primary active' : 'hover:bg-base-200' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">🇮🇩</span>
                            <span class="text-[11px] font-bold uppercase tracking-wider">Indonesia</span>
                        </div>
                        @if(app()->getLocale() == 'id') <x-lucide-check class="size-3.5 stroke-[3]" /> @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('lang.switch', 'en') }}" class="flex items-center justify-between py-2.5 px-4 rounded-xl {{ app()->getLocale() == 'en' ? 'bg-primary/10 text-primary active' : 'hover:bg-base-200' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">🇺🇸</span>
                            <span class="text-[11px] font-bold uppercase tracking-wider">English</span>
                        </div>
                        @if(app()->getLocale() == 'en') <x-lucide-check class="size-3.5 stroke-[3]" /> @endif
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>
