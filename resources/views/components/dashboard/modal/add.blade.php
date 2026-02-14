@props(['id', 'action', 'title'])

<dialog id="{{ $id }}" class="modal modal-bottom sm:modal-middle transition-all duration-500">
    <div class="modal-box bg-base-100/90 backdrop-blur-2xl border border-primary/20 shadow-2xl rounded-[2.5rem] p-8 sm:p-10 relative overflow-hidden">
        
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>

        <div class="flex items-center gap-4 mb-10">
            <div class="p-4 bg-primary/10 rounded-2xl text-primary shadow-inner">
                <x-lucide-plus-circle class="size-8" />
            </div>
            <div>
                <h3 class="font-black text-2xl text-base-content tracking-tight">{{ $title }}</h3>
                <p class="text-[10px] font-bold opacity-30 uppercase tracking-widest mt-1">Create New Record</p>
            </div>
        </div>

        <form action="{{ $action }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="min-h-[100px] w-full">
                {{ $slot }}
            </div>

            <div class="modal-action pt-8 border-t border-base-content/5 flex flex-col sm:flex-row gap-3">
                <button type="button" onclick="{{ $id }}.close()" 
                        class="btn btn-ghost flex-1 h-14 rounded-2xl font-bold hover:bg-base-200 transition-all order-2 sm:order-1">
                    {{ __('menu.cancel') ?? 'Batal' }}
                </button>
                <button type="submit" 
                        class="btn btn-primary flex-[2] h-14 rounded-2xl text-white shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all font-black uppercase tracking-widest order-1 sm:order-2">
                    <x-lucide-save class="size-5 mr-2" />
                    {{ __('actions.save') ?? 'Simpan Data' }}
                </button>
            </div>
        </form>

        <form method="dialog" class="absolute right-6 top-6">
            <button class="btn btn-sm btn-circle btn-ghost opacity-30 hover:opacity-100">
                <x-lucide-x class="w-4 h-4" />
            </button>
        </form>
    </div>
    
    <form method="dialog" class="modal-backdrop bg-base-900/60 backdrop-blur-md transition-all duration-500">
        <button>close</button>
    </form>
</dialog>