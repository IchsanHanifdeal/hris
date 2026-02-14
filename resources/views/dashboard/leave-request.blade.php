<x-dashboard.main title="{{ __('leave.title') }}">
    <div class="relative space-y-6 pb-12">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-dashboard.card.info title="{{ __('leave.stats.pending') }}" value="{{ $pendingCount }}" icon="clock" variant="warning" />
            <x-dashboard.card.info title="{{ __('leave.stats.approved') }}" value="{{ $approvedCount }}" icon="check-circle" variant="success" />
            <x-dashboard.card.info title="{{ __('leave.stats.total_types') }}" value="{{ $leaveTypesCount }}" icon="list" variant="primary" />
        </div>

        <x-dashboard.card.table
            title="{{ __('leave.title') }}"
            description="{{ __('leave.subtitle') }}"
            tableId="leaveTable"
            :headers="[
                __('leave.table.employee'),
                __('leave.table.type'),
                __('leave.table.duration'),
                __('leave.table.reason'),
                __('leave.table.status'),
                __('leave.table.action')
            ]"
            :paginator="$requests"
        >
            @forelse ($requests as $request)
                <tr class="group/row hover:bg-primary/[0.02] border-b border-base-content/5 transition-all">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <div class="mask mask-squircle size-9 bg-primary/10 p-0.5">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($request->employee->user->name) }}&background=random&bold=true" class="mask mask-squircle" />
                            </div>
                            <div>
                                <div class="font-black text-[11px] leading-none">{{ $request->employee->user->name }}</div>
                                <div class="text-[8px] font-bold opacity-30 uppercase mt-1 tracking-tighter">{{ $request->employee->employee_code }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="text-center">
                        <div class="badge badge-ghost border-none bg-base-200/50 font-black text-[8px] uppercase px-3 py-2.5 rounded-lg tracking-wider">
                            {{ $request->leaveType->name }}
                        </div>
                    </td>

                    <td class="text-[10px] font-bold font-mono text-center">
                        <span class="text-primary">{{ $request->start_date->format('d/m') }}</span>
                        <span class="opacity-20 mx-1">→</span>
                        <span class="text-secondary">{{ $request->end_date->format('d/m') }}</span>
                    </td>

                    <td class="max-w-[150px] text-center">
                        <p class="text-[10px] truncate opacity-50 font-medium italic">"{{ $request->reason }}"</p>
                    </td>

                    <td class="text-center">
                        <div class="badge {{ $request->status === 'pending' ? 'badge-warning' : ($request->status === 'approved' ? 'badge-success' : 'badge-error') }} border-none font-black text-[8px] uppercase px-3 py-2.5 rounded-lg text-white shadow-sm">
                            {{ $request->status }}
                        </div>
                    </td>

                    <td>
                        <div class="flex items-center gap-2">
                            @if($request->status === 'pending')
                                <form action="{{ route('leave-requests.status', [$request->id, 'approved']) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="p-2 bg-success/10 text-success hover:bg-success hover:text-white rounded-xl transition-all shadow-sm">
                                        <x-lucide-check class="size-3.5" />
                                    </button>
                                </form>

                                <button onclick="openRejectModal('{{ $request->id }}', '{{ $request->employee->user->name }}')"
                                        class="p-2 bg-error/10 text-error hover:bg-error hover:text-white rounded-xl transition-all shadow-sm">
                                    <x-lucide-x class="size-3.5" />
                                </button>
                            @else
                                <div class="size-8 flex items-center justify-center opacity-10">
                                    <x-lucide-lock class="size-3" />
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-16 italic opacity-20 font-black text-[10px] uppercase tracking-[0.2em]">{{ __('leave.table.empty') }}</td></tr>
            @endforelse
        </x-dashboard.card.table>
    </div>

    <dialog id="reject_modal" class="modal modal-bottom sm:modal-middle backdrop-blur-md">
        <div class="modal-box bg-base-100/80 backdrop-blur-3xl rounded-[2.5rem] border border-white/10 shadow-2xl p-0 overflow-hidden max-w-sm">
            <div class="bg-gradient-to-r from-error to-red-600 p-6 text-white">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                        <x-lucide-shield-alert class="size-5" />
                    </div>
                    <div>
                        <h3 class="font-black text-sm uppercase tracking-tight">{{ __('leave.modal.reject_title') }}</h3>
                        <p id="reject_target_name" class="text-[9px] font-bold opacity-70 uppercase tracking-widest mt-0.5"></p>
                    </div>
                </div>
            </div>

            <form id="reject_form" action="" method="POST" class="p-6 space-y-5">
                @csrf @method('PATCH')
                <div class="form-control">
                    <label class="label px-1">
                        <span class="label-text font-black text-[9px] uppercase opacity-40">{{ __('leave.modal.reject_note') }}</span>
                    </label>
                    <textarea name="rejection_note" required
                        class="textarea textarea-bordered bg-base-200/50 border-none rounded-2xl h-28 font-bold text-xs focus:ring-2 ring-error/20 transition-all p-4 resize-none"
                        placeholder="{{ __('leave.modal.reject_placeholder') }}"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="reject_modal.close()" class="btn btn-ghost rounded-xl font-black uppercase text-[10px] h-12">{{ __('leave.modal.btn_cancel') }}</button>
                    <button type="submit" class="btn btn-error rounded-xl text-white font-black uppercase text-[10px] h-12 shadow-lg shadow-error/20">
                        {{ __('leave.modal.btn_confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function openRejectModal(id, name) {
            const form = document.getElementById('reject_form');
            const nameDisplay = document.getElementById('reject_target_name');

            form.action = `/dashboard/leave-requests/${id}/rejected`;
            nameDisplay.innerText = name;

            document.getElementById('reject_modal').showModal();
        }
    </script>
</x-dashboard.main>
