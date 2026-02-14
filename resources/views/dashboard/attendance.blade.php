<x-dashboard.main title="{{ __('attendances.title') }}">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-10">
        <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
            <x-dashboard.card.info
                title="{{ __('attendances.stats.present') }}"
                value="{{ $presentToday }}"
                icon="user-check"
                variant="success" />

            <x-dashboard.card.info
                title="{{ __('attendances.stats.late') }}"
                value="{{ $lateToday }}"
                icon="alarm-clock"
                variant="error" />

            <x-dashboard.card.info
                title="{{ __('attendances.stats.on_leave') }}"
                value="{{ $onLeave }}"
                icon="plane-takeoff"
                variant="warning" />
        </div>

        <div class="lg:col-span-4">
            <div class="bg-base-100 rounded-[2.5rem] p-6 border border-base-content/5 shadow-xl h-full flex flex-col justify-center overflow-hidden relative group">
                <div class="absolute -right-4 -top-4 size-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-all"></div>
                <form action="{{ route('attendances.index') }}" method="GET" class="relative z-10 space-y-4">
                    <div class="flex items-center gap-2 px-1">
                        <x-lucide-calendar-search class="size-4 text-primary" />
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40">{{ __('attendances.filter.label') }}</span>
                    </div>
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" class="input input-sm bg-base-200/50 border-none rounded-xl font-bold text-xs h-12 w-full focus:ring-2 ring-primary/20 transition-all shadow-inner" />
                    <button type="submit" class="btn btn-primary btn-sm w-full rounded-xl text-white font-black uppercase tracking-widest h-11 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        {{ __('attendances.filter.apply') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <x-dashboard.card.table
        title="{{ __('attendances.table.title') }}"
        description="{{ __('dashboard.subtitle') }}"
        tableId="attendanceTable"
        :headers="[
            __('attendances.table.th_employee'),
            __('attendances.table.th_shift'),
            __('attendances.table.th_time_in'),
            __('attendances.table.th_time_out'),
            __('attendances.table.th_status'),
            __('attendances.table.th_action')
        ]"
        :paginator="$attendances"
        searchAction="{{ route('attendances.index') }}">

        @forelse ($attendances as $item)
            <tr class="group/row hover:bg-primary/[0.02] transition-all border-b border-base-content/5">
                <td class="py-5 px-6">
                    <div class="flex items-center gap-4">
                        <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12 bg-primary/10 p-0.5">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->employee->user->name) }}&background=random&bold=true" />
                            </div>
                        </div>
                        <div>
                            <div class="font-black text-sm text-base-content group-hover/row:text-primary transition-colors">{{ $item->employee->user->name }}</div>
                            <div class="text-[9px] opacity-30 font-mono tracking-tighter">{{ $item->employee->employee_code }}</div>
                        </div>
                    </div>
                </td>

                <td class="text-center">
                    <div class="badge badge-ghost bg-base-200/50 border-none font-black text-[9px] uppercase tracking-widest py-3 px-4 rounded-xl">
                        {{ $item->shift->name }}
                    </div>
                </td>

                <td class="font-mono text-xs font-black text-center">
                    <div class="flex items-center gap-2 text-success bg-success/5 px-3 py-2 rounded-lg w-fit mx-auto">
                        <x-lucide-log-in class="size-3" />
                        {{ $item->time_in ? $item->time_in->format('H:i') : '--:--' }}
                    </div>
                </td>

                <td class="font-mono text-xs font-black text-center">
                    <div class="flex items-center gap-2 text-error bg-error/5 px-3 py-2 rounded-lg w-fit mx-auto">
                        <x-lucide-log-out class="size-3" />
                        {{ $item->time_out ? $item->time_out->format('H:i') : '--:--' }}
                    </div>
                </td>

                <td class="text-center">
                    <div class="badge {{ $item->status === 'late' ? 'badge-error' : 'badge-success' }} badge-md font-black text-[9px] uppercase tracking-widest py-3 px-5 shadow-sm text-white rounded-xl">
                        {{ __('attendances.status.' . $item->status) }}
                    </div>
                </td>

                <td class="px-6 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <button onclick="view_attendance_{{ $item->id }}.showModal()" class="p-2.5 hover:bg-primary/10 text-primary rounded-xl transition-all hover:scale-110 active:scale-90 shadow-sm border border-base-content/5">
                            <x-lucide-eye class="size-4" />
                        </button>
                    </div>

                    <x-dashboard.modal.detail :attendance="$item" />
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center py-32 italic opacity-20 font-black text-xs uppercase tracking-[0.2em]">{{ __('attendances.table.empty') }}</td></tr>
        @endforelse
    </x-dashboard.card.table>
</x-dashboard.main>
