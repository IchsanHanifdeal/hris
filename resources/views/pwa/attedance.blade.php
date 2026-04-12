<x-pwa.main>
    <div class="flex flex-col h-full animate-in fade-in duration-700 select-none pb-60 overflow-x-hidden">

        <div class="px-6 pt-6 pb-4 flex justify-between items-start">
            <div class="flex flex-col">
                <div id="live-clock" class="text-4xl font-black tracking-tighter text-base-content tabular-nums">00:00:00</div>
                <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-base-content/30">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>
            <div id="status-badge" class="flex items-center gap-2 bg-base-200/50 px-3 py-1.5 rounded-full border border-white/5 opacity-0 transition-opacity duration-1000">
                <div id="status-dot" class="size-1.5 rounded-full bg-base-content/20 animate-pulse"></div>
                <span id="status-text" class="text-[9px] font-black uppercase tracking-widest text-base-content/40">{{ __('pwa.attendance.tracking_gps') }}</span>
            </div>
        </div>

        <div class="px-4 mb-8">
            <div id="map-container" class="relative h-[250px] w-full rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden bg-base-300 ring-1 ring-white/5">
                <div id="map" class="h-full w-full grayscale-[0.5] contrast-[1.1] brightness-[0.9]"></div>

                <div id="dist-float" class="absolute bottom-6 left-1/2 -translate-x-1/2 z-[900] bg-base-100/90 backdrop-blur-xl border border-white/10 px-5 py-2 rounded-full shadow-xl flex items-center gap-3 scale-95 opacity-0 transition-all duration-500">
                    <div id="dist-dot" class="size-2 rounded-full bg-primary animate-pulse"></div>
                    <span id="distance-text" class="text-[10px] font-black text-base-content uppercase tracking-widest">{{ __('pwa.attendance.calculating') }}</span>
                </div>

                <div id="map-loader" class="absolute inset-0 bg-base-200 flex items-center justify-center z-[1000]">
                    <span class="loading loading-spinner loading-md text-primary/30"></span>
                </div>

                <div class="absolute top-4 right-4 z-[900] flex flex-col gap-2">
                    <button onclick="recenterMap()" class="size-10 rounded-xl bg-base-100/80 backdrop-blur-xl flex items-center justify-center text-base-content shadow-lg active:scale-95 transition-all">
                        <x-lucide-crosshair class="size-5" />
                    </button>
                    <button onclick="toggleMapLayer()" class="size-10 rounded-xl bg-base-100/80 backdrop-blur-xl flex items-center justify-center text-base-content shadow-lg active:scale-95 transition-all">
                        <x-lucide-layers class="size-4 opacity-50" />
                    </button>
                </div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="px-6 grid grid-cols-1 gap-4 mb-3">
            <div class="flex flex-col items-center justify-center p-4 bg-base-200/40 rounded-3xl border border-white/5">
                <span class="text-2xl font-black text-primary">{{ $stats['month'] ?? \Carbon\Carbon::now()->translatedFormat('F') }}</span>
                <span class="text-[8px] font-black uppercase tracking-widest text-base-content/30">{{ __('pwa.attendance.current_cycle') }}</span>
            </div>
        </div>
        <div class="px-6 grid grid-cols-2 gap-4 mb-8">
            <div class="flex flex-col items-center justify-center p-4 bg-base-200/40 rounded-3xl border border-white/5">
                <span class="text-2xl font-black text-base-content">{{ $stats['present'] ?? 0 }}</span>
                <span class="text-[8px] font-black uppercase tracking-widest text-base-content/30">{{ __('pwa.attendance.days_present') }}</span>
            </div>
            <div class="flex flex-col items-center justify-center p-4 bg-base-200/40 rounded-3xl border border-white/5">
                <span class="text-2xl font-black text-warning">{{ $stats['late'] ?? 0 }}</span>
                <span class="text-[8px] font-black uppercase tracking-widest text-base-content/30">{{ __('pwa.attendance.late_arrivals') }}</span>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="px-6 flex flex-col gap-4">
            <div class="flex justify-between items-center px-2">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-base-content/40">{{ __('pwa.attendance.recent_activities') }}</h3>
                <a href="{{ route('attendance.mywork') }}" class="text-[10px] font-bold text-primary uppercase tracking-widest">{{ __('pwa.attendance.history') }}</a>
            </div>

            <div class="flex flex-col gap-2">
                @forelse($history as $item)
                    @if($item->time_in)
                    <div class="flex items-center justify-between p-4 bg-base-200/30 rounded-2xl border border-white/5">
                        <div class="flex items-center gap-4">
                            <div class="size-10 rounded-full bg-success/10 flex items-center justify-center">
                                <x-lucide-log-in class="size-4 text-success" />
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-black uppercase tracking-tight">{{ __('pwa.clock_in') }}</span>
                                <span class="text-[9px] font-bold text-base-content/30 lowercase">{{ $item->date->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                        <span class="text-lg font-black tabular-nums">{{ \Carbon\Carbon::parse($item->time_in)->format('H:i') }}</span>
                    </div>
                    @endif
                    @if($item->time_out)
                    <div class="flex items-center justify-between p-4 bg-base-200/30 rounded-2xl border border-white/5">
                        <div class="flex items-center gap-4">
                            <div class="size-10 rounded-full bg-error/10 flex items-center justify-center">
                                <x-lucide-log-out class="size-4 text-error" />
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-black uppercase tracking-tight">{{ __('pwa.clock_out') }}</span>
                                <span class="text-[9px] font-bold text-base-content/30 lowercase">{{ $item->date->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                        <span class="text-lg font-black tabular-nums">{{ \Carbon\Carbon::parse($item->time_out)->format('H:i') }}</span>
                    </div>
                    @endif
                @empty
                    <div class="py-10 flex flex-col items-center justify-center opacity-20 gap-3">
                        <x-lucide-calendar class="size-10 stroke-[1.5]" />
                        <span class="text-[10px] font-bold uppercase tracking-widest">{{ __('pwa.attendance.no_logs') }}</span>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="fixed bottom-24 left-0 right-0 px-6 z-[2000] pointer-events-none max-w-md mx-auto">
            <div class="bg-base-100/60 backdrop-blur-3xl border border-white/10 rounded-[2.5rem] p-3 shadow-[0_20px_50px_rgba(0,0,0,0.5)] pointer-events-auto">
                <button id="btn-attendance" onclick="submitAttendance(this)"
                        class="group relative w-full h-16 rounded-[1.8rem] bg-base-300 border border-white/5 flex items-center justify-between px-6 overflow-hidden transition-all duration-300 active:scale-[0.98]">

                    <div id="btn-color" class="absolute inset-0 bg-primary opacity-0 transition-opacity duration-500"></div>

                    <div class="flex items-center gap-4 relative z-10">
                        <div class="size-10 rounded-xl bg-base-100/50 flex items-center justify-center shadow-inner">
                            <x-lucide-fingerprint id="btn-icon" class="size-5 text-base-content/20 transition-all duration-500" />
                        </div>
                        <div class="flex flex-col items-start">
                            <span id="btn-title" class="text-xs font-black uppercase tracking-tight text-base-content/80">{{ __('pwa.attendance.take') }}</span>
                            <span id="btn-tip" class="text-[9px] font-bold uppercase tracking-widest text-base-content/20 transition-all duration-500">{{ __('pwa.attendance.move_range') }}</span>
                        </div>
                    </div>

                    <div class="relative z-10 flex items-center gap-3">
                         <div id="btn-status-dot" class="size-1.5 rounded-full bg-base-content/20 animate-pulse"></div>
                         <x-lucide-chevron-right class="size-4 opacity-20 group-hover:translate-x-1 transition-transform" />
                    </div>

                    <div id="btn-loader-bar" class="absolute bottom-0 left-0 h-1 bg-white/30 w-0 transition-all duration-300"></div>
                </button>
            </div>
        </div>
    </div>

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let map, marker, officeCircle;
        let userPos = { lat: null, lng: null, accuracy: null };
        let isInside = false;
        let currentLayer = 'standard';

        const officeSettings = {
            latitude: {{ $setting->latitude ?? '0' }},
            longitude: {{ $setting->longitude ?? '0' }},
            radius: {{ $setting->radius ?? '100' }}
        };

        const translations = {
            matched: "{{ __('pwa.attendance.matched') }}",
            authorized_area: "{{ __('pwa.attendance.authorized_area') }}",
            tap_confirm: "{{ __('pwa.attendance.tap_confirm') }}",
            move_range: "{{ __('pwa.attendance.move_range') }}",
            tracking_gps: "{{ __('pwa.attendance.tracking_gps') }}",
            confirmed: "{{ __('pwa.attendance.confirmed') }}",
            error: "{{ __('pwa.error.failed') }}",
            calculating: "{{ __('pwa.attendance.calculating') }}",
            face_verification: "{{ __('pwa.face_verification') }}",
            submit_absensi: "{{ __('pwa.submit_absensi') }}",
            cancel: "{{ __('pwa.cancel') }}"
        };

        function updateClock() {
            const now = new Date();
            const timeString = now.getHours().toString().padStart(2, '0') + ':' +
                             now.getMinutes().toString().padStart(2, '0') + ':' +
                             now.getSeconds().toString().padStart(2, '0');
            const el = document.getElementById('live-clock');
            if(el) el.innerText = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3;
            const φ1 = lat1 * Math.PI/180;
            const φ2 = lat2 * Math.PI/180;
            const Δφ = (lat2-lat1) * Math.PI/180;
            const Δλ = (lon2-lon1) * Math.PI/180;
            const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) + Math.cos(φ1) * Math.cos(φ2) * Math.sin(Δλ/2) * Math.sin(Δλ/2);
            return (R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)));
        }

        function updateUI(distance) {
            const distFloat = document.getElementById('dist-float');
            const distText = document.getElementById('distance-text');
            const badge = document.getElementById('status-badge');
            const dot = document.getElementById('status-dot');
            const statusText = document.getElementById('status-text');

            const btnColor = document.getElementById('btn-color');
            const btnIcon = document.getElementById('btn-icon');
            const btnTip = document.getElementById('btn-tip');
            const btnStatusDot = document.getElementById('btn-status-dot');
            const btnTitle = document.getElementById('btn-title');

            if(distFloat) distFloat.classList.remove('opacity-0', 'scale-95');
            if(badge) badge.classList.remove('opacity-0');

            if (distance <= officeSettings.radius) {
                isInside = true;
                if(distText) distText.innerText = `${translations.matched} — ${Math.round(distance)}M`;
                if(statusText) {
                    statusText.innerText = translations.authorized_area;
                    statusText.className = "text-[9px] font-black uppercase tracking-widest text-success";
                }
                if(dot) dot.className = "size-1.5 rounded-full bg-success animate-ping";

                // Active Pulse State
                if(btnColor) btnColor.classList.replace('opacity-0', 'opacity-100');
                if(btnIcon) btnIcon.classList.replace('text-base-content/20', 'text-white');
                if(btnStatusDot) btnStatusDot.className = "size-1.5 rounded-full bg-white animate-ping";
                if(btnTip) {
                    btnTip.innerText = translations.tap_confirm;
                    btnTip.className = "text-[9px] font-bold uppercase tracking-widest text-white/60 animate-pulse";
                }
                if(btnTitle) btnTitle.classList.replace('text-base-content/80', 'text-white');
            } else {
                isInside = false;
                if(distText) distText.innerText = `${Math.round(distance)}M Range`;
                if(statusText) {
                    statusText.innerText = translations.tracking_gps;
                    statusText.className = "text-[9px] font-black uppercase tracking-widest text-base-content/40";
                }
                if(dot) dot.className = "size-1.5 rounded-full bg-base-content/20 animate-pulse";

                // Inactive State
                if(btnColor) btnColor.classList.replace('opacity-100', 'opacity-0');
                if(btnIcon) btnIcon.classList.replace('text-white', 'text-base-content/20');
                if(btnStatusDot) btnStatusDot.className = "size-1.5 rounded-full bg-base-content/20 animate-pulse";
                if(btnTip) {
                    btnTip.innerText = translations.move_range;
                    btnTip.className = "text-[9px] font-bold uppercase tracking-widest text-base-content/20";
                }
                if(btnTitle) btnTitle.classList.replace('text-white', 'text-base-content/80');
            }
        }

        function initializeGeolocation() {
            const loader = document.getElementById('map-loader');
            map = L.map('map', { zoomControl: false, attributionControl: false }).setView([officeSettings.latitude || -6.2, officeSettings.longitude || 106.81], 13);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png').addTo(map);

            if(officeSettings.latitude && officeSettings.longitude) {
                officeCircle = L.circle([officeSettings.latitude, officeSettings.longitude], {
                    color: '#6366f1', weight: 1, fillColor: '#6366f1', fillOpacity: 0.05, radius: officeSettings.radius
                }).addTo(map);
            }

            if ("geolocation" in navigator) {
                navigator.geolocation.watchPosition((position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    userPos = { lat, lng, accuracy: position.coords.accuracy };

                    if (loader) {
                        loader.style.opacity = '0';
                        setTimeout(() => loader.remove(), 700);
                        map.flyTo([lat, lng], 17, { duration: 2 });
                    }

                    if (marker) { marker.setLatLng([lat, lng]); }
                    else {
                        const icon = L.divIcon({
                            className: 'custom-icon',
                            html: `<div class='relative flex items-center justify-center'><div class='absolute w-8 h-8 bg-primary/20 rounded-full animate-ping'></div><div class='size-3 bg-primary rounded-full border-2 border-white shadow-xl'></div></div>`,
                            iconSize: [32, 32], iconAnchor: [16, 16]
                        });
                        marker = L.marker([lat, lng], {icon}).addTo(map);
                    }

                    updateUI(calculateDistance(lat, lng, officeSettings.latitude, officeSettings.longitude));

                }, null, { enableHighAccuracy: true });
            }
        }

        async function submitAttendance(btn) {
            if (!userPos.lat || !isInside) return;

            const icon = document.getElementById('btn-icon');
            const loaderBar = document.getElementById('btn-loader-bar');

            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: 480, height: 480 } });

                const { value: confirmed } = await Swal.fire({
                    title: `<span class="text-xs font-black uppercase tracking-[0.2em] opacity-40">${translations.face_verification}</span>`,
                    html: `
                        <div class="relative w-full aspect-square bg-base-300 rounded-[2.5rem] overflow-hidden border border-white/5 shadow-2xl mt-4">
                            <video id="webcam" autoplay playsinline class="w-full h-full object-cover grayscale-[0.2] contrast-[1.1]"></video>
                            <div class="absolute inset-0 border-[1.5rem] border-base-100/10 pointer-events-none ring-1 ring-inset ring-white/10"></div>
                            <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
                                <svg class="size-40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5">
                                    <path d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: translations.submit_absensi,
                    cancelButtonText: translations.cancel,
                    background: '#121212',
                    color: '#fff',
                    padding: '2rem',
                    customClass: {
                        popup: 'rounded-[3rem] border border-white/5',
                        confirmButton: 'btn btn-primary rounded-2xl px-10 h-14 font-black uppercase tracking-widest border-none',
                        cancelButton: 'btn btn-ghost rounded-2xl px-8 h-14 font-black uppercase tracking-widest opacity-40'
                    },
                    didOpen: () => {
                        const video = document.getElementById('webcam');
                        video.srcObject = stream;
                    },
                    willClose: () => {
                        stream.getTracks().forEach(track => track.stop());
                    }
                });

                if (!confirmed) return;

                // 2. Capture Image from Video
                const canvas = document.createElement('canvas');
                const video = document.getElementById('webcam');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                const imageData = canvas.toDataURL('image/png');

                // 3. Process Submission
                btn.disabled = true;
                if(icon) icon.classList.add('animate-bounce');
                if(loaderBar) loaderBar.style.width = '100%';

                const response = await fetch('{{ route('attendance.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: userPos.lat,
                        longitude: userPos.lng,
                        accuracy: userPos.accuracy,
                        image: imageData
                    })
                });

                const data = await response.json();
                if (!response.ok) throw new Error(data.message);

                Swal.fire({
                    icon: 'success',
                    title: translations.confirmed,
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000,
                    background: '#1a1a1a',
                    color: '#fff',
                    customClass: { popup: 'rounded-3xl' }
                }).then(() => {
                    window.location.reload();
                });

            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Absen',
                    text: error.message,
                    background: '#1a1a1a',
                    color: '#fff',
                    customClass: { popup: 'rounded-3xl' }
                });
                btn.disabled = false;
                if(icon) icon.classList.remove('animate-bounce');
                if(loaderBar) loaderBar.style.width = '0%';
            }
        }

        function recenterMap() { if (userPos.lat) map.flyTo([userPos.lat, userPos.lng], 18); }
        function toggleMapLayer() {
            if (currentLayer === 'standard') {
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}').addTo(map);
                currentLayer = 'satellite';
            } else {
                L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png').addTo(map);
                currentLayer = 'standard';
            }
        }
        window.addEventListener('load', initializeGeolocation);
    </script>
    <style>
        .custom-icon { background: none; border: none; }
    </style>
    @endpush
</x-pwa.main>
