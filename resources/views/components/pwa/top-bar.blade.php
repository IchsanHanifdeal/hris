<header class="sticky top-0 z-40 w-full bg-base-100/80 backdrop-blur-xl border-b border-base-content/5 px-4 h-16 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/20">
            <x-lucide-command class="size-6" />
        </div>
        <div class="flex flex-col">
            <span class="text-xs font-bold opacity-40 uppercase tracking-tighter leading-none">Indodev Niaga</span>
            <span class="text-sm font-black text-base-content uppercase tracking-tight">HRIS PRO</span>
        </div>
    </div>
    
    <div class="flex items-center gap-2">
        <button class="btn btn-ghost btn-circle btn-sm relative">
            <x-lucide-bell class="size-5 opacity-70" />
            <span class="badge badge-primary badge-xs absolute top-1 right-1"></span>
        </button>
        <div class="avatar">
            <div class="w-8 rounded-lg ring ring-primary ring-offset-base-100 ring-offset-1">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" />
            </div>
        </div>
    </div>
</header>