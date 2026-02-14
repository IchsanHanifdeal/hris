<x-dashboard.main title="{{ __('schedules.title') }}">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <x-dashboard.card.info
                title="{{ __('schedules.stats.total') }}"
                value="{{ $total_scheduled }}"
                icon="calendar-check"
                variant="primary" />

            <x-dashboard.card.info
                title="{{ __('schedules.stats.active_shift') }}"
                value="{{ $active_shifts }}"
                icon="clock"
                variant="secondary" />
        </div>

        <div class="lg:col-span-4">
            <div class="bg-base-100 rounded-[2.5rem] p-6 border border-base-content/5 shadow-xl h-full flex flex-col justify-center relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 size-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-all"></div>
                <form action="{{ route('schedules.index') }}" method="GET" class="relative z-10 space-y-4">
                    <div class="flex items-center gap-2 px-1">
                        <x-lucide-calendar-range class="size-4 text-primary" />
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40">{{ __('schedules.filter.title') }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="date" name="start_date" value="{{ $date_range['start'] }}" class="input input-sm bg-base-200/50 border-none rounded-xl font-bold text-[10px] h-11 focus:ring-2 ring-primary/20 transition-all" />
                        <input type="date" name="end_date" value="{{ $date_range['end'] }}" class="input input-sm bg-base-200/50 border-none rounded-xl font-bold text-[10px] h-11 focus:ring-2 ring-primary/20 transition-all" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-full rounded-xl text-white font-black uppercase tracking-widest h-11 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        {{ __('schedules.filter.apply') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

   <div class="flex items-center justify-between mb-6 px-2">
        <div class="flex flex-col">
            <h2 class="text-2xl font-black tracking-tight text-base-content">{{ __('schedules.table.title') }}</h2>
            <p class="text-[10px] font-bold opacity-30 uppercase tracking-[0.2em]">{{ __('schedules.subtitle') }}</p>
        </div>

        <button onclick="add_schedule_modal.showModal()" class="btn btn-primary rounded-2xl px-6 gap-3 shadow-xl shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-1 active:scale-95 transition-all group">
            <div class="bg-white/20 p-1.5 rounded-lg group-hover:rotate-90 transition-transform">
                <x-lucide-calendar-plus class="size-4 text-white" />
            </div>
            <span class="font-black uppercase tracking-widest text-xs">{{ __('actions.add') }}</span>
        </button>
    </div>

    <x-dashboard.card.table
        title="{{ __('schedules.table.title') }}"
        description="Monthly Duty Roster Matrix"
        tableId="scheduleMatrixTable"
        :headers="array_merge(['Employee'], collect($daysInMonth)->map(fn($d) => $d->format('d'))->toArray())"
        :paginator="$employees"
    >
        @foreach ($employees as $emp)
            <tr class="hover:bg-primary/[0.02] border-b border-base-content/5 group/row">
                <td class="sticky left-0 bg-base-100 z-20 border-r border-base-content/5 py-4 min-w-[220px] shadow-[5px_0_10px_-5px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center gap-3 px-2">
                        <div class="avatar">
                            <div class="mask mask-squircle w-10 h-10 bg-gradient-to-tr from-primary/20 to-secondary/20 p-0.5">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($emp->user->name) }}&bold=true&background=random" />
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            <div class="font-black text-[11px] text-base-content truncate group-hover/row:text-primary transition-colors">{{ $emp->user->name }}</div>
                            <div class="text-[8px] opacity-30 font-mono tracking-tighter">{{ $emp->employee_code }}</div>
                        </div>
                    </div>
                </td>

                @foreach ($daysInMonth as $day)
                    @php
                        $dateStr = $day->format('Y-m-d');
                        $schedule = $emp->schedules->firstWhere('date', $dateStr);
                        $isWeekend = $day->isWeekend();
                        $isToday = $day->isToday();
                    @endphp
                    <td class="p-1 min-w-[55px] text-center {{ $isWeekend ? 'bg-base-200/20' : '' }} {{ $isToday ? 'ring-2 ring-inset ring-primary/20 bg-primary/5' : '' }}">
                        @if($schedule)
                            <button
                                onclick="openEditModal({
                                    id: '{{ $schedule->id }}',
                                    employee_id: '{{ $emp->id }}',
                                    shift_id: '{{ $schedule->shift_id }}',
                                    date: '{{ $dateStr }}',
                                    employee_name: '{{ addslashes($emp->user->name) }}'
                                })"
                                class="group relative w-full h-10 rounded-xl flex items-center justify-center transition-all hover:scale-110 active:scale-95 shadow-sm {{ str_contains(strtolower($schedule->shift->name), 'night') ? 'bg-slate-800 text-slate-100' : 'bg-primary/10 text-primary' }}"
                            >
                                <span class="text-[9px] font-black uppercase tracking-tighter">
                                    {{ substr($schedule->shift->name, 0, 1) }}
                                </span>

                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block z-50 bg-base-content text-base-100 text-[9px] font-bold py-1.5 px-3 rounded-lg whitespace-nowrap shadow-2xl animate-in fade-in zoom-in duration-200">
                                    {{ $schedule->shift->name }} ({{ substr($schedule->shift->start_time, 0, 5) }} - {{ substr($schedule->shift->end_time, 0, 5) }})
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-base-content"></div>
                                </div>
                            </button>
                        @else
                            <button
                                onclick="openAddModalWithDate('{{ $emp->id }}', '{{ $dateStr }}')"
                                class="w-full h-10 rounded-xl border-2 border-dashed border-base-content/5 hover:border-primary/30 hover:bg-primary/5 transition-all flex items-center justify-center opacity-10 hover:opacity-100 group/add"
                            >
                                <x-lucide-plus class="size-3 group-hover:rotate-90 transition-transform" />
                            </button>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </x-dashboard.card.table>

    <dialog id="add_schedule_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-base-100 rounded-[3rem] border border-base-content/5 shadow-2xl p-0 overflow-hidden max-w-2xl">
            <div class="bg-gradient-to-br from-primary to-primary-focus p-10 text-white relative">
                <div class="absolute right-0 top-0 size-48 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
                <div class="relative z-10">
                    <div class="size-16 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center mb-6 shadow-inner">
                        <x-lucide-calendar-range class="size-8" />
                    </div>
                    <h3 class="font-black text-3xl tracking-tight">{{ __('schedules.modal.add_title') }}</h3>
                    <p class="text-white/60 text-xs font-bold uppercase tracking-[0.2em] mt-2">Bulk assign rosters for employees</p>
                </div>
            </div>

            <form action="{{ route('schedules.store') }}" method="POST" class="p-10 space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="form-control col-span-2">
                        <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 tracking-widest">{{ __('schedules.modal.label_employee') }}</span></label>
                        <select name="employee_id" class="select select-bordered bg-base-200/50 border-none rounded-[1.5rem] h-16 font-black text-sm focus:ring-2 ring-primary/20 transition-all shadow-inner w-full px-6" required>
                            <option disabled selected>{{ __('schedules.modal.placeholder_employee') }}</option>
                            @foreach($allEmployees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->user->name }} ({{ $emp->employee_code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control col-span-2">
                        <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 tracking-widest">{{ __('schedules.modal.label_shift') }}</span></label><br>
                        <select name="shift_id" class="select select-bordered bg-base-200/50 border-none rounded-[1.5rem] h-16 font-black text-sm focus:ring-2 ring-primary/20 transition-all shadow-inner px-6 w-full" required>
                            <option disabled selected>{{ __('schedules.modal.placeholder_shift') }}</option>
                            @foreach($shifts as $shf)
                                <option value="{{ $shf->id }}">{{ $shf->name }} ({{ substr($shf->start_time, 0, 5) }} - {{ substr($shf->end_time, 0, 5) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 tracking-widest">Start Date</span></label>
                        <input type="date" name="start_date" value="{{ date('Y-m-d') }}" class="input input-bordered bg-base-200/50 border-none rounded-[1.5rem] h-16 font-black text-sm focus:ring-2 ring-primary/20 transition-all shadow-inner text-center" required />
                    </div>

                    <div class="form-control">
                        <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 tracking-widest">End Date</span></label>
                        <input type="date" name="end_date" value="{{ date('Y-m-d') }}" class="input input-bordered bg-base-200/50 border-none rounded-[1.5rem] h-16 font-black text-sm focus:ring-2 ring-primary/20 transition-all shadow-inner text-center" required />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-base-content/5">
                    <button type="button" onclick="add_schedule_modal.close()" class="btn btn-ghost flex-1 h-16 rounded-[1.5rem] font-black uppercase tracking-widest text-xs opacity-50">
                        {{ __('actions.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary flex-[2] h-16 rounded-[1.5rem] text-white font-black uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        <x-lucide-save class="size-5 mr-3" />
                        {{ __('schedules.modal.btn_save') }}
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop bg-base-content/40 backdrop-blur-md">
            <button>close</button>
        </form>
    </dialog>

    <dialog id="edit_schedule_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box bg-base-100 rounded-[3rem] border border-base-content/5 shadow-2xl p-0 overflow-hidden max-w-2xl">
        <div class="bg-gradient-to-br from-info to-blue-600 p-10 text-white relative">
            <div class="absolute right-0 top-0 size-48 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
            <div class="relative z-10">
                <div class="size-16 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center mb-6 shadow-inner">
                    <x-lucide-edit class="size-8" />
                </div>
                <h3 class="font-black text-3xl tracking-tight">Edit Roster</h3>
                <p id="edit_modal_subtitle" class="text-white/60 text-xs font-bold uppercase tracking-[0.2em] mt-2"></p>
            </div>
        </div>

        <form id="edit_schedule_form" method="POST" class="p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="form-control col-span-2">
                    <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">Karyawan</span></label>
                    <input type="text" id="edit_employee_name" class="input input-bordered bg-base-200/50 border-none rounded-[1.5rem] h-16 font-bold text-sm opacity-50" readonly />
                    <input type="hidden" name="employee_id" id="edit_employee_id" />
                </div>

                <div class="form-control">
                    <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">Tipe Shift</span></label>
                    <select name="shift_id" id="edit_shift_id" class="select select-bordered bg-base-200/50 border-none rounded-[1.5rem] h-16 font-bold text-sm" required>
                        @foreach($shifts as $shf)
                            <option value="{{ $shf->id }}">{{ $shf->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">Tanggal Tugas</span></label>
                    <input type="date" name="date" id="edit_date" class="input input-bordered bg-base-200/50 border-none rounded-[1.5rem] h-16 font-black text-sm text-center" required />
                </div>
            </div>

            <div class="flex gap-4 pt-6 border-t border-base-content/5">
                <button type="button" onclick="edit_schedule_modal.close()" class="btn btn-ghost flex-1 h-16 rounded-2xl font-black uppercase tracking-widest text-xs opacity-50">Cancel</button>
                <button type="submit" class="btn btn-info flex-[2] h-16 rounded-2xl text-white font-black uppercase tracking-widest shadow-xl shadow-info/20">
                    Update Schedule
                </button>
            </div>
        </form>
    </div>
</dialog>

<script>
    function openEditModal(data) {
        const form = document.getElementById('edit_schedule_form');
        form.action = `/dashboard/schedules/${data.id}`;

        document.getElementById('edit_modal_subtitle').innerText = `Adjusting schedule for ${data.employee_name}`;
        document.getElementById('edit_employee_name').value = data.employee_name;
        document.getElementById('edit_employee_id').value = data.employee_id;
        document.getElementById('edit_shift_id').value = data.shift_id;
        document.getElementById('edit_date').value = data.date;

        edit_schedule_modal.showModal();
    }
    function openAddModalWithDate(employeeId, date) {
        const form = document.querySelector('#add_schedule_modal form');
        form.reset();

        form.querySelector('select[name="employee_id"]').value = employeeId;
        form.querySelector('input[name="start_date"]').value = date;
        form.querySelector('input[name="end_date"]').value = date;

        add_schedule_modal.showModal();
    }

    function openEditModal(data) {
        const form = document.getElementById('edit_schedule_form');
        form.action = `/dashboard/schedules/${data.id}`;

        document.getElementById('edit_modal_subtitle').innerText = `Adjusting schedule for ${data.employee_name}`;
        document.getElementById('edit_employee_name').value = data.employee_name;
        document.getElementById('edit_employee_id').value = data.employee_id;
        document.getElementById('edit_shift_id').value = data.shift_id;
        document.getElementById('edit_date').value = data.date;

        edit_schedule_modal.showModal();
    }
</script>
</x-dashboard.main>
