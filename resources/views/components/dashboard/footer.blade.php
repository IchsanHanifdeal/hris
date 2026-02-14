<footer class="footer items-center p-4 bg-base-100/30 text-base-content/50 border-t border-base-content/5 mt-auto">
    <div class="flex flex-col md:flex-row w-full justify-between items-center gap-4 px-4 text-[11px] font-medium tracking-wide">
        
        <div class="flex items-center gap-2">
            <x-lucide-copyright class="w-3 h-3" />
            <span>{{ date('Y') }}</span>
            <span class="font-bold text-base-content/70">{{ config('app.name', 'HRIS PRO') }}</span>
            <span class="hidden sm:inline opacity-30">|</span>
            <span class="hidden sm:inline capitalize">{{ config('app.env') }} Mode</span>
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center gap-1.5">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="uppercase">Server Online</span>
            </div>
            <div class="hidden md:flex items-center gap-1.5">
                <x-lucide-database class="w-3 h-3" />
                <span>v{{ PHP_VERSION }}</span>
            </div>
            <div class="hidden md:flex items-center gap-1.5">
                <x-lucide-cpu class="w-3 h-3" />
                <span>{{ round(memory_get_usage() / 1024 / 1024, 2) }} MB</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <a href="#" class="hover:text-primary transition-colors uppercase tracking-widest">Documentation</a>
            <span class="opacity-30">/</span>
            <div class="badge badge-outline border-base-content/20 text-[10px] font-bold h-5">
                VER 1.0.4-STABLE
            </div>
        </div>
    </div>
</footer>