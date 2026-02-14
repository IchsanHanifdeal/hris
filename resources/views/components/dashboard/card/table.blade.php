@props(['title', 'description', 'tableId', 'headers', 'paginator', 'searchAction'])

<div class="flex flex-col rounded-2xl w-full border border-base-content/5 bg-base-100 shadow-2xl overflow-hidden">
    <div class="p-6 border-b border-base-content/5 bg-base-200/50">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-xl font-bold text-base-content tracking-tight">{{ $title }}</h3>
                <p class="text-sm opacity-50">{{ $description }}</p>
            </div>
            
            @isset($searchAction)
                <form action="{{ $searchAction }}" method="GET" class="relative group w-full md:w-64">
                    <x-lucide-search class="absolute left-3 top-1/2 -translate-y-1/2 size-4 z-10 pointer-events-none opacity-30 group-focus-within:text-primary group-focus-within:opacity-100 transition-all" />
                    
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="{{ __('actions.search') }}..." 
                        class="input input-bordered input-sm w-full pl-10 bg-base-100 border-base-content/10 focus:border-primary focus:ring-0">
                </form>
            @endisset
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full" id="{{ $tableId }}">
            <thead>
                <tr class="bg-base-200/50 text-base-content/50 border-b border-base-content/5">
                    @foreach ($headers as $header)
                        <th class="uppercase text-[10px] font-black tracking-[0.1em] text-center py-4">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-sm font-medium">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if ($paginator->hasPages())
        <div class="p-4 border-t border-base-content/5 bg-base-200/30 flex justify-center">
            {{ $paginator->links() }}
        </div>
    @endif
</div>