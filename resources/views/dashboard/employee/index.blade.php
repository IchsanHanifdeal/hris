<x-dashboard.main title="{{ __('employee.title') }}">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <x-dashboard.card.info 
            title="{{ __('employee.stats.latest') }}" 
            value="{{ $latest_employee->user->name ?? '-' }}"
            icon="user-plus" 
            variant="primary" />
            
        <x-dashboard.card.info 
            title="{{ __('employee.stats.total') }}" 
            value="{{ $total_employees }}" 
            icon="users" 
            variant="success" />

        <a href="{{ route('employees.create') }}" 
           class="group bg-gradient-to-br from-primary to-secondary p-1 rounded-[2rem] shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
            <div class="bg-base-100 h-full w-full rounded-[1.9rem] flex items-center justify-between px-8 py-6">
                <div class="flex items-center gap-5">
                    <div class="p-4 bg-primary rounded-2xl text-white shadow-lg group-hover:rotate-12 transition-transform">
                        <x-lucide-user-plus class="size-7" />
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-primary opacity-60">Admin Action</p>
                        <p class="text-xl font-black text-base-content tracking-tight">{{ __('employee.modal.add_title') }}</p>
                    </div>
                </div>
                <x-lucide-arrow-right class="size-6 text-primary opacity-0 group-hover:opacity-100 -translate-x-4 group-hover:translate-x-0 transition-all" />
            </div>
        </a>
    </div>

    <x-dashboard.card.table 
        title="{{ __('employee.table.title') }}"
        description="{{ __('employee.subtitle') }}" 
        tableId="employeeTable"
        :headers="[
            __('employee.table.th_no'), 
            __('employee.table.th_name'), 
            __('employee.table.th_position'), 
            __('employee.table.th_dept'), 
            __('employee.table.th_status'), 
            __('employee.table.th_action')
        ]" 
        :paginator="$employees" 
        searchAction="{{ route('employees.index') }}">

        @forelse ($employees as $i => $item)
            <tr class="group hover:bg-primary/5 transition-all border-b border-base-content/5">
                <td class="text-center font-bold opacity-20">{{ $employees->firstItem() + $i }}</td>
                <td>
                    <div class="flex items-center gap-4">
                        <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12 bg-primary/10 p-1">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=random&bold=true" class="rounded-xl" />
                            </div>
                        </div>
                        <div>
                            <div class="font-black text-base-content group-hover:text-primary transition-colors">{{ $item->user->name }}</div>
                            <div class="text-[10px] opacity-40 font-mono tracking-widest">{{ $item->employee_code }}</div>
                        </div>
                    </div>
                </td>
                <td class="font-bold text-sm text-base-content/60 text-center">{{ $item->position->name ?? '-' }}</td>
                <td class="font-bold text-sm text-base-content/60 text-center">{{ $item->department->name ?? '-' }}</td>
                <td class="text-center">
                    <div class="badge {{ $item->status === 'active' ? 'badge-success' : 'badge-error' }} badge-sm font-black text-[9px] uppercase tracking-widest py-3 px-4 shadow-sm">
                        {{ __('employee.status.' . ($item->status ?? 'inactive')) }}
                    </div>
                </td>
                <td class="flex items-center gap-3 justify-center py-6 text-center">
                    <a href="{{ route('employees.edit', $item->id) }}" class="p-2 hover:bg-info/10 text-info rounded-xl transition-all">
                        <x-lucide-edit-3 class="size-5" />
                    </a>
                    @if($item->user_id !== auth()->id())
                        <button onclick="delete_emp_{{ $item->id }}.showModal()" class="p-2 hover:bg-error/10 text-error rounded-xl transition-all">
                            <x-lucide-trash-2 class="size-5" />
                        </button>

                        <x-dashboard.modal.delete 
                            id="delete_emp_{{ $item->id }}" 
                            :action="route('employees.destroy', $item->id)" 
                            :title="__('actions.named.delete', ['name' => $item->user->name])"
                            :message="__('actions.delete_message')" />
                    @else
                        <div class="p-2 opacity-20 cursor-not-allowed" title="You cannot delete yourself">
                            <x-lucide-trash-2 class="size-5" />
                        </div>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center py-20 italic opacity-20 font-bold">Belum ada karyawan terdaftar.</td></tr>
        @endforelse
    </x-dashboard.card.table>
</x-dashboard.main>