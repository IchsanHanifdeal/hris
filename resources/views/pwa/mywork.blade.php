<x-pwa.main>
    <div class="flex flex-col h-full animate-in fade-in duration-700 select-none pb-32 overflow-x-hidden" x-data="{ tab: 'attendance' }">
        
        <div class="px-6 pt-8 pb-6 bg-base-100/50 backdrop-blur-3xl sticky top-0 z-50">
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('attendance.index') }}" class="size-10 rounded-2xl bg-base-200 flex items-center justify-center text-base-content active:scale-95 transition-all">
                        <x-lucide-chevron-left class="size-5" />
                    </a>
                    <h1 class="text-2xl font-black tracking-tight text-base-content">{{ __('pwa.attendance.history_title') }}</h1>
                </div>

                <form action="{{ route('attendance.mywork') }}" method="GET" class="flex items-center gap-2 p-1 bg-base-200/50 rounded-2xl border border-white/5">
                    <div class="flex-1 flex items-center gap-2 px-3">
                        <x-lucide-calendar class="size-4 opacity-30" />
                        <input type="date" name="from" value="{{ $dateFrom }}" class="bg-transparent text-[10px] font-bold text-base-content focus:outline-none w-full appearance-none">
                    </div>
                    <div class="h-4 w-px bg-base-content/10"></div>
                    <div class="flex-1 flex items-center gap-2 px-3">
                        <input type="date" name="to" value="{{ $dateTo }}" class="bg-transparent text-[10px] font-bold text-base-content focus:outline-none w-full appearance-none">
                    </div>
                    <button type="submit" class="size-10 rounded-xl bg-primary flex items-center justify-center text-white active:scale-95 transition-all">
                        <x-lucide-search class="size-4" />
                    </button>
                </form>

                <div class="flex p-1 bg-base-200/50 rounded-2xl border border-white/5">
                    <button @click="tab = 'attendance'" 
                            :class="tab === 'attendance' ? 'bg-base-100 text-primary shadow-sm' : 'text-base-content/40'"
                            class="flex-1 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all duration-300">
                        {{ __('pwa.attendance.history') }}
                    </button>
                    <button @click="tab = 'leave'" 
                            :class="tab === 'leave' ? 'bg-base-100 text-primary shadow-sm' : 'text-base-content/40'"
                            class="flex-1 py-3 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all duration-300">
                        {{ __('pwa.attendance.leave_history') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="px-6 mt-6">
            
            <div x-show="tab === 'attendance'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="flex flex-col gap-4">
                @forelse($attendances as $item)
                    <div class="group flex flex-col p-5 bg-base-200/30 rounded-3xl border border-white/5 hover:bg-base-200/50 transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-widest text-base-content/30">{{ $item->date->translatedFormat('l') }}</span>
                                <span class="text-sm font-black text-base-content">{{ $item->date->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $item->status === 'late' ? 'bg-warning/10 text-warning' : 'bg-success/10 text-success' }}">
                                {{ $item->status }}
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex-1 p-3 bg-base-100/50 rounded-2xl border border-white/5 flex flex-col items-center">
                                <span class="text-[8px] font-bold uppercase tracking-tighter opacity-30 mb-1">IN</span>
                                <span class="text-lg font-black tabular-nums">{{ $item->time_in ? \Carbon\Carbon::parse($item->time_in)->format('H:i') : '--:--' }}</span>
                            </div>
                            <div class="flex-1 p-3 bg-base-100/50 rounded-2xl border border-white/5 flex flex-col items-center">
                                <span class="text-[8px] font-bold uppercase tracking-tighter opacity-30 mb-1">OUT</span>
                                <span class="text-lg font-black tabular-nums">{{ $item->time_out ? \Carbon\Carbon::parse($item->time_out)->format('H:i') : '--:--' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-20 flex flex-col items-center justify-center opacity-20 gap-4">
                        <x-lucide-calendar-x class="size-16 stroke-[1]" />
                        <span class="text-[10px] font-black uppercase tracking-widest">{{ __('pwa.attendance.no_logs') }}</span>
                    </div>
                @endforelse
            </div>

            <div x-show="tab === 'leave'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-cloak class="flex flex-col gap-4">
                @forelse($leaveRequests as $item)
                    <div class="group flex flex-col p-5 bg-base-200/30 rounded-3xl border border-white/5 hover:bg-base-200/50 transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-widest text-base-content/30">{{ $item->leaveType->name }}</span>
                                <span class="text-xs font-bold text-base-content/60">{{ $item->start_date->translatedFormat('d M') }} — {{ $item->end_date->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $item->status === 'approved' ? 'bg-success/10 text-success' : ($item->status === 'rejected' ? 'bg-error/10 text-error' : 'bg-info/10 text-info') }}">
                                {{ $item->status }}
                            </div>
                        </div>

                        <p class="text-[11px] font-medium text-base-content/50 italic px-2 line-clamp-2">"{{ $item->reason }}"</p>
                    </div>
                @empty
                    <div class="py-20 flex flex-col items-center justify-center opacity-20 gap-4">
                        <x-lucide-plane-landing class="size-16 stroke-[1]" />
                        <span class="text-[10px] font-black uppercase tracking-widest">{{ __('pwa.attendance.no_logs') }}</span>
                    </div>
                @endforelse
            </div>

        </div>

    </div>
</x-pwa.main>