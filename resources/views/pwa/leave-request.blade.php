<x-pwa.main>
    <div class="flex flex-col h-full animate-in fade-in duration-700 select-none pb-32 overflow-x-hidden">
        
        <div class="px-6 pt-8 pb-6 bg-base-100/50 backdrop-blur-3xl sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ route('attendance.index') }}" class="size-10 rounded-2xl bg-base-200 flex items-center justify-center text-base-content active:scale-95 transition-all">
                    <x-lucide-chevron-left class="size-5" />
                </a>
                <h1 class="text-2xl font-black tracking-tight text-base-content">{{ __('pwa.leave.request') }}</h1>
            </div>
        </div>

        <div class="px-6 mt-4">
            <form id="leave-form" action="{{ route('leave-requests.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6" onsubmit="handleSubmit(this)">
                @csrf

                <div class="flex flex-col gap-2">
                    <div class="flex justify-between items-center ml-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-base-content/40">{{ __('pwa.leave.type') }}</label>
                        <div id="quota-badge" class="hidden px-3 py-1 rounded-full bg-primary/10 text-primary text-[8px] font-black uppercase tracking-widest border border-primary/20">
                            {{ __('pwa.leave.remaining') }}: <span id="quota-value">0</span> {{ __('pwa.leave.days') }}
                        </div>
                    </div>
                    <div class="relative">
                        <select name="leave_type_id" id="leave_type_id" onchange="checkQuota()" class="w-full h-14 bg-base-200/50 border border-white/5 rounded-2xl px-5 text-sm font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                            <option value="" disabled selected>-- {{ __('pwa.leave.type') }} --</option>
                            @foreach($leaveTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <x-lucide-chevron-down class="size-4 absolute right-5 top-1/2 -translate-y-1/2 opacity-20 pointer-events-none" />
                    </div>
                    @error('leave_type_id') <span class="text-[9px] text-error font-bold mt-1 ml-2">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-base-content/40 ml-2">{{ __('pwa.leave.start') }}</label>
                        <input type="date" name="start_date" id="start_date" onchange="validateDates()" value="{{ old('start_date') }}" class="w-full h-14 bg-base-200/50 border border-white/5 rounded-2xl px-5 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                        @error('start_date') <span class="text-[9px] text-error font-bold mt-1 ml-2">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-base-content/40 ml-2">{{ __('pwa.leave.end') }}</label>
                        <input type="date" name="end_date" id="end_date" onchange="validateDates()" value="{{ old('end_date') }}" class="w-full h-14 bg-base-200/50 border border-white/5 rounded-2xl px-5 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                        @error('end_date') <span class="text-[9px] text-error font-bold mt-1 ml-2">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-base-content/40 ml-2">{{ __('pwa.leave.reason') }}</label>
                    <textarea name="reason" placeholder="{{ __('pwa.leave.reason_placeholder') }}" class="w-full h-32 bg-base-200/50 border border-white/5 rounded-[2rem] p-5 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all resize-none">{{ old('reason') }}</textarea>
                    @error('reason') <span class="text-[9px] text-error font-bold mt-1 ml-2">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-base-content/40 ml-2">{{ __('pwa.leave.attachment') }}</label>
                    <div class="relative group">
                        <input type="file" name="attachment" id="attachment" class="hidden" onchange="updateFileName(this)">
                        <label for="attachment" class="flex items-center gap-4 w-full h-16 bg-base-200/50 border border-dashed border-white/10 rounded-2xl px-5 cursor-pointer group-hover:bg-base-200 transition-all">
                            <div class="size-10 rounded-xl bg-base-100 flex items-center justify-center shadow-sm">
                                <x-lucide-paperclip class="size-4 opacity-40 group-hover:rotate-12 transition-all" />
                            </div>
                            <span id="file-name" class="text-xs font-bold text-base-content/10 italic">{{ __('pwa.leave.attachment_placeholder') }}</span>
                        </label>
                    </div>
                    @error('attachment') <span class="text-[9px] text-error font-bold mt-1 ml-2">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4 pb-10">
                    <button type="submit" id="btn-submit" class="group relative w-full h-16 bg-primary text-white rounded-[1.8rem] font-black uppercase tracking-[0.2em] shadow-[0_20px_40px_rgba(var(--p),0.3)] active:scale-95 transition-all overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10 flex items-center justify-center gap-3">
                            <div id="btn-loader" class="hidden loading loading-spinner loading-xs mr-2"></div>
                            <x-lucide-send id="btn-icon" class="size-5 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
                            <span>{{ __('pwa.leave.submit') }}</span>
                        </div>
                    </button>
                    <p class="text-[9px] text-center font-bold text-base-content/20 uppercase tracking-widest mt-6 line-clamp-1">
                        {{ __('pwa.leave.note') }}
                    </p>
                </div>

            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentQuota = 0;
        const translations = {
            quota_insufficient: "{{ __('pwa.leave.quota_insufficient') }}",
            quota_msg: "{{ __('pwa.leave.quota_msg', ['days' => ':days', 'quota' => ':quota']) }}",
            attachment_placeholder: "{{ __('pwa.leave.attachment_placeholder') }}"
        };

        function updateFileName(input) {
            const fileName = input.files[0] ? input.files[0].name : translations.attachment_placeholder;
            const el = document.getElementById('file-name');
            el.innerText = fileName;
            el.classList.replace('text-base-content/10', 'text-primary');
        }

        async function checkQuota() {
            const typeId = document.getElementById('leave_type_id').value;
            if (!typeId) return;

            try {
                const response = await fetch(`/leave-requests/quota/${typeId}`);
                const data = await response.json();
                currentQuota = data.quota;
                
                const badge = document.getElementById('quota-badge');
                const val = document.getElementById('quota-value');
                val.innerText = currentQuota;
                badge.classList.remove('hidden');
                
                validateDates();
            } catch (err) {
                console.error("Failed to fetch quota:", err);
            }
        }

        function validateDates() {
            const startStr = document.getElementById('start_date').value;
            const endStr = document.getElementById('end_date').value;
            
            if (startStr && endStr) {
                const start = new Date(startStr);
                const end = new Date(endStr);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                if (diffDays > currentQuota && currentQuota > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: translations.quota_insufficient,
                        text: translations.quota_msg.replace(':days', diffDays).replace(':quota', currentQuota),
                        background: '#1a1a1a',
                        color: '#fff',
                        customClass: { popup: 'rounded-3xl' }
                    });
                    document.getElementById('end_date').value = '';
                }
            }
        }

        function handleSubmit(form) {
            const btn = document.getElementById('btn-submit');
            const loader = document.getElementById('btn-loader');
            const icon = document.getElementById('btn-icon');
            
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            loader.classList.remove('hidden');
            icon.classList.add('hidden');
        }
    </script>
</x-pwa.main>