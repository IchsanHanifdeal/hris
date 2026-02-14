@props(['id', 'action', 'title'])

<dialog id="{{ $id }}" class="modal modal-bottom sm:modal-middle transition-all duration-300">
    <div class="modal-box bg-base-100/90 backdrop-blur-2xl border border-primary/20 rounded-[2.5rem] p-8 shadow-2xl">
        
        <div class="flex items-center gap-4 mb-8">
            <div class="p-3 bg-primary/10 rounded-2xl text-primary shadow-inner">
                <x-lucide-edit-3 class="size-6" />
            </div>
            <div>
                <h3 class="font-black text-xl text-base-content tracking-tight">{{ $title }}</h3>
                <p class="text-[10px] font-bold opacity-30 uppercase tracking-widest">Update Information</p>
            </div>
        </div>

        <form action="{{ $action }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="min-h-[100px]">
                {{ $slot }}
            </div>

            <div class="modal-action border-t border-base-content/5 pt-6 flex gap-3">
                <button type="button" onclick="{{ $id }}.close()" class="btn btn-ghost flex-1 h-14 rounded-2xl font-bold hover:bg-base-200 transition-all">
                    {{ __('menu.cancel') ?? 'Batal' }}
                </button>
                <button type="submit" class="btn btn-primary flex-[2] h-14 rounded-2xl text-white shadow-xl shadow-primary/20 font-black uppercase tracking-widest hover:scale-[1.02] active:scale-95 transition-all">
                    <x-lucide-save class="size-5 mr-2" />
                    {{ __('actions.save') ?? 'Simpan' }}
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