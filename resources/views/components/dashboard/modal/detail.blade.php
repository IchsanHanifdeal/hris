@props(['attendance'])

<dialog id="view_attendance_{{ $attendance->id }}" class="modal modal-bottom sm:modal-middle">
    <div
        class="modal-box bg-base-100 rounded-[3rem] border border-base-content/5 shadow-2xl p-0 overflow-hidden max-w-4xl">
        <div class="bg-gradient-to-br from-primary to-primary-focus p-8 text-white relative">
            <div
                class="absolute right-0 top-0 size-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl">
            </div>
            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div
                        class="size-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-inner">
                        <x-lucide-map-pin class="size-7 text-white" />
                    </div>
                    <div>
                        <h3 class="font-black text-2xl tracking-tight">{{ __('attendances.modal.detail_title') }}</h3>
                        <p class="text-white/60 text-[10px] font-bold uppercase tracking-widest mt-1">
                            {{ $attendance->employee->user->name }} • {{ $attendance->date->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>
                <button onclick="view_attendance_{{ $attendance->id }}.close()"
                    class="btn btn-circle btn-ghost btn-sm text-white/50 hover:text-white">✕</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div class="h-80 lg:h-full min-h-[400px] relative bg-base-200">
                <div id="map_{{ $attendance->id }}" class="absolute inset-0 z-0"></div>
                {{-- Overlay Koordinat --}}
                <div
                    class="absolute bottom-4 left-4 z-10 bg-base-100/90 backdrop-blur-md p-3 rounded-xl border border-base-content/5 shadow-lg">
                    <p class="text-[8px] font-black uppercase opacity-40 tracking-tighter">
                        {{ __('attendances.modal.coordinates') }}</p>
                    <p class="text-[10px] font-mono font-bold">{{ $attendance->lat_in }}, {{ $attendance->long_in }}</p>
                </div>
            </div>

            <div class="p-8 space-y-8 overflow-y-auto max-h-[600px]">
                {{-- Foto Section --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <span
                            class="text-[10px] font-black uppercase opacity-40 tracking-widest">{{ __('attendances.modal.photo_in') }}</span>
                        <div
                            class="aspect-square rounded-[1.5rem] overflow-hidden border-2 border-base-content/5 shadow-inner bg-base-200">
                            @if($attendance->photo_in)
                                <img src="{{ asset('storage/' . $attendance->photo_in) }}"
                                    class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center italic opacity-20 text-[10px]">No
                                    Photo</div>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-2">
                        <span
                            class="text-[10px] font-black uppercase opacity-40 tracking-widest">{{ __('attendances.modal.photo_out') }}</span>
                        <div
                            class="aspect-square rounded-[1.5rem] overflow-hidden border-2 border-base-content/5 shadow-inner bg-base-200">
                            @if($attendance->photo_out)
                                <img src="{{ asset('storage/' . $attendance->photo_out) }}"
                                    class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center italic opacity-20 text-[10px]">No
                                    Photo</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="divider opacity-5"></div>

                {{-- Time Log --}}
                <div class="grid grid-cols-2 gap-6">
                    <div class="p-4 bg-success/5 rounded-2xl border border-success/10">
                        <div class="flex items-center gap-2 text-success mb-1">
                            <x-lucide-log-in class="size-3" />
                            <span
                                class="text-[9px] font-black uppercase tracking-widest">{{ __('attendances.table.th_time_in') }}</span>
                        </div>
                        <p class="text-xl font-black text-success">
                            {{ $attendance->time_in ? $attendance->time_in->format('H:i') : '--:--' }}</p>
                    </div>
                    <div class="p-4 bg-error/5 rounded-2xl border border-error/10">
                        <div class="flex items-center gap-2 text-error mb-1">
                            <x-lucide-log-out class="size-3" />
                            <span
                                class="text-[9px] font-black uppercase tracking-widest">{{ __('attendances.table.th_time_out') }}</span>
                        </div>
                        <p class="text-xl font-black text-error">
                            {{ $attendance->time_out ? $attendance->time_out->format('H:i') : '--:--' }}</p>
                    </div>
                </div>

                {{-- Shift Info --}}
                <div class="p-5 bg-base-200/50 rounded-2xl space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black opacity-30 uppercase">Shift</span>
                        <span class="badge badge-ghost font-bold text-[10px]">{{ $attendance->shift?->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black opacity-30 uppercase">Schedule Range</span>
                        <span class="text-[10px] font-mono font-bold">
                            {{ $attendance->shift ? substr($attendance->shift->start_time, 0, 5) : '-' }}
                            - {{ $attendance->shift ? substr($attendance->shift->end_time, 0, 5) : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('view_attendance_{{ $attendance->id }}');
            let mapInstance = null;

            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'open' && modal.open && !mapInstance) {
                        setTimeout(() => {
                            const lat = {{ $attendance->lat_in ?? -6.200000 }};
                            const lng = {{ $attendance->long_in ?? 106.816666 }};

                            mapInstance = L.map('map_{{ $attendance->id }}').setView([lat, lng], 15);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap'
                            }).addTo(mapInstance);

                            L.marker([lat, lng]).addTo(mapInstance)
                                .bindPopup('<b>{{ addslashes($attendance->employee->user->name) }}</b><br>Check-in Location')
                                .openPopup();

                            mapInstance.invalidateSize();
                        }, 400);
                    }
                });
            });

            observer.observe(modal, { attributes: true });
        })();
    </script>
</dialog>
