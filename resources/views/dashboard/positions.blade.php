<x-dashboard.main title="{{ __('position.title') }}">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        <x-dashboard.card.info 
            title="{{ __('position.stats.total') }}" 
            value="{{ $positions->total() }}"
            icon="shield-user" variant="primary" />
            
        <x-dashboard.card.info 
            title="{{ __('position.stats.avg_salary') }}" 
            value="Rp {{ number_format($positions->avg('basic_salary'), 0, ',', '.') }}"
            icon="banknote" variant="success" />

        <div onclick="add_position_modal.showModal()" class="cursor-pointer group bg-gradient-to-br from-primary to-secondary p-1 rounded-[2rem] shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
            <div class="bg-base-100 h-full w-full rounded-[1.9rem] flex items-center justify-between px-8">
                <span class="font-black text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary uppercase tracking-widest text-sm">
                    {{ __('position.modal.add_title') }}
                </span>
                <div class="p-3 bg-primary rounded-xl text-white shadow-lg group-hover:rotate-90 transition-transform">
                    <x-lucide-plus class="size-5" />
                </div>
            </div>
        </div>
    </div>

    <x-dashboard.card.table 
        title="{{ __('position.table.title') }}" 
        description="{{ __('position.subtitle') }}"
        tableId="posTable"
        :headers="[
            __('position.table.th_no'), 
            __('position.table.th_name'), 
            __('position.table.th_salary'), 
            __('position.table.th_action')
        ]" 
        :paginator="$positions"
        searchAction="{{ route('positions.index') }}">

        @forelse ($positions as $i => $item)
            <tr class="group hover:bg-base-200/50 transition-all">
                <td class="text-center font-bold opacity-20">{{ $positions->firstItem() + $i }}</td>
                <td class="font-black text-base-content">{{ $item->name }}</td>
                <td class="text-center">
                    <span class="px-4 py-2 bg-success/10 text-success rounded-xl font-mono font-black text-sm">
                        Rp {{ number_format($item->basic_salary, 0, ',', '.') }}
                    </span>
                </td>
                <td class="flex items-center gap-3 justify-center py-6">
                    <button onclick="edit_pos_{{ $item->id }}.showModal()" class="p-2 hover:bg-blue-500/10 text-blue-500 rounded-xl transition-all">
                        <x-lucide-edit-3 class="size-5" />
                    </button>
                    <button onclick="delete_pos_{{ $item->id }}.showModal()" class="p-2 hover:bg-error/10 text-error rounded-xl transition-all">
                        <x-lucide-trash-2 class="size-5" />
                    </button>

                    <x-dashboard.modal.edit 
                        id="edit_pos_{{ $item->id }}" 
                        :action="route('positions.update', $item->id)"
                        title="{{ __('position.modal.edit_title') }}">
                        
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-bold">{{ __('position.modal.label_name') }}</span></label>
                            <input type="text" name="name" value="{{ $item->name }}" class="input input-bordered w-full rounded-2xl bg-base-200/50" required>
                        </div>
                        <div class="form-control w-full mt-4">
                            <label class="label"><span class="label-text font-bold">{{ __('position.modal.label_salary') }}</span></label>
                            <input type="number" name="basic_salary" value="{{ (int)$item->basic_salary }}" class="input input-bordered w-full rounded-2xl bg-base-200/50" required>
                        </div>
                    </x-dashboard.modal.edit>

                    <x-dashboard.modal.delete 
                        id="delete_pos_{{ $item->id }}" 
                        :action="route('positions.destroy', $item->id)" 
                        :title="__('actions.named.delete', ['name' => $item->name])" />
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center py-20 italic opacity-20 font-bold">No records found.</td></tr>
        @endforelse
    </x-dashboard.card.table>

    <x-dashboard.modal.add id="add_position_modal" :action="route('positions.store')" title="{{ __('position.modal.add_title') }}">
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-bold">{{ __('position.modal.label_name') }}</span></label>
            <input type="text" name="name" class="input input-bordered w-full rounded-2xl bg-base-200/50" placeholder="{{ __('position.modal.placeholder_name') }}" required>
        </div>
        <div class="form-control w-full mt-4">
            <label class="label"><span class="label-text font-bold">{{ __('position.modal.label_salary') }}</span></label>
            <input type="number" name="basic_salary" class="input input-bordered w-full rounded-2xl bg-base-200/50" placeholder="0" required>
        </div>
    </x-pwa.modal-add>

</x-dashboard.main>