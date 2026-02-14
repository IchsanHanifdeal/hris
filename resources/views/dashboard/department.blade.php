<x-dashboard.main title="{{ __('department.title') }}">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <x-dashboard.card.info 
            title="{{ __('department.stats.total') }}" 
            value="{{ $departments->total() }}"
            icon="building-2" 
            variant="primary" />
            
        <button onclick="add_department_modal.showModal()" 
                class="flex items-center justify-between p-6 bg-primary/10 border border-primary/20 rounded-2xl shadow-xl hover:bg-primary/20 transition-all group">
            <div class="flex items-center">
                <div class="p-4 mr-5 bg-primary rounded-2xl text-white group-hover:scale-110 transition-transform shadow-lg shadow-primary/30">
                    <x-lucide-plus class="size-6" />
                </div>
                <div class="text-left">
                    <p class="text-xs font-bold uppercase tracking-widest text-primary opacity-70 mb-1">Action</p>
                    <p class="text-xl font-black text-primary tracking-tight">{{ __('department.modal.add_title') }}</p>
                </div>
            </div>
            <x-lucide-arrow-right class="size-6 text-primary opacity-0 group-hover:opacity-100 -translate-x-4 group-hover:translate-x-0 transition-all" />
        </button>
    </div>

    <x-dashboard.card.table 
        title="{{ __('department.table.title') }}"
        description="{{ __('department.subtitle') }}" 
        tableId="deptTable"
        :headers="[
            __('department.table.th_no'), 
            __('department.table.th_name'), 
            __('department.table.th_total_employee'), 
            __('department.table.th_action')
        ]" 
        :paginator="$departments" 
        searchAction="{{ route('departments.index') }}">

        @forelse ($departments as $i => $item)
            <tr class="hover:bg-primary/5 transition-colors border-b border-base-content/5">
                <td class="text-center opacity-50">{{ $departments->firstItem() + $i }}</td>
                <td class="font-bold text-base-content">{{ $item->name }}</td>
                <td class="text-center">
                    {{ $item->employees_count }} {{ __('employee.label_people') }}
                </td>
                <td class="flex items-center gap-2 justify-center">
                    <button onclick="edit_dept_{{ $item->id }}.showModal()" class="btn btn-square btn-ghost btn-xs text-info">
                        <x-lucide-edit-3 class="size-4" />
                    </button>
                    
                    <button onclick="delete_dept_{{ $item->id }}.showModal()" class="btn btn-square btn-ghost btn-xs text-error">
                        <x-lucide-trash-2 class="size-4" />
                    </button>

                    <x-dashboard.modal.delete 
                        id="delete_dept_{{ $item->id }}" 
                        :action="route('departments.destroy', $item->id)" 
                        :title="__('actions.named.delete', ['name' => $item->name])" 
                    />

                    <dialog id="edit_dept_{{ $item->id }}" class="modal">
                        <div class="modal-box bg-base-100 border border-base-content/10">
                            <h3 class="font-bold text-lg mb-6">{{ __('department.modal.edit_title') }}</h3>
                            <form action="{{ route('departments.update', $item->id) }}" method="POST" class="space-y-4 text-left">
                                @csrf @method('PUT')
                                <div class="form-control">
                                    <label class="label"><span class="label-text font-bold">{{ __('department.modal.label_name') }}</span></label>
                                    <input type="text" name="name" value="{{ $item->name }}" class="input input-bordered w-full focus:border-primary" required>
                                </div>
                                <div class="modal-action">
                                    <button type="button" onclick="edit_dept_{{ $item->id }}.close()" class="btn btn-ghost">{{ __('menu.cancel') }}</button>
                                    <button type="submit" class="btn btn-primary text-white">{{ __('department.modal.btn_save') }}</button>
                                </div>
                            </form>
                        </div>
                    </dialog>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center py-10 opacity-30 italic">{{ __('department.table.empty') }}</td></tr>
        @endforelse
    </x-dashboard.card.table>

<dialog id="add_department_modal" class="modal modal-bottom sm:modal-middle transition-all duration-500">
    <div class="modal-box bg-base-100 border border-primary/20 shadow-2xl rounded-[2rem] p-8">
        <h3 class="font-black text-2xl mb-8 text-primary tracking-tight">
            {{ __('department.modal.add_title') }}
        </h3>
        
        <form action="{{ route('departments.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="form-control w-full group">
                <label class="label px-1">
                    <span class="label-text font-bold text-base-content/70 group-focus-within:text-primary transition-colors italic">
                        {{ __('department.modal.label_name') }}
                    </span>
                </label>
                
                <label class="input input-bordered w-full flex items-center gap-4 bg-base-200/50 rounded-2xl h-16 px-6 focus-within:border-primary focus-within:ring-4 focus-within:ring-primary/10 transition-all">
                    <x-lucide-building class="size-5 opacity-30 group-focus-within:opacity-100 transition-opacity" />
                    
                    <input type="text" 
                           name="name" 
                           class="grow w-full font-bold bg-transparent border-none focus:ring-0 p-0" 
                           placeholder="{{ __('department.modal.placeholder_name') }}" 
                           required 
                           autofocus>
                </label>
            </div>

            <div class="modal-action border-t border-base-content/5 pt-6 flex gap-3">
                <button type="button" 
                        onclick="add_department_modal.close()" 
                        class="btn btn-ghost flex-1 h-14 rounded-2xl font-bold">
                    {{ __('menu.cancel') }}
                </button>
                
                <button type="submit" 
                        class="btn btn-primary flex-[2] h-14 rounded-2xl text-white shadow-xl shadow-primary/20 font-black uppercase tracking-widest transition-all hover:scale-[1.02] active:scale-95">
                    <x-lucide-save class="size-5 mr-2" />
                    {{ __('department.modal.btn_save') }}
                </button>
            </div>
        </form>
    </div>
    
    <form method="dialog" class="modal-backdrop bg-base-900/40 backdrop-blur-md">
        <button>close</button>
    </form>
</dialog>

</x-dashboard.main>