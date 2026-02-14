<nav class="fixed bottom-0 left-0 right-0 z-50 bg-[#282a36]/90 backdrop-blur-xl border-t border-[#44475a] safe-area-bottom shadow-[0_-10px_40px_rgba(0,0,0,0.3)]">
    <div class="flex items-center justify-around h-20 px-2 relative">
        
        <a href="{{ route('dashboard') }}" 
           class="flex flex-col items-center justify-center w-full gap-1 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'text-[#bd93f9]' : 'text-[#6272a4] hover:text-[#bd93f9]/60' }}">
            <x-lucide-home class="{{ request()->routeIs('dashboard') ? 'size-6 stroke-[2.5]' : 'size-5 stroke-[1.5]' }}" />
            <span class="text-[10px] font-black uppercase tracking-tighter">{{ __('menu.home') ?? 'Home' }}</span>
        </a>

        <a href="#" class="flex flex-col items-center justify-center w-full gap-1 text-[#6272a4] hover:text-[#bd93f9]/60 transition-all">
            <x-lucide-layout-grid class="size-5 stroke-[1.5]" />
            <span class="text-[10px] font-black uppercase tracking-tighter">Menu</span>
        </a>
        
        <div class="relative w-full flex justify-center -mt-10">
            <a href="{{ route('attendances.index') }}" class="flex flex-col items-center gap-1 group">
                <div class="size-16 bg-gradient-to-tr from-[#bd93f9] to-[#ff79c6] rounded-2xl shadow-xl shadow-[#bd93f9]/20 flex items-center justify-center text-[#282a36] border-[6px] border-[#282a36] transform transition-all duration-300 group-hover:scale-110 group-active:scale-95 group-active:rotate-12">
                    <x-lucide-alarm-clock class="size-8 stroke-[2]" />
                </div>
                <span class="text-[10px] font-black uppercase tracking-tighter mt-1 {{ request()->routeIs('attendances.*') ? 'text-[#bd93f9]' : 'text-[#6272a4]' }}">
                    {{ __('menu.attendance') ?? 'Record' }}
                </span>
            </a>
        </div>

        <a href="#" class="flex flex-col items-center justify-center w-full gap-1 text-[#6272a4] hover:text-[#bd93f9]/60 transition-all">
            <x-lucide-briefcase class="size-5 stroke-[1.5]" />
            <span class="text-[10px] font-black uppercase tracking-tighter">My Work</span>
        </a>

        <a href="{{ route('profile.edit') }}" 
           class="flex flex-col items-center justify-center w-full gap-1 transition-all duration-300 {{ request()->routeIs('profile.*') ? 'text-[#bd93f9]' : 'text-[#6272a4] hover:text-[#bd93f9]/60' }}">
            <x-lucide-user class="{{ request()->routeIs('profile.*') ? 'size-6 stroke-[2.5]' : 'size-5 stroke-[1.5]' }}" />
            <span class="text-[10px] font-black uppercase tracking-tighter">{{ __('menu.profile') ?? 'Profile' }}</span>
        </a>

    </div>
</nav>