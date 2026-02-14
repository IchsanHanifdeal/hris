<x-dashboard.main title="{{ __('shift.title') }}">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <x-dashboard.card.info 
            title="{{ __('shift.stats.total') }}" 
            value="{{ $shifts->total() }}"
            icon="clock" 
            variant="primary" />
            
        <div onclick="add_shift_modal.showModal()" 
             class="cursor-pointer group bg-gradient-to-br from-secondary to-indigo-600 p-1 rounded-[2rem] shadow-xl shadow-secondary/20 hover:scale-[1.02] active:scale-95 transition-all">
            <div class="bg-base-100 h-full w-full rounded-[1.9rem] flex items-center justify-between px-8 py-6">
                <div class="flex items-center gap-5">
                    <div class="p-4 bg-secondary rounded-2xl text-white shadow-lg group-hover:rotate-12 transition-transform">
                        <x-lucide-plus-circle class="size-7" />
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-secondary opacity-60">Quick Action</p>
                        <p class="text-xl font-black text-base-content tracking-tight">{{ __('shift.modal.add_title') }}</p>
                    </div>
                </div>
                <x-lucide-arrow-right class="size-6 text-secondary opacity-0 group-hover:opacity-100 -translate-x-4 group-hover:translate-x-0 transition-all" />
            </div>
        </div>
    </div>

    <x-dashboard.card.table 
        title="{{ __('shift.title') }}"
        description="{{ __('shift.subtitle') }}" 
        tableId="shiftTable"
        :headers="[
            __('shift.table.th_no'), 
            __('shift.table.th_name'), 
            __('shift.table.th_start'), 
            __('shift.table.th_end'), 
            __('shift.table.th_action')
        ]" 
        :paginator="$shifts" 
        searchAction="{{ route('shifts.index') }}">

        @forelse ($shifts as $i => $item)
            <tr class="group hover:bg-secondary/5 transition-all border-b border-base-content/5">
                <td class="text-center font-bold opacity-20">{{ $shifts->firstItem() + $i }}</td>
                <td class="font-black text-base-content text-left">{{ $item->name }}</td>
                <td class="text-center">
                    <span class="px-4 py-2 bg-primary/10 text-primary rounded-xl font-mono font-black text-sm">
                        {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}
                    </span>
                </td>
                <td class="text-center">
                    <span class="px-4 py-2 bg-secondary/10 text-secondary rounded-xl font-mono font-black text-sm">
                        {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
                    </span>
                </td>
                <td class="flex items-center gap-3 justify-center py-6">
                    <button onclick="edit_shift_{{ $item->id }}.showModal()" class="p-2 hover:bg-info/10 text-info rounded-xl transition-all">
                        <x-lucide-edit-3 class="size-5" />
                    </button>
                    
                    <button onclick="delete_shift_{{ $item->id }}.showModal()" class="p-2 hover:bg-error/10 text-error rounded-xl transition-all">
                        <x-lucide-trash-2 class="size-5" />
                    </button>

                    <x-dashboard.modal.edit 
                        id="edit_shift_{{ $item->id }}" 
                        :action="route('shifts.update', $item->id)"
                        title="{{ __('shift.modal.edit_title') }}">
                        
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-bold">{{ __('shift.modal.label_name') }}</span></label>
                            <input type="text" name="name" value="{{ $item->name }}" class="input input-bordered w-full rounded-2xl bg-base-200/50 h-14 font-bold" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4 text-left">
                            <div class="form-control">
                                <label class="label"><span class="label-text font-bold">{{ __('shift.modal.label_start') }}</span></label>
                                <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}" class="input input-bordered rounded-2xl bg-base-200/50 h-14 font-mono font-bold text-primary" required>
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text font-bold">{{ __('shift.modal.label_end') }}</span></label>
                                <input type="time" name="end_time" value="{{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}" class="input input-bordered rounded-2xl bg-base-200/50 h-14 font-mono font-bold text-secondary" required>
                            </div>
                        </div>
                    </x-dashboard.modal.edit>

                    <x-dashboard.modal.delete 
                        id="delete_shift_{{ $item->id }}" 
                        :action="route('shifts.destroy', $item->id)" 
                        title="{{ __('actions.named.delete', ['name' => $item->name]) }}" />
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center py-20 italic opacity-20 font-bold">No shift data found.</td></tr>
        @endforelse
    </x-dashboard.card.table>

    <x-dashboard.modal.add 
        id="add_shift_modal" 
        :action="route('shifts.store')" 
        title="{{ __('shift.modal.add_title') }}">
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-bold opacity-70">{{ __('shift.modal.label_name') }}</span></label>
            <label class="input input-bordered w-full flex items-center gap-4 bg-base-200/40 border-base-content/10 rounded-2xl h-16 px-6 focus-within:border-secondary transition-all">
                <x-lucide-list-todo class="size-5 opacity-30" />
                <input type="text" name="name" class="grow w-full font-bold bg-transparent border-none focus:ring-0" placeholder="{{ __('shift.modal.placeholder_name') }}" required>
            </label>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 text-left">
            <div class="form-control w-full">
                <label class="label"><span class="label-text font-bold opacity-70">{{ __('shift.modal.label_start') }}</span></label>
                <input type="time" name="start_time" class="input input-bordered w-full rounded-2xl bg-base-200/40 h-16 px-6 font-mono font-bold text-primary focus:border-primary transition-all" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text font-bold opacity-70">{{ __('shift.modal.label_end') }}</span></label>
                <input type="time" name="end_time" class="input input-bordered w-full rounded-2xl bg-base-200/40 h-16 px-6 font-mono font-bold text-secondary focus:border-secondary transition-all" required>
            </div>
        </div>
    </x-dashboard.modal.add>

</x-dashboard.main>