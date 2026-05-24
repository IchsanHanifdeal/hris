@php $setting = \App\Models\Setting::first(); @endphp

<x-dashboard.main>
    <div class="space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-base-content/5">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-base-content bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                    {{ __('menu.dashboard') }}
                </h1>
                <p class="text-base-content/60 mt-1 font-medium text-sm md:text-base">{{ __('dashboard.subtitle') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="btn btn-ghost bg-base-100 border border-base-content/5 shadow-sm cursor-default rounded-2xl h-14 px-5">
                    <x-lucide-calendar class="w-4 h-4 mr-2 text-primary" />
                    <span class="font-black text-xs uppercase tracking-wider">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                </div>
                <a href="{{ route('employees.create') }}" class="btn btn-primary h-14 rounded-2xl text-white shadow-xl shadow-primary/20 hover:scale-[1.01] active:scale-95 transition-all font-black uppercase tracking-wider text-xs px-6 gap-2">
                    <x-lucide-plus class="w-4 h-4" />
                    {{ __('dashboard.add_employee') }}
                </a>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-dashboard.card.stat 
                title="{{ __('dashboard.stats.total_employees') }}" 
                value="{{ $totalEmployees }}" 
                icon="users" 
                variant="primary" />

            <x-dashboard.card.stat 
                title="{{ __('dashboard.stats.present') }}" 
                value="{{ $presentToday }}" 
                icon="user-check" 
                variant="success" />

            <x-dashboard.card.stat 
                title="{{ __('dashboard.stats.on_leave') }}" 
                value="{{ $onLeave }}" 
                icon="plane-takeoff" 
                variant="warning" />

            <x-dashboard.card.stat 
                title="{{ __('dashboard.stats.late') }}" 
                value="{{ $lateToday }}" 
                icon="alarm-clock" 
                variant="error" />
        </div>

        <!-- Main Dashboard Split Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Side: GPS Map Live Monitoring -->
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-base-100 rounded-[2rem] p-6 border border-base-content/5 shadow-2xl relative overflow-hidden flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-base-content/5">
                        <div class="flex items-center gap-4">
                            <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                                <x-lucide-map-pin class="size-6 animate-pulse" />
                            </div>
                            <div>
                                <h3 class="font-black text-lg tracking-tight text-base-content">Monitoring Lokasi Absensi</h3>
                                <p class="text-[10px] font-bold opacity-30 uppercase tracking-[0.2em]">Live GPS Map Tracking</p>
                            </div>
                        </div>
                        <span class="badge badge-success badge-sm font-black text-[9px] uppercase tracking-widest px-3 py-3 shadow-sm rounded-lg">
                            Realtime GPS
                        </span>
                    </div>

                    <!-- Leaflet map container -->
                    <div class="h-[480px] w-full rounded-[1.8rem] border border-base-content/5 overflow-hidden shadow-inner bg-base-200 z-10 relative">
                        <div id="live-map" class="absolute inset-0 w-full h-full z-10"></div>
                        
                        @if(!$setting || !$setting->latitude || !$setting->longitude)
                            <div class="absolute inset-0 bg-base-100/90 backdrop-blur-sm z-20 flex flex-col items-center justify-center p-8 text-center">
                                <div class="size-16 rounded-2xl bg-error/10 flex items-center justify-center text-error mb-4">
                                    <x-lucide-map-pin-off class="size-8" />
                                </div>
                                <h4 class="font-black text-lg">Peta Belum Dikonfigurasi</h4>
                                <p class="text-xs text-base-content/50 max-w-sm mt-2 leading-relaxed">
                                    Harap atur titik koordinat kantor terlebih dahulu pada halaman Pengaturan untuk mengaktifkan peta monitoring.
                                </p>
                                <a href="{{ route('settings.index') }}" class="btn btn-primary btn-sm rounded-xl mt-6 font-black uppercase text-[10px] tracking-widest">
                                    Atur Lokasi Kantor
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Side: Recent Logs & Absent Feed -->
            <div class="lg:col-span-4 space-y-8">
                
                <!-- Recent Attendance List -->
                <div class="card bg-base-100 border border-base-content/5 shadow-2xl rounded-[2rem] overflow-hidden">
                    <div class="card-body p-6">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-base-content/5">
                            <div>
                                <h3 class="font-black text-lg tracking-tight">{{ __('dashboard.recent_attendance.title') }}</h3>
                                <p class="text-[9px] font-bold opacity-30 uppercase tracking-[0.2em] mt-0.5">Today's Checkins</p>
                            </div>
                            <a href="{{ route('attendances.index') }}" class="btn btn-ghost btn-xs rounded-lg text-primary font-black uppercase tracking-widest text-[9px] px-2">
                                Lihat Semua
                            </a>
                        </div>
                        
                        <div class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                            @forelse($recentAttendances as $attendance)
                                <div class="flex items-center justify-between p-3 bg-base-200/30 rounded-[1.25rem] border border-base-content/5 group hover:border-primary/20 hover:bg-base-200/50 transition-all duration-300">
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-10 h-10 bg-primary/10">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($attendance->employee->user->name) }}&background=random&bold=true" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs font-black text-base-content group-hover:text-primary transition-colors">{{ $attendance->employee->user->name }}</div>
                                            <div class="text-[9px] opacity-40 font-bold uppercase mt-0.5">{{ $attendance->employee->position->name ?? 'Staff' }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-[10px] font-mono font-black text-base-content/75">{{ $attendance->time_in->format('H:i') }}</div>
                                        <div class="mt-1">
                                            @if($attendance->is_late)
                                                <span class="inline-flex items-center text-[7px] font-black uppercase bg-error/15 text-error px-1.5 py-0.5 rounded border border-error/20">LATE</span>
                                            @else
                                                <span class="inline-flex items-center text-[7px] font-black uppercase bg-success/15 text-success px-1.5 py-0.5 rounded border border-success/20">ON TIME</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center border border-dashed border-base-content/10 rounded-[1.5rem]">
                                    <x-lucide-user-check class="size-8 mx-auto opacity-10 mb-2" />
                                    <p class="text-[9px] font-black opacity-20 uppercase tracking-widest">Belum ada absensi masuk</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Who is Out (Absent Overview) -->
                <div class="card bg-base-100 border border-base-content/5 shadow-2xl rounded-[2rem]">
                    <div class="card-body p-6">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-base-content/5">
                            <div>
                                <h3 class="font-black text-lg tracking-tight">{{ __('dashboard.absence_overview.title') ?? 'Izin & Cuti' }}</h3>
                                <p class="text-[9px] font-bold opacity-30 uppercase tracking-[0.2em] mt-0.5">Absent Overview</p>
                            </div>
                            <span class="badge badge-error badge-sm font-black text-[9px] rounded-lg px-2.5 py-2.5 shadow-sm">{{ $onLeave }}</span>
                        </div>

                        <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                            @forelse($absentEmployees ?? [] as $absent)
                                <div class="flex items-center justify-between p-3 bg-base-200/30 rounded-[1.25rem] border border-base-content/5 group hover:border-primary/20 hover:bg-base-200/50 transition-all duration-300">
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-9 h-9">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($absent->user->name) }}&background=random&bold=true" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs font-black text-base-content">{{ $absent->user->name }}</div>
                                            <div class="text-[9px] opacity-40 font-bold uppercase">{{ $absent->department->name ?? 'Staff' }}</div>
                                        </div>
                                    </div>
                                    <span class="badge {{ $absent->status === 'leave' ? 'badge-warning' : 'badge-ghost' }} border-none text-[8px] font-black px-2 py-2 rounded">
                                        {{ strtoupper($absent->status) }}
                                    </span>
                                </div>
                            @empty
                                <div class="py-10 text-center border border-dashed border-base-content/10 rounded-[1.5rem]">
                                    <x-lucide-check-circle-2 class="size-8 mx-auto opacity-10 mb-2 text-success" />
                                    <p class="text-[9px] font-black opacity-20 uppercase tracking-widest">Semua Karyawan Hadir</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #live-map { height: 100% !important; width: 100% !important; }
        .leaflet-container { font-family: inherit; z-index: 10 !important; }
        .leaflet-bar { border: none !important; box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1) !important; border-radius: 1rem !important; overflow: hidden; margin: 15px !important; }
        .leaflet-bar a { background-color: rgb(255 255 255 / 0.9) !important; color: #1e293b !important; width: 36px !important; height: 36px !important; line-height: 36px !important; border: none !important; font-size: 16px !important; transition: all 0.2s; }
        .leaflet-bar a:hover { color: #6366f1 !important; }
        .leaflet-tile-pane { filter: contrast(1.05) brightness(0.98); }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($setting && $setting->latitude && $setting->longitude)
                var officeLat = {{ $setting->latitude }};
                var officeLng = {{ $setting->longitude }};
                var officeRadius = {{ $setting->radius ?? 100 }};
                
                setTimeout(function() {
                    // Initialize Leaflet Map centered on office
                    var map = L.map('live-map', {
                        zoomControl: false,
                        scrollWheelZoom: false
                    }).setView([officeLat, officeLng], 16);

                    // Add Zoom Control
                    L.control.zoom({ position: 'topright' }).addTo(map);

                    // Slick voyager map tiles
                    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                        attribution: '© OpenStreetMap, © CartoDB',
                        maxZoom: 20
                    }).addTo(map);

                    // Custom Office Icon
                    var officeIcon = L.divIcon({
                        html: `<div class="size-8 rounded-full bg-primary border-4 border-white flex items-center justify-center shadow-lg text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                               </div>`,
                        className: '',
                        iconSize: [32, 32],
                        iconAnchor: [16, 16]
                    });

                    // Add Office Marker
                    L.marker([officeLat, officeLng], { icon: officeIcon }).addTo(map)
                        .bindPopup("<b>Kantor Pusat (App Base)</b><br>Radius Absensi: " + (officeRadius > 0 ? officeRadius + "m" : "WFA (Bebas)"));

                    // Add Office Radius Circle if active
                    if (officeRadius > 0) {
                        L.circle([officeLat, officeLng], {
                            color: '#6366f1',
                            fillColor: '#6366f1',
                            fillOpacity: 0.1,
                            weight: 1.5,
                            radius: officeRadius
                        }).addTo(map);
                    }

                    // Plot Recent Checkin coordinates
                    var bounds = L.latLngBounds([officeLat, officeLng]);
                    var checkinCount = 0;

                    @foreach($recentAttendances as $attendance)
                        @if($attendance->lat_in && $attendance->long_in)
                            var lat = {{ $attendance->lat_in }};
                            var lng = {{ $attendance->long_in }};
                            var empName = "{{ $attendance->employee->user->name }}";
                            var timeIn = "{{ $attendance->time_in->format('H:i') }}";
                            var isLate = {{ $attendance->is_late ? 'true' : 'false' }};
                            
                            // Custom Employee Marker Icon
                            var empIcon = L.divIcon({
                                html: `<div class="size-7 rounded-full ` + (isLate ? 'bg-error' : 'bg-success') + ` border-2 border-white flex items-center justify-center shadow-md text-white font-mono text-[9px] font-black">
                                            ` + empName.charAt(0) + `
                                       </div>`,
                                className: '',
                                iconSize: [28, 28],
                                iconAnchor: [14, 14]
                            });

                            var marker = L.marker([lat, lng], { icon: empIcon }).addTo(map)
                                .bindPopup("<b>" + empName + "</b><br>Masuk: " + timeIn + "<br>Status: " + (isLate ? "<span class='text-error font-bold'>TERLAMBAT</span>" : "<span class='text-success font-bold'>TEPAT WAKTU</span>"));
                            
                            bounds.extend([lat, lng]);
                            checkinCount++;
                        @endif
                    @endforeach

                    // Fit map bounds if other checkins exist
                    if (checkinCount > 0) {
                        map.fitBounds(bounds, { padding: [50, 50] });
                    }
                }, 600);
            @endif
        });
    </script>
    @endpush
</x-dashboard.main>