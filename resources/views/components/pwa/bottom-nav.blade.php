@php
    $isDashboard  = request()->routeIs('dashboard');
    $isLeave      = request()->routeIs('leave-requests.*');
    $isAttendance = request()->routeIs('attendance.*');
    $isWork       = request()->routeIs('attendance.mywork');
    $isProfile    = request()->routeIs('profile.*');
@endphp

<div class="absolute bottom-0 w-full max-w-md mx-auto z-[9000] bg-base-100/95 backdrop-blur-xl pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.05)] border-t border-base-200 flex justify-around items-center h-16 sm:h-[4.5rem] px-2">

    <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-16 h-full gap-1 transition-all duration-300 group">
        <div class="relative">
            @if($isDashboard)
                <div class="absolute -inset-2 bg-primary/20 blur-md rounded-full"></div>
            @endif
            <x-lucide-home class="relative transition-all duration-500 {{ $isDashboard ? 'text-primary size-6 stroke-[2.5] scale-110 drop-shadow-sm' : 'text-base-content/30 size-5 stroke-[1.5] group-hover:scale-110' }}" />
        </div>
        <span class="text-[9px] font-black tracking-[0.05em] uppercase transition-colors {{ $isDashboard ? 'text-primary' : 'text-base-content/30 group-hover:text-primary/70' }}">
            {{ __('menu.home') ?? 'Home' }}
        </span>
    </a>

    <a href="{{ route('leave-requests.index') }}" class="flex flex-col items-center justify-center w-16 h-full gap-1 transition-all duration-300 group">
        <x-lucide-calendar-days class="transition-all duration-500 {{ $isLeave ? 'text-secondary size-6 stroke-[2.5] scale-110 drop-shadow-sm' : 'text-base-content/30 size-5 stroke-[1.5] group-hover:scale-110' }}" />
        <span class="text-[9px] font-black tracking-[0.05em] uppercase transition-colors {{ $isLeave ? 'text-secondary' : 'text-base-content/30 group-hover:text-secondary/70' }}">
            {{ __('menu.leave') ?? 'Cuti' }}
        </span>
    </a>

    <a href="{{ route('attendance.index') }}" class="relative w-16 h-full flex flex-col items-center group">
        <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-14 h-14 bg-gradient-to-tr from-primary to-primary-focus text-primary-content rounded-2xl flex items-center justify-center shadow-xl shadow-primary/30 border-[4px] border-base-100 transition-all duration-500 transform group-hover:-translate-y-1 group-active:scale-90 group-active:rotate-6 z-50">
            <x-lucide-alarm-clock class="size-7.5 stroke-[2.5] {{ $isAttendance ? 'animate-pulse' : '' }}" />
        </div>
        <div class="mt-auto pb-1.5 flex flex-col items-center">
            <span class="text-[9px] font-black tracking-[0.05em] uppercase transition-colors duration-300 {{ $isAttendance ? 'text-primary' : 'text-base-content/30 group-hover:text-primary/70' }}">
                {{ __('menu.attendance') ?? 'Record' }}
            </span>
        </div>
    </a>

    <a href="{{ route('attendance.mywork') }}" class="flex flex-col items-center justify-center w-16 h-full gap-1 transition-all duration-300 group">
        <x-lucide-briefcase class="transition-all duration-500 {{ $isWork ? 'text-accent size-6 stroke-[2.5] scale-110 drop-shadow-sm' : 'text-base-content/30 size-5 stroke-[1.5] group-hover:scale-110' }}" />
        <span class="text-[9px] font-black tracking-[0.05em] uppercase transition-colors {{ $isWork ? 'text-accent' : 'text-base-content/30 group-hover:text-accent/70' }}">
            {{  __('menu.my_work') ?? 'History'  }}
        </span>
    </a>

    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-16 h-full gap-1 transition-all duration-300 group">
        <x-lucide-user class="transition-all duration-500 {{ $isProfile ? 'text-accent size-6 stroke-[2.5] scale-110 drop-shadow-sm' : 'text-base-content/30 size-5 stroke-[1.5] group-hover:scale-110' }}" />
        <span class="text-[9px] font-black tracking-[0.05em] uppercase transition-colors {{ $isProfile ? 'text-accent' : 'text-base-content/30 group-hover:text-accent/70' }}">
            {{ __('menu.profile') ?? 'Profile' }}
        </span>
    </a>

</div>
