<x-dashboard.main title="Pengaturan Lokasi Absensi">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        
        <!-- Header Section -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-base-content bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                    Konfigurasi GPS & Lokasi Kantor
                </h1>
                <p class="text-base-content/50 font-medium mt-2 text-sm md:text-base">
                    Atur titik koordinat kantor pusat, radius wilayah kehadiran, dan aktifkan validasi lokasi absensi karyawan.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-4 py-2 rounded-2xl bg-base-100 border border-base-content/5 shadow-sm text-xs font-black uppercase tracking-widest text-primary">
                    <x-lucide-navigation class="size-4 mr-2 animate-bounce" />
                    Maps Engine Active
                </span>
            </div>
        </div>
        
        <form action="{{ route('settings.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf

            <!-- Left Column: Controls -->
            <div class="lg:col-span-5 space-y-8">
                <!-- Location Settings Card -->
                <div class="bg-base-100 rounded-[2rem] p-8 border border-base-content/5 shadow-2xl relative overflow-hidden transition-all duration-300 hover:shadow-primary/5">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="flex items-center gap-4 mb-8">
                        <div class="size-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                            <x-lucide-sliders class="size-7" />
                        </div>
                        <div>
                            <h3 class="font-black text-xl tracking-tight text-base-content">Parameter Lokasi</h3>
                            <p class="text-[10px] font-bold opacity-30 uppercase tracking-[0.2em]">GPS Configuration</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Toggle GPS Validation -->
                        <div class="form-control bg-base-200/40 border border-base-content/5 p-5 rounded-2xl transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="label-text font-black text-xs uppercase text-base-content tracking-wide">Validasi GPS Kantor</span>
                                    <p class="text-[10px] text-base-content/50 font-bold mt-1 max-w-[200px] leading-relaxed">
                                        Batasi kehadiran hanya di dalam radius wilayah kantor.
                                    </p>
                                </div>
                                <input type="checkbox" name="gps_validation" id="gps-validation-toggle" value="1" 
                                    class="toggle toggle-primary toggle-lg shadow-sm" 
                                    {{ ($setting && $setting->radius > 0) ? 'checked' : '' }} />
                            </div>
                        </div>

                        <!-- Status Badge WFA vs Radius -->
                        <div id="status-badge" class="transition-all duration-300">
                            <!-- Dynamically updated by JS -->
                        </div>

                        <!-- Radius Input (Hidden or Disabled if GPS validation is off) -->
                        <div class="form-control group transition-all duration-300" id="radius-container">
                            <label class="label px-1">
                                <span class="label-text font-black text-[10px] uppercase opacity-40 italic">Radius Absensi Kantor</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="radius" id="radius" 
                                    value="{{ old('radius', ($setting && $setting->radius > 0) ? $setting->radius : 100) }}" 
                                    class="input input-bordered bg-base-200/50 border-base-content/5 rounded-2xl h-14 font-black text-sm w-full pr-20 focus:border-primary focus:outline-none transition-all shadow-inner" />
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black opacity-30 italic tracking-widest">METER</div>
                            </div>
                            @error('radius') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="divider opacity-5"></div>

                        <!-- Latitude -->
                        <div class="form-control group">
                            <label class="label px-1">
                                <span class="label-text font-black text-[10px] uppercase opacity-40 italic">Garis Lintang (Latitude)</span>
                            </label>
                            <input type="text" name="latitude" id="latitude" 
                                value="{{ old('latitude', $setting->latitude ?? '') }}" 
                                class="input input-bordered bg-base-200/50 border-base-content/5 rounded-2xl h-14 font-mono font-bold text-sm w-full focus:border-primary focus:outline-none transition-all shadow-inner" 
                                placeholder="e.g. -6.200000" required />
                            @error('latitude') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Longitude -->
                        <div class="form-control group">
                            <label class="label px-1">
                                <span class="label-text font-black text-[10px] uppercase opacity-40 italic">Garis Bujur (Longitude)</span>
                            </label>
                            <input type="text" name="longitude" id="longitude" 
                                value="{{ old('longitude', $setting->longitude ?? '') }}" 
                                class="input input-bordered bg-base-200/50 border-base-content/5 rounded-2xl h-14 font-mono font-bold text-sm w-full focus:border-primary focus:outline-none transition-all shadow-inner" 
                                placeholder="e.g. 106.816666" required />
                            @error('longitude') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Address -->
                        <div class="form-control">
                            <label class="label px-1">
                                <span class="label-text font-black text-[10px] uppercase opacity-40 italic">Alamat Kantor</span>
                            </label>
                            <textarea name="address" class="textarea textarea-bordered bg-base-200/50 border-base-content/5 rounded-2xl min-h-[100px] font-bold text-sm w-full focus:border-primary focus:outline-none transition-all shadow-inner leading-relaxed p-4" 
                                placeholder="Klik di peta atau masukkan alamat kantor secara manual...">{{ old('address', $setting->address ?? '') }}</textarea>
                            @error('address') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-base-content/5">
                        <button type="submit" class="btn btn-primary w-full h-16 rounded-2xl text-white shadow-xl shadow-primary/20 hover:scale-[1.01] active:scale-95 transition-all font-black uppercase tracking-[0.2em] gap-3">
                            <x-lucide-save class="size-5" />
                            Simpan Pengaturan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Map -->
            <div class="lg:col-span-7">
                <div class="bg-base-100 rounded-[2rem] p-6 border border-base-content/5 shadow-2xl relative overflow-hidden h-full flex flex-col justify-between">
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 pb-6 border-b border-base-content/5">
                        <div class="flex items-center gap-4">
                            <div class="size-14 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary shadow-inner">
                                <x-lucide-map class="size-7" />
                            </div>
                            <div>
                                <h3 class="font-black text-xl tracking-tight text-base-content">Peta Interaktif</h3>
                                <p class="text-[10px] font-bold opacity-30 uppercase tracking-[0.2em]">Live Visualizer</p>
                            </div>
                        </div>

                        <button type="button" id="get-location" class="btn btn-ghost bg-secondary/10 hover:bg-secondary/20 rounded-2xl px-5 h-12 text-secondary font-black uppercase tracking-wider text-xs gap-2 transition-all active:scale-95">
                            <x-lucide-locate-fixed class="size-4" />
                            Lokasi Saya
                        </button>
                    </div>

                    <div class="flex-1 min-h-[480px] relative rounded-[1.8rem] border border-base-content/5 overflow-hidden shadow-inner bg-base-200 z-10">
                        <div id="map" class="absolute inset-0 w-full h-full z-10"></div>
                        <div class="absolute bottom-4 left-4 z-20 bg-base-100/90 backdrop-blur-md px-4 py-3 rounded-2xl shadow-lg border border-base-content/5 flex items-center gap-3">
                            <div class="size-3 rounded-full bg-primary animate-ping"></div>
                            <span class="text-[10px] font-black text-base-content/75 uppercase tracking-widest">
                                Geser penanda untuk ubah posisi kantor
                            </span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>

    @push('styles')
    <style>
        #map { height: 100% !important; width: 100% !important; }
        .leaflet-container { font-family: inherit; z-index: 10 !important; }
        .leaflet-bar { border: none !important; box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1) !important; border-radius: 1.25rem !important; overflow: hidden; margin: 20px !important; }
        .leaflet-bar a { background-color: rgb(255 255 255 / 0.9) !important; color: #1e293b !important; width: 44px !important; height: 44px !important; line-height: 44px !important; border: none !important; font-size: 18px !important; font-weight: bold; transition: all 0.2s; }
        .leaflet-bar a:hover { color: #6366f1 !important; }
        .leaflet-tile-pane { filter: contrast(1.05) brightness(0.98); }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Default parameters
            var defaultLat = {{ $setting->latitude ?? -6.200000 }};
            var defaultLng = {{ $setting->longitude ?? 106.816666 }};
            var currentRadius = {{ ($setting && $setting->radius > 0) ? $setting->radius : 100 }};
            
            var map, marker, circle;
            
            // DOM Elements
            var latInput = document.getElementById('latitude');
            var lngInput = document.getElementById('longitude');
            var radiusInput = document.getElementById('radius');
            var addressTextarea = document.querySelector('textarea[name="address"]');
            var validationToggle = document.getElementById('gps-validation-toggle');
            var radiusContainer = document.getElementById('radius-container');
            var statusBadge = document.getElementById('status-badge');

            // Set up state and UI update helper
            function updateStateUI() {
                var isGPSValid = validationToggle.checked;
                
                if (isGPSValid) {
                    // Active GPS Validation Mode
                    radiusContainer.classList.remove('opacity-40', 'pointer-events-none');
                    radiusInput.removeAttribute('disabled');
                    
                    var radVal = parseInt(radiusInput.value) || 100;
                    if (radVal <= 0) radVal = 100;
                    radiusInput.value = radVal;
                    
                    // Show circle on map
                    if (circle) {
                        circle.setRadius(radVal);
                        circle.setStyle({ fillOpacity: 0.15, opacity: 0.8 });
                    }
                    
                    statusBadge.innerHTML = `
                        <div class="flex items-center gap-3 p-4 bg-primary/10 border border-primary/20 text-primary rounded-2xl animate-fade-in shadow-sm">
                            <div class="size-8 bg-primary text-white flex items-center justify-center rounded-xl shadow">
                                <i class="lucide-shield-check"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider text-left">Validasi GPS Aktif</h4>
                                <p class="text-[9px] font-bold opacity-75 mt-0.5 text-left">Karyawan wajib absen dalam radius ` + radVal + `m.</p>
                            </div>
                        </div>
                    `;
                } else {
                    // WFA Mode
                    radiusContainer.classList.add('opacity-40', 'pointer-events-none');
                    radiusInput.setAttribute('disabled', 'true');
                    
                    // Hide circle on map
                    if (circle) {
                        circle.setStyle({ fillOpacity: 0, opacity: 0 });
                    }
                    
                    statusBadge.innerHTML = `
                        <div class="flex items-center gap-3 p-4 bg-success/10 border border-success/20 text-success rounded-2xl animate-fade-in shadow-sm">
                            <div class="size-8 bg-success text-white flex items-center justify-center rounded-xl shadow">
                                <i class="lucide-globe"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-wider text-left">Work From Anywhere (WFA)</h4>
                                <p class="text-[9px] font-bold opacity-75 mt-0.5 text-left">Validasi lokasi dinonaktifkan. Karyawan bebas absen dari mana saja.</p>
                            </div>
                        </div>
                    `;
                }
            }

            // Initialize Map with short delay for container load
            setTimeout(function() {
                map = L.map('map', {
                    zoomControl: false,
                    scrollWheelZoom: true
                }).setView([defaultLat, defaultLng], 16);

                // Add Premium Zoom Control
                L.control.zoom({ position: 'topright' }).addTo(map);

                // Custom Sleek Map Tile Layer
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '© OpenStreetMap, © CartoDB',
                    maxZoom: 20
                }).addTo(map);

                // Set up visual Marker and Radius Circle
                marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
                circle = L.circle([defaultLat, defaultLng], {
                    color: '#6366f1',
                    fillColor: '#6366f1',
                    fillOpacity: 0.15,
                    weight: 2,
                    radius: currentRadius
                }).addTo(map);

                // Update Inputs & Fetch Address
                function updateLocation(lat, lng) {
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lng.toFixed(6);
                    circle.setLatLng([lat, lng]);
                    fetchReverseGeocode(lat, lng);
                }

                // Call Nominatim API for reverse lookup
                function fetchReverseGeocode(lat, lng) {
                    addressTextarea.placeholder = "Mencari nama jalan & wilayah...";
                    
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=id`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.display_name) {
                                addressTextarea.value = data.display_name;
                            }
                        })
                        .catch(error => {
                            console.error('Error Reverse Geocode:', error);
                            addressTextarea.placeholder = "Alamat tidak dapat dimuat otomatis.";
                        });
                }

                // Event Listeners for Map & Marker
                marker.on('dragend', function(e) {
                    var pos = marker.getLatLng();
                    updateLocation(pos.lat, pos.lng);
                });

                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    updateLocation(e.latlng.lat, e.latlng.lng);
                });

                // Real-time Radius visual updates
                radiusInput.addEventListener('input', function(e) {
                    var rad = parseInt(e.target.value) || 0;
                    if (rad > 0 && circle && validationToggle.checked) {
                        circle.setRadius(rad);
                    }
                });

                // Toggle GPS Validation Switch
                validationToggle.addEventListener('change', function() {
                    updateStateUI();
                });

                // Fetch current coordinates using Geolocation API
                document.getElementById('get-location').addEventListener('click', function() {
                    var btn = this;
                    var origHTML = btn.innerHTML;
                    
                    if (navigator.geolocation) {
                        btn.disabled = true;
                        btn.innerHTML = '<span class="loading loading-spinner loading-xs mr-2"></span> MELACAK...';
                        
                        navigator.geolocation.getCurrentPosition(function(pos) {
                            var userLat = pos.coords.latitude;
                            var userLng = pos.coords.longitude;
                            
                            map.setView([userLat, userLng], 17);
                            marker.setLatLng([userLat, userLng]);
                            updateLocation(userLat, userLng);
                            
                            btn.disabled = false;
                            btn.innerHTML = origHTML;
                        }, function(err) {
                            alert("Gagal melacak lokasi perangkat Anda: " + err.message);
                            btn.disabled = false;
                            btn.innerHTML = origHTML;
                        }, {
                            enableHighAccuracy: true
                        });
                    } else {
                        alert("Geolokasi tidak didukung oleh browser ini.");
                    }
                });

                // Initialize UI components state
                updateStateUI();
            }, 500);
        });
    </script>
    @endpush
</x-dashboard.main>
