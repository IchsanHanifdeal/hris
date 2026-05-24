@php
    $user = auth()->user();
@endphp

<div class="drawer-side z-50">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    
    <ul class="menu p-4 w-72 min-h-full bg-base-100 text-base-content border-r border-base-content/10
               [&>li>a]:gap-3 [&>li]:my-0.5 [&>li]:font-medium [&>li]:text-[14px]
               [&>li>a]:transition-all [&>li>a]:duration-200
               [&>_*_svg]:stroke-[1.5] [&>_*_svg]:size-[18px]">
        
        @php $setting = \App\Models\Setting::first(); @endphp
        <div class="pb-6 mb-4 border-b border-base-content/10 flex items-center gap-4 px-2 pt-2">
            @if($setting && $setting->app_logo)
                <img src="{{ asset('storage/' . $setting->app_logo) }}" class="w-10 h-10 rounded-xl object-contain shadow-lg shadow-primary/10">
            @else
                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center shadow-sm text-white">
                    <x-lucide-command class="w-6 h-6" />
                </div>
            @endif
            <div>
                <span class="block text-lg font-black tracking-tight text-base-content leading-none">
                    {{ $setting->app_name ?? config('app.name', 'HRIS PRO') }}
                </span>
            </div>
        </div>

        <span class="px-4 text-[11px] font-bold text-base-content/40 uppercase tracking-wider mb-2 mt-2">
            {{ __('menu.general') }}
        </span>
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'menu-active' : 'hover:bg-base-200/50 hover:text-primary' }}">
                <x-lucide-layout-dashboard />
                {{ __('menu.dashboard') }}
            </a>
        </li>

        @if ($user?->hasRole(['admin', 'hrd']))
            <span class="px-4 text-[11px] font-bold text-base-content/30 uppercase tracking-wider mb-2 mt-6">
                {{ __('menu.master_data') }}
            </span>
            
            <li>
                <a href="{{ route('shifts.index') }}" class="{{ request()->routeIs('shifts.*') ? 'menu-active' : 'hover:bg-base-200/50 hover:text-primary' }}">
                    <x-lucide-calendar-clock />
                    {{ __('menu.shifts') }}
                </a>
            </li>
            <li>
                <a href="{{ route('leave-types.index') }}" class="{{ request()->routeIs('leave-types.*') ? 'menu-active' : 'hover:bg-base-200/50 hover:text-primary' }}">
                    <x-lucide-calendar-off />
                    {{ __('menu.leave_types') }}
                </a>
            </li>

            <span class="px-4 text-[11px] font-bold text-base-content/30 uppercase tracking-wider mb-2 mt-6">
                {{ __('menu.hr_management') }}
            </span>
            <li>
                <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'menu-active' : 'hover:bg-base-200/50 hover:text-primary' }}">
                    <x-lucide-users />
                    {{ __('menu.employees') }}
                </a>
            </li>
            <li>
                <a href="{{ route('schedules.index') }}" class="{{ request()->routeIs('schedules.*') ? 'menu-active' : 'hover:bg-base-200/50 hover:text-primary' }}">
                    <x-lucide-calendar-range />
                    {{ __('menu.schedules') }}
                </a>
            </li>
        @endif

        <span class="px-4 text-[11px] font-bold text-base-content/30 uppercase tracking-wider mb-2 mt-6">
            {{ __('menu.activities') }}
        </span>
        
        <li>
            <a href="{{ route('attendances.index') }}" class="{{ request()->routeIs('attendances.*') ? 'menu-active' : 'hover:bg-base-200/50 hover:text-primary' }}">
                <x-lucide-map-pin />
                {{ __('menu.attendance') }}
            </a>
        </li>
        
        <li>
            <a href="{{ route('leave-requests.index') }}" class="{{ request()->routeIs('leave-requests.*') ? 'menu-active' : 'hover:bg-base-200/50 hover:text-primary' }}">
                <x-lucide-plane-takeoff />
                {{ __('menu.leave_requests') }}
            </a>
        </li>

        <span class="px-4 text-[11px] font-bold text-base-content/30 uppercase tracking-wider mb-2 mt-6">
            {{ __('menu.settings') }}
        </span>

        <li>
            <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'menu-active' : 'hover:bg-base-200/50 hover:text-primary' }}">
                <x-lucide-settings />
                {{ __('menu.settings') }}
            </a>
        </li>

        <div class="mt-auto pt-6">
            <span class="px-4 text-[11px] font-bold text-base-content/30 uppercase tracking-wider mb-2">
                {{ __('menu.system') }}
            </span>
            
            <li>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'menu-active' : 'hover:bg-base-200/50 hover:text-primary' }}">
                    <x-lucide-user-cog />
                    {{ __('menu.profile') }}
                </a>
            </li>
            
            <li>
                <a class="cursor-pointer text-error hover:bg-error/10 hover:text-error" onclick="logout_modal.showModal()">
                    <x-lucide-log-out />
                    {{ __('menu.logout') }}
                </a>
            </li>
        </div>
    </ul>
</div>

    <dialog id="logout_modal" class="modal modal-bottom sm:modal-middle transition-all duration-300">
        <div class="modal-box bg-base-100/80 backdrop-blur-2xl border border-base-content/10 rounded-[2rem] shadow-2xl p-8">
            
            <div class="flex flex-col items-center text-center space-y-4">
                <div class="w-20 h-20 rounded-3xl bg-error/10 flex items-center justify-center text-error mb-2 rotate-3 hover:rotate-0 transition-transform duration-500">
                    <x-lucide-log-out class="w-10 h-10" />
                </div>
                
                <h3 class="font-black text-2xl text-base-content tracking-tight">
                    {{ __('menu.logout_confirm_title') }}
                </h3>
                
                <p class="text-base-content/60 leading-relaxed max-w-xs">
                    {{ __('menu.logout_confirm_msg') }}
                </p>
            </div>
            <div class="modal-action grid grid-cols-2 gap-4 mt-8">
                <form method="dialog" class="w-full">
                    <button class="btn btn-ghost w-full h-14 rounded-2xl border border-base-content/5 hover:bg-base-200 transition-all font-bold">
                        {{ __('menu.cancel') }}
                    </button>
                </form>
                
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="btn btn-error w-full h-14 rounded-2xl text-white shadow-xl shadow-error/20 hover:scale-[1.02] active:scale-95 transition-all font-bold">
                        {{ __('menu.yes_logout') }}
                    </button>
                </form>
            </div>
            <form method="dialog" class="absolute right-4 top-4">
                <button class="btn btn-sm btn-circle btn-ghost opacity-30 hover:opacity-100">
                    <x-lucide-x class="w-4 h-4" />
                </button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop bg-base-900/60 backdrop-blur-md transition-all duration-500">
            <button>close</button>
        </form>
    </dialog>