<x-pwa.main>
    <div class="flex flex-col h-full animate-in fade-in slide-in-from-bottom-5 duration-700 select-none pb-32 overflow-x-hidden">
        
        {{-- Profile Bar --}}
        <div class="px-6 pt-8 pb-4 flex justify-between items-center">
            <div class="flex flex-col">
                <h1 class="text-xl font-black text-base-content tracking-tight">
                    {{ __('pwa.dashboard.greeting', ['name' => explode(' ', $employee->user->name)[0]]) }}
                </h1>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-base-content/30">{{ __('pwa.dashboard.welcome') }}</p>
            </div>
            <div class="size-12 rounded-2xl bg-base-200 border border-white/5 flex items-center justify-center overflow-hidden shadow-xl">
                @if($employee->user->profile_photo_url)
                    <img src="{{ $employee->user->profile_photo_url }}" class="w-full h-full object-cover">
                @else
                    <x-lucide-user class="size-6 text-base-content/20" />
                @endif
            </div>
        </div>

        {{-- Main Status Card --}}
        <div class="px-4 mt-4">
            <div class="relative w-full aspect-[16/9] rounded-[2.5rem] overflow-hidden group shadow-2xl">
                {{-- Background effects --}}
                <div class="absolute inset-0 bg-gradient-to-br {{ $todayAttendance ? ($todayAttendance->time_out ? 'from-base-300 to-base-200' : 'from-primary to-primary-focus') : 'from-base-300 to-base-200' }} transition-all duration-700"></div>
                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_50%_120%,rgba(255,255,255,0.4),transparent)]"></div>
                
                <div class="absolute inset-0 p-8 flex flex-col justify-between z-10">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                             <div class="size-1.5 rounded-full {{ $todayAttendance && !$todayAttendance->time_out ? 'bg-white animate-pulse' : 'bg-base-content/20' }}"></div>
                             <span class="text-[10px] font-black uppercase tracking-widest {{ $todayAttendance && !$todayAttendance->time_out ? 'text-white/60' : 'text-base-content/40' }}">
                                @if(!$todayAttendance)
                                    {{ __('pwa.dashboard.status_not_checked') }}
                                @elseif(!$todayAttendance->time_out)
                                    {{ __('pwa.dashboard.status_working') }}
                                @else
                                    {{ __('pwa.dashboard.status_finished') }}
                                @endif
                             </span>
                        </div>
                        <h2 class="text-3xl font-black tracking-tighter {{ $todayAttendance && !$todayAttendance->time_out ? 'text-white' : 'text-base-content' }}">
                            {{ now()->format('H:i') }}
                        </h2>
                    </div>

                    <div class="flex items-end justify-between">
                        <div class="flex flex-col">
                            @if($todayAttendance)
                                <span class="text-[9px] font-bold uppercase tracking-widest {{ !$todayAttendance->time_out ? 'text-white/50' : 'text-base-content/20' }}">
                                    {{ __('pwa.dashboard.check_in_at', ['time' => \Carbon\Carbon::parse($todayAttendance->time_in)->format('H:i')]) }}
                                </span>
                                @if($todayAttendance->time_out)
                                <span class="text-[9px] font-bold uppercase tracking-widest text-base-content/20 mt-1">
                                    {{ __('pwa.dashboard.check_out_at', ['time' => \Carbon\Carbon::parse($todayAttendance->time_out)->format('H:i')]) }}
                                </span>
                                @endif
                            @endif
                        </div>
                        <a href="{{ route('attendance.index') }}" class="size-14 rounded-2xl {{ $todayAttendance && !$todayAttendance->time_out ? 'bg-white/10 text-white' : 'bg-primary text-white' }} backdrop-blur-md flex items-center justify-center shadow-2xl active:scale-90 transition-all">
                            <x-lucide-fingerprint class="size-7" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Menu --}}
        <div class="px-6 mt-12 mb-4">
             <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-base-content/30">{{ __('pwa.dashboard.quick_actions') }}</h3>
        </div>

        <div class="px-6 grid grid-cols-2 gap-4">
            <a href="{{ route('attendance.index') }}" class="group p-6 bg-base-200/40 rounded-[2rem] border border-white/5 flex flex-col items-center gap-4 active:scale-95 transition-all">
                <div class="size-14 rounded-2xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-all">
                    <x-lucide-map-pin class="size-6 text-primary" />
                </div>
                <span class="text-[11px] font-black uppercase tracking-widest">{{ __('menu.attendance') }}</span>
            </a>
            <a href="{{ route('leave-requests.index') }}" class="group p-6 bg-base-200/40 rounded-[2rem] border border-white/5 flex flex-col items-center gap-4 active:scale-95 transition-all">
                <div class="size-14 rounded-2xl bg-warning/10 flex items-center justify-center group-hover:bg-warning/20 transition-all">
                    <x-lucide-plane-landing class="size-6 text-warning" />
                </div>
                <span class="text-[11px] font-black uppercase tracking-widest text-center">{{ __('pwa.leave.request') }}</span>
            </a>
            <a href="{{ route('attendance.mywork') }}" class="group p-6 bg-base-200/40 rounded-[2rem] border border-white/5 flex flex-col items-center gap-4 active:scale-95 transition-all">
                <div class="size-14 rounded-2xl bg-info/10 flex items-center justify-center group-hover:bg-info/20 transition-all">
                    <x-lucide-history class="size-6 text-info" />
                </div>
                <span class="text-[11px] font-black uppercase tracking-widest">{{ __('pwa.attendance.history') }}</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="group p-6 bg-base-200/40 rounded-[2rem] border border-white/5 flex flex-col items-center gap-4 active:scale-95 transition-all">
                <div class="size-14 rounded-2xl bg-success/10 flex items-center justify-center group-hover:bg-success/20 transition-all">
                    <x-lucide-user-circle class="size-6 text-success" />
                </div>
                <span class="text-[11px] font-black uppercase tracking-widest">{{ __('pwa.dashboard.profile') }}</span>
            </a>
        </div>

        {{-- Monthly Stats --}}
        <div class="px-6 mt-12 mb-4">
             <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-base-content/30">{{ now()->translatedFormat('F Y') }}</h3>
        </div>

        <div class="px-6 flex flex-col gap-3">
             <div class="p-6 bg-base-200/30 rounded-[2rem] border border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <div class="size-12 rounded-xl bg-primary/5 flex items-center justify-center">
                        <x-lucide-calendar-check class="size-5 text-primary opacity-50" />
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[11px] font-black uppercase tracking-tight">{{ __('pwa.dashboard.attendance_card') }}</span>
                        <span class="text-[9px] font-bold text-base-content/30 uppercase tracking-widest">{{ $stats['present'] }} Days Marked</span>
                    </div>
                </div>
                <div class="text-xl font-black text-primary">{{ $stats['present'] }}</div>
             </div>

             <div class="p-6 bg-base-200/30 rounded-[2rem] border border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <div class="size-12 rounded-xl bg-warning/5 flex items-center justify-center">
                        <x-lucide-sun class="size-5 text-warning opacity-50" />
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[11px] font-black uppercase tracking-tight">{{ __('pwa.dashboard.leave_card') }}</span>
                        <span class="text-[9px] font-bold text-base-content/30 uppercase tracking-widest">{{ 12 - $stats['leave_used'] }} Days Available</span>
                    </div>
                </div>
                <div class="text-xl font-black text-warning">{{ 12 - $stats['leave_used'] }}</div>
             </div>
        </div>

    </div>
</x-pwa.main>