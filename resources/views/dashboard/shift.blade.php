<x-dashboard.main title="{{ __('shift.title') }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        
        <!-- Header Section -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-base-content bg-gradient-to-r from-primary to-indigo-600 bg-clip-text text-transparent">
                    {{ __('shift.title') }}
                </h1>
                <p class="text-base-content/50 font-medium mt-2 text-sm md:text-base">
                    Kelola jam kerja operasional, shift harian, dan jadwal kerja standar untuk seluruh karyawan.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="add_shift_modal.showModal()" class="btn btn-primary h-14 rounded-2xl text-white shadow-xl shadow-primary/20 hover:scale-[1.01] active:scale-95 transition-all font-black uppercase tracking-wider text-xs gap-2 px-6">
                    <x-lucide-plus-circle class="size-5" />
                    Tambah Jadwal
                </button>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-base-100 rounded-[2rem] p-6 border border-base-content/5 shadow-xl flex items-center gap-5 transition-all duration-300 hover:shadow-primary/5">
                <div class="p-4 bg-primary/10 rounded-2xl text-primary shadow-inner">
                    <x-lucide-calendar-days class="size-7" />
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40">Total Jadwal</p>
                    <p class="text-3xl font-black text-base-content tracking-tight mt-1">{{ $shifts->total() }}</p>
                </div>
            </div>

            <div class="bg-base-100 rounded-[2rem] p-6 border border-base-content/5 shadow-xl flex items-center gap-5 transition-all duration-300 hover:shadow-secondary/5">
                <div class="p-4 bg-secondary/10 rounded-2xl text-secondary shadow-inner">
                    <x-lucide-clock class="size-7" />
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40">Sistem Shift</p>
                    <p class="text-lg font-black text-base-content tracking-tight mt-1">Full-Time & Custom</p>
                </div>
            </div>

            <div class="bg-base-100 rounded-[2rem] p-6 border border-base-content/5 shadow-xl flex items-center gap-5 transition-all duration-300 hover:shadow-accent/5">
                <div class="p-4 bg-accent/10 rounded-2xl text-accent shadow-inner">
                    <x-lucide-check-circle class="size-7" />
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40">Status Keaktifan</p>
                    <p class="text-lg font-black text-base-content tracking-tight mt-1">Aktif & Sinkron</p>
                </div>
            </div>
        </div>

        <!-- Main Schedules Table Card -->
        <div class="bg-base-100 rounded-[2rem] border border-base-content/5 shadow-2xl overflow-hidden">
            <div class="p-8 flex justify-between items-center border-b border-base-content/5">
                <div>
                    <h3 class="font-black text-xl tracking-tight text-base-content">Daftar Jadwal Kerja</h3>
                    <p class="text-[10px] font-bold opacity-30 uppercase tracking-[0.2em] mt-1">Operational Shift Logs</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="text-base-content/40 border-b border-base-content/5 uppercase text-[10px] font-black tracking-widest bg-base-200/30">
                            <th class="px-8 text-center">{{ __('shift.table.th_no') }}</th>
                            <th class="px-8 text-left">{{ __('shift.table.th_name') }}</th>
                            <th class="text-center">{{ __('shift.table.th_start') }}</th>
                            <th class="text-center">{{ __('shift.table.th_end') }}</th>
                            <th class="px-8 text-center">{{ __('shift.table.th_action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($shifts as $i => $item)
                            <tr class="group hover:bg-primary/5 transition-all border-b border-base-content/5">
                                <td class="text-center font-bold opacity-20 py-5">{{ $shifts->firstItem() + $i }}</td>
                                <td class="px-8 font-black text-base-content text-left">
                                    <div class="flex items-center gap-3">
                                        <div class="size-3 rounded-full bg-gradient-to-r from-primary to-indigo-500 shadow-sm shadow-primary/20"></div>
                                        <span>{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-2xl font-mono font-black text-xs border border-primary/15 shadow-sm">
                                        <x-lucide-log-in class="size-3.5 mr-1.5 opacity-70" />
                                        {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="inline-flex items-center px-4 py-2 bg-secondary/10 text-secondary rounded-2xl font-mono font-black text-xs border border-secondary/15 shadow-sm">
                                        <x-lucide-log-out class="size-3.5 mr-1.5 opacity-70" />
                                        {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
                                    </span>
                                </td>
                                <td class="px-8 flex items-center gap-3 justify-center py-5">
                                    <button onclick="edit_shift_{{ $item->id }}.showModal()" class="p-2 hover:bg-info/10 text-info rounded-xl transition-all hover:scale-105 active:scale-95">
                                        <x-lucide-edit-3 class="size-5" />
                                    </button>
                                    
                                    <button onclick="delete_shift_{{ $item->id }}.showModal()" class="p-2 hover:bg-error/10 text-error rounded-xl transition-all hover:scale-105 active:scale-95">
                                        <x-lucide-trash-2 class="size-5" />
                                    </button>

                                    <!-- Modal Edit Shift -->
                                    <x-dashboard.modal.edit 
                                        id="edit_shift_{{ $item->id }}" 
                                        :action="route('shifts.update', $item->id)"
                                        title="{{ __('shift.modal.edit_title') }}">
                                        
                                        <div class="form-control w-full">
                                            <label class="label"><span class="label-text font-black text-xs uppercase text-base-content/60 tracking-wider">Nama Jadwal Kerja</span></label>
                                            <label class="input input-bordered w-full flex items-center gap-4 bg-base-200/40 border-base-content/10 rounded-2xl h-14 px-6 focus-within:border-secondary transition-all">
                                                <x-lucide-list-todo class="size-5 opacity-30" />
                                                <input type="text" name="name" value="{{ $item->name }}" class="grow w-full font-bold bg-transparent border-none focus:ring-0" required>
                                            </label>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 mt-6 text-left">
                                            <div class="form-control">
                                                <label class="label"><span class="label-text font-black text-xs uppercase text-base-content/60 tracking-wider">Jam Masuk</span></label>
                                                <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}" class="input input-bordered rounded-2xl bg-base-200/40 h-14 font-mono font-bold text-primary focus:border-primary transition-all px-6" required>
                                            </div>
                                            <div class="form-control">
                                                <label class="label"><span class="label-text font-black text-xs uppercase text-base-content/60 tracking-wider">Jam Pulang</span></label>
                                                <input type="time" name="end_time" value="{{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}" class="input input-bordered rounded-2xl bg-base-200/40 h-14 font-mono font-bold text-secondary focus:border-secondary transition-all px-6" required>
                                            </div>
                                        </div>
                                    </x-dashboard.modal.edit>

                                    <!-- Modal Delete Shift -->
                                    <x-dashboard.modal.delete 
                                        id="delete_shift_{{ $item->id }}" 
                                        :action="route('shifts.destroy', $item->id)" 
                                        title="{{ __('actions.named.delete', ['name' => $item->name]) }}" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-20 italic opacity-30 font-black text-base-content/50">
                                    Belum ada data jadwal kerja terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($shifts->hasPages())
                <div class="p-6 border-t border-base-content/5 bg-base-200/10">
                    {{ $shifts->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Add Shift -->
    <x-dashboard.modal.add 
        id="add_shift_modal" 
        :action="route('shifts.store')" 
        title="{{ __('shift.modal.add_title') }}">
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-black text-xs uppercase text-base-content/60 tracking-wider">Nama Jadwal Kerja</span></label>
            <label class="input input-bordered w-full flex items-center gap-4 bg-base-200/40 border-base-content/10 rounded-2xl h-16 px-6 focus-within:border-secondary transition-all shadow-inner">
                <x-lucide-list-todo class="size-5 opacity-30" />
                <input type="text" name="name" class="grow w-full font-bold bg-transparent border-none focus:ring-0" placeholder="{{ __('shift.modal.placeholder_name') }}" required>
            </label>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 text-left">
            <div class="form-control w-full">
                <label class="label"><span class="label-text font-black text-xs uppercase text-base-content/60 tracking-wider">Jam Masuk</span></label>
                <input type="time" name="start_time" class="input input-bordered w-full rounded-2xl bg-base-200/40 h-16 px-6 font-mono font-bold text-primary focus:border-primary transition-all shadow-inner" required>
            </div>
            <div class="form-control w-full">
                <label class="label"><span class="label-text font-black text-xs uppercase text-base-content/60 tracking-wider">Jam Pulang</span></label>
                <input type="time" name="end_time" class="input input-bordered w-full rounded-2xl bg-base-200/40 h-16 px-6 font-mono font-bold text-secondary focus:border-secondary transition-all shadow-inner" required>
            </div>
        </div>
    </x-dashboard.modal.add>

</x-dashboard.main>