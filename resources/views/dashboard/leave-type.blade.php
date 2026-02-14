<x-dashboard.main title="{{ __('leave-type.title') }}">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <x-dashboard.card.info 
            title="{{ __('leave-type.stats.total') }}" 
            value="{{ $leaveTypes->total() }}"
            icon="calendar-days" 
            variant="warning" /> <div onclick="add_leave_type_modal.showModal()" 
             class="cursor-pointer group bg-gradient-to-br from-warning to-orange-600 p-1 rounded-[2rem] shadow-xl shadow-warning/20 hover:scale-[1.02] active:scale-95 transition-all">
            <div class="bg-base-100 h-full w-full rounded-[1.9rem] flex items-center justify-between px-8 py-6">
                <div class="flex items-center gap-5">
                    <div class="p-4 bg-warning rounded-2xl text-warning-content shadow-lg group-hover:rotate-12 transition-transform">
                        <x-lucide-calendar-plus class="size-7" />
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-warning opacity-60">Policy Action</p>
                        <p class="text-xl font-black text-base-content tracking-tight">{{ __('leave-type.modal.add_title') }}</p>
                    </div>
                </div>
                <x-lucide-arrow-right class="size-6 text-warning opacity-0 group-hover:opacity-100 -translate-x-4 group-hover:translate-x-0 transition-all" />
            </div>
        </div>
    </div>

    <x-dashboard.card.table 
        title="{{ __('leave-type.title') }}"
        description="{{ __('leave-type.subtitle') }}" 
        tableId="leaveTypeTable"
        :headers="[
            __('leave-type.table.th_no'), 
            __('leave-type.table.th_name'), 
            __('leave-type.table.th_days'), 
            __('leave-type.table.th_action')
        ]" 
        :paginator="$leaveTypes" 
        searchAction="{{ route('leave-types.index') }}">

        @forelse ($leaveTypes as $i => $item)
            <tr class="group hover:bg-warning/5 transition-all border-b border-base-content/5">
                <td class="text-center font-bold opacity-20">{{ $leaveTypes->firstItem() + $i }}</td>
                <td class="font-black text-base-content">{{ $item->name }}</td>
                <td class="text-center">
                    <span class="px-4 py-2 bg-warning/10 text-warning rounded-xl font-mono font-black text-sm border border-warning/20">
                        {{ $item->quota }} {{ __('menu.days') ?? 'Hari' }}
                    </span>
                </td>
                <td class="flex items-center gap-3 justify-center py-6">
                    <button onclick="edit_leave_type_{{ $item->id }}.showModal()" class="p-2 hover:bg-info/10 text-info rounded-xl transition-all">
                        <x-lucide-edit-3 class="size-5" />
                    </button>
                    
                    <button onclick="delete_leave_type_{{ $item->id }}.showModal()" class="p-2 hover:bg-error/10 text-error rounded-xl transition-all">
                        <x-lucide-trash-2 class="size-5" />
                    </button>

                    <x-dashboard.modal.edit 
                        id="edit_leave_type_{{ $item->id }}" 
                        :action="route('leave-types.update', $item->id)"
                        title="{{ __('leave-type.modal.edit_title', ['name' => $item->name]) }}">
                        
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-bold">{{ __('leave-type.modal.label_name') }}</span></label>
                            <input type="text" name="name" value="{{ $item->name }}" class="input input-bordered w-full rounded-2xl bg-base-200/50 h-14 font-bold" required>
                        </div>
                        <div class="form-control w-full mt-4">
                            <label class="label"><span class="label-text font-bold">{{ __('leave-type.modal.label_days') }}</span></label>
                            <div class="relative">
                                <input type="number" name="quota" value="{{ $item->quota }}" class="input input-bordered w-full rounded-2xl bg-base-200/50 h-14 font-mono font-bold pr-16" min="1" required>
                                <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black opacity-30 uppercase">Hari</span>
                            </div>
                        </div>
                    </x-dashboard.modal.edit>

                    <x-dashboard.modal.delete 
                        id="delete_leave_type_{{ $item->id }}" 
                        :action="route('leave-types.destroy', $item->id)" 
                        :title="__('actions.named.delete', ['name' => $item->name])" />
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center py-20 italic opacity-20 font-bold">Belum ada tipe cuti yang terdaftar.</td></tr>
        @endforelse
    </x-dashboard.card.table>

    <x-dashboard.modal.add 
        id="add_leave_type_modal" 
        :action="route('leave-types.store')" 
        title="{{ __('leave-type.modal.add_title') }}">
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-bold opacity-70 italic">{{ __('leave-type.modal.label_name') }}</span></label>
            <label class="input input-bordered w-full flex items-center gap-4 bg-base-200/40 border-base-content/10 rounded-2xl h-16 px-6 focus-within:border-warning transition-all">
                <x-lucide-type class="size-5 opacity-30" />
                <input type="text" name="name" class="grow w-full font-bold bg-transparent border-none focus:ring-0" placeholder="{{ __('leave-type.modal.placeholder_name') }}" required>
            </label>
        </div>

        <div class="form-control w-full mt-6 text-left">
            <label class="label"><span class="label-text font-bold opacity-70 italic">{{ __('leave-type.modal.label_days') }}</span></label>
            <label class="input input-bordered w-full flex items-center gap-4 bg-base-200/40 border-base-content/10 rounded-2xl h-16 px-6 focus-within:border-warning transition-all">
                <x-lucide-calendar-range class="size-5 opacity-30" />
                <input type="number" name="quota" class="grow w-full font-mono font-bold bg-transparent border-none focus:ring-0" placeholder="12" min="1" required>
                <span class="font-black opacity-30 text-xs uppercase">Hari</span>
            </label>
        </div>
    </x-dashboard.modal.add>

</x-dashboard.main>