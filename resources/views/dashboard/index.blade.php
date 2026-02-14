<x-dashboard.main>
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-base-content">
                    {{ __('menu.dashboard') }}
                </h1>
                <p class="text-base-content/60 mt-1">{{ __('dashboard.subtitle') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="btn btn-ghost bg-base-100 border-base-content/10 shadow-sm cursor-default">
                    <x-lucide-calendar class="w-4 h-4 mr-2 text-primary" />
                    <span class="font-bold">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                </div>
                <a href="{{ route('employees.create') }}" class="btn btn-primary shadow-lg shadow-primary/20 rounded-2xl">
                    <x-lucide-plus class="w-4 h-4 mr-1" />
                    {{ __('dashboard.add_employee') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-dashboard.card.stat 
                title="{{ __('dashboard.stats.total_employees') }}" 
                value="{{ $totalEmployees }}" 
                icon="users" 
                variant="primary" />

            <x-dashboard.card.stat 
                title="{{ __('dashboard.stats.present') }}" 
                value="{{ $presentToday }}" 
                icon="user-check" 
                variant="success" />

            <x-dashboard.card.stat 
                title="{{ __('dashboard.stats.on_leave') }}" 
                value="{{ $onLeave }}" 
                icon="plane-takeoff" 
                variant="warning" />

            <x-dashboard.card.stat 
                title="{{ __('dashboard.stats.late') }}" 
                value="{{ $lateToday }}" 
                icon="alarm-clock" 
                variant="error" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 card bg-base-100 border border-base-content/5 shadow-xl rounded-[2rem] overflow-hidden">
                <div class="card-body p-0">
                    <div class="p-8 flex justify-between items-center border-b border-base-content/5">
                        <h3 class="font-black text-xl tracking-tight">{{ __('dashboard.recent_attendance.title') }}</h3>
                        <a href="{{ route('attendances.index') }}" class="btn btn-ghost btn-sm rounded-xl text-primary font-bold">{{ __('dashboard.recent_attendance.view_all') }}</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr class="text-base-content/40 border-b border-base-content/5 uppercase text-[10px] font-black tracking-widest">
                                    <th class="px-8">{{ __('dashboard.recent_attendance.th_employee') }}</th>
                                    <th>{{ __('dashboard.recent_attendance.th_time') }}</th>
                                    <th>{{ __('dashboard.recent_attendance.th_status') }}</th>
                                    <th class="px-8">{{ __('dashboard.recent_attendance.th_location') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($recentAttendances as $attendance)
                                <tr class="hover:bg-primary/5 transition-colors border-b border-base-content/5">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-11 h-11 bg-primary/10">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($attendance->employee->user->name) }}&background=random&bold=true" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-black text-base-content">{{ $attendance->employee->user->name }}</div>
                                                <div class="text-[10px] opacity-40 font-bold uppercase">{{ $attendance->employee->position->name ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="font-mono text-xs font-bold">{{ $attendance->time_in->format('H:i:s') }}</td>
                                    <td>
                                        @if($attendance->is_late)
                                            <span class="badge badge-error badge-sm text-[9px] font-black">LATE</span>
                                        @else
                                            <span class="badge badge-success badge-sm text-[9px] font-black">ON TIME</span>
                                        @endif
                                    </td>
                                    <td class="text-xs font-medium opacity-60">{{ $attendance->location_name ?? 'Remote' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-20 opacity-30 font-bold italic">Belum ada aktivitas hari ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

           <div class="card bg-base-100 border border-base-content/5 shadow-xl rounded-[2rem]">
                <div class="card-body p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-black text-xl tracking-tight">{{ __('dashboard.absence_overview.title') ?? 'Who is Out' }}</h3>
                        <span class="badge badge-error badge-sm font-black">{{ $onLeave }}</span>
                    </div>

                    <div class="space-y-4">
                        @forelse($absentEmployees ?? [] as $absent)
                            <div class="flex items-center justify-between p-4 bg-base-200/30 rounded-[1.5rem] border border-base-content/5 group hover:border-primary/20 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle w-10 h-10">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($absent->user->name) }}&background=random&bold=true" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-xs font-black text-base-content">{{ $absent->user->name }}</div>
                                        <div class="text-[9px] opacity-40 font-bold uppercase">{{ $absent->department->name ?? 'Staff' }}</div>
                                    </div>
                                </div>
                                <div class="badge {{ $absent->status === 'leave' ? 'badge-warning' : 'badge-ghost' }} border-none text-[8px] font-black px-3 py-3 rounded-lg">
                                    {{ strtoupper($absent->status) }}
                                </div>
                            </div>
                        @empty
                            <div class="py-10 text-center border-2 border-dashed border-base-content/5 rounded-[1.5rem]">
                                <x-lucide-check-circle-2 class="size-8 mx-auto opacity-10 mb-2" />
                                <p class="text-[10px] font-bold opacity-20 uppercase tracking-widest">Full Team Today</p>
                            </div>
                        @endforelse
                    </div>

                    <a href="{{ route('attendances.index') }}" class="btn btn-outline btn-md w-full mt-8 rounded-2xl border-base-content/10 font-black uppercase text-xs tracking-widest group">
                        {{ __('dashboard.absence_overview.view_details') ?? 'View Attendance Details' }}
                        <x-lucide-arrow-right class="size-3 ml-2 group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.main>