@props([
    'id',
    'action',
    'title' => __('actions.named.delete', ['name' => 'Data']),
    'message' => __('actions.delete_message')
])

<dialog id="{{ $id }}" class="modal modal-bottom sm:modal-middle transition-all duration-300">
    <div class="modal-box bg-base-100/80 backdrop-blur-2xl border border-error/20 rounded-[2rem] shadow-2xl p-8">

        <div class="flex flex-col items-center text-center space-y-4">
            <div class="w-20 h-20 rounded-3xl bg-error/10 flex items-center justify-center text-error mb-2 rotate-3 hover:rotate-0 transition-all duration-500 shadow-inner">
                <x-lucide-trash-2 class="w-10 h-10" />
            </div>

            <h3 class="font-black text-2xl text-base-content tracking-tight">
                {{ $title }}
            </h3>

            <p class="text-base-content/60 leading-relaxed max-w-xs text-sm">
                {{ $message }}
            </p>
        </div>

        <div class="modal-action grid grid-cols-2 gap-4 mt-8">
            <form method="dialog" class="w-full">
                <button class="btn btn-ghost w-full h-14 rounded-2xl border border-base-content/5 hover:bg-base-200 transition-all font-bold">
                    {{ __('menu.cancel') ?? 'Batal' }}
                </button>
            </form>

            <form method="POST" action="{{ $action }}" class="w-full">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error w-full h-14 rounded-2xl text-white shadow-xl shadow-error/20 hover:scale-[1.02] active:scale-95 transition-all font-black uppercase tracking-widest">
                    {{ __('actions.delete') ?? 'Hapus' }}
                </button>
            </form>
        </div>

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
