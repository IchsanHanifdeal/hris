<x-dashboard.main title="{{ __('setting.title') }}">
    <div class="max-w-6xl mx-auto">
        
        <div class="mb-8">
            <h1 class="text-4xl font-black tracking-tight">{{ __('setting.title') }}</h1>
            <p class="text-base-content/50 font-medium mt-2">{{ __('setting.subtitle') }}</p>
        </div>
        
        <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf

            <div class="lg:col-span-4 space-y-8">
                <!-- Branding & Identity -->
                <div class="bg-base-100 rounded-[2.5rem] p-8 border border-base-content/5 shadow-2xl relative overflow-hidden">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="size-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                            <x-lucide-layout-grid class="size-7" />
                        </div>
                        <div>
                            <h3 class="font-black text-xl tracking-tight">Identity</h3>
                            <p class="text-[10px] font-bold opacity-30 uppercase tracking-[0.2em]">App Branding</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="form-control group">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 italic">Application Name</span></label>
                            <input type="text" name="app_name" value="{{ old('app_name', $setting->app_name ?? config('app.name')) }}" class="input input-bordered bg-base-200/50 border-base-content/5 rounded-2xl h-14 font-bold text-sm w-full focus:border-primary transition-all" required />
                            @error('app_name') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 italic">App Logo</span></label>
                            <div class="flex items-center gap-4">
                                @if($setting && $setting->app_logo)
                                    <img src="{{ asset('storage/' . $setting->app_logo) }}" class="size-14 rounded-xl object-contain bg-base-200 p-1">
                                @endif
                                <input type="file" name="app_logo" class="file-input file-input-bordered bg-base-200/50 rounded-2xl w-full h-14 font-bold text-sm" />
                            </div>
                            @error('app_logo') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 italic">Favicon</span></label>
                            <div class="flex items-center gap-4">
                                @if($setting && $setting->app_favicon)
                                    <img src="{{ asset('storage/' . $setting->app_favicon) }}" class="size-10 rounded-lg object-contain bg-base-200 p-1">
                                @endif
                                <input type="file" name="app_favicon" class="file-input file-input-bordered bg-base-200/50 rounded-2xl w-full h-14 font-bold text-sm" />
                            </div>
                            @error('app_favicon') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="divider opacity-5"></div>

                        <div class="form-control group">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 italic">PWA Name</span></label>
                            <input type="text" name="pwa_name" value="{{ old('pwa_name', $setting->pwa_name ?? '') }}" class="input input-bordered bg-base-200/50 border-base-content/5 rounded-2xl h-14 font-bold text-sm w-full focus:border-primary transition-all" placeholder="Enter PWA Name" />
                            @error('pwa_name') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 italic">PWA Logo</span></label>
                            <div class="flex items-center gap-4">
                                @if($setting && $setting->pwa_logo)
                                    <img src="{{ asset('storage/' . $setting->pwa_logo) }}" class="size-14 rounded-xl object-contain bg-base-200 p-1">
                                @endif
                                <input type="file" name="pwa_logo" class="file-input file-input-bordered bg-base-200/50 rounded-2xl w-full h-14 font-bold text-sm" />
                            </div>
                            @error('pwa_logo') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Time Settings -->
                <div class="bg-base-100 rounded-[2.5rem] p-8 border border-base-content/5 shadow-2xl relative overflow-hidden">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="size-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                            <x-lucide-clock class="size-7" />
                        </div>
                        <div>
                            <h3 class="font-black text-xl tracking-tight">{{ __('setting.section_time') }}</h3>
                            <p class="text-[10px] font-bold opacity-30 uppercase tracking-[0.2em]">Attendance Rule</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="form-control group">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 italic">{{ __('setting.label_check_in') }}</span></label>
                            <label class="input input-bordered flex items-center gap-4 bg-base-200/50 border-base-content/5 rounded-2xl h-14 focus-within:border-primary transition-all shadow-inner">
                                <x-lucide-log-in class="size-4 opacity-20" />
                                <input type="time" name="check_in_time" value="{{ old('check_in_time', $setting->check_in_time ?? '') }}" class="grow font-bold bg-transparent border-none focus:ring-0 text-sm" required />
                            </label>
                            @error('check_in_time') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control group">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 italic">{{ __('setting.label_check_out') }}</span></label>
                            <label class="input input-bordered flex items-center gap-4 bg-base-200/50 border-base-content/5 rounded-2xl h-14 focus-within:border-primary transition-all shadow-inner">
                                <x-lucide-log-out class="size-4 opacity-20" />
                                <input type="time" name="check_out_time" value="{{ old('check_out_time', $setting->check_out_time ?? '') }}" class="grow font-bold bg-transparent border-none focus:ring-0 text-sm" required />
                            </label>
                            @error('check_out_time') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8">
                <!-- Location Settings -->
                <div class="bg-base-100 rounded-[2.5rem] p-10 border border-base-content/5 shadow-2xl relative overflow-hidden">
                    <div class="flex items-center gap-4 mb-10 pb-6 border-b border-base-content/5">
                        <div class="size-14 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary shadow-inner">
                            <x-lucide-map-pin class="size-7" />
                        </div>
                        <div>
                            <h3 class="font-black text-2xl tracking-tight">{{ __('setting.section_location') }}</h3>
                            <p class="text-[10px] font-bold opacity-30 uppercase tracking-[0.2em]">Office Coordinates</p>
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">{{ __('setting.label_address') }}</span></label>
                        <textarea name="address" class="textarea textarea-bordered bg-base-200/50 rounded-2xl min-h-[100px] font-bold text-sm w-full focus:border-secondary transition-all" placeholder="{{ __('setting.placeholder_address') }}">{{ old('address', $setting->address ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mt-6">
                        <div class="form-control">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">{{ __('setting.label_latitude') }}</span></label>
                            <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $setting->latitude ?? '') }}" class="input input-bordered bg-base-200/50 rounded-2xl h-14 font-bold text-sm focus:border-secondary transition-all" placeholder="e.g. -6.200000" />
                        </div>

                        <div class="form-control">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">{{ __('setting.label_longitude') }}</span></label>
                            <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $setting->longitude ?? '') }}" class="input input-bordered bg-base-200/50 rounded-2xl h-14 font-bold text-sm focus:border-secondary transition-all" placeholder="e.g. 106.816666" />
                        </div>

                        <div class="form-control md:col-span-2">
                            <div class="flex items-center justify-between mb-3 px-1">
                                <p class="text-[10px] font-bold opacity-30 italic">Click on map to pick office location</p>
                                <button type="button" id="get-location" class="btn btn-ghost btn-xs rounded-lg gap-2 text-primary font-black uppercase tracking-widest hover:bg-primary/10 transition-all">
                                    <x-lucide-navigation class="size-3" />
                                    Ambil Lokasi Terkini
                                </button>
                            </div>
                            <div id="map" class="rounded-[2.5rem] border border-base-content/5 shadow-inner z-10 overflow-hidden"></div>
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">{{ __('setting.label_radius') }}</span></label>
                            <div class="relative">
                                <input type="number" name="radius" id="radius" value="{{ old('radius', $setting->radius ?? 100) }}" class="input input-bordered bg-base-200/50 rounded-2xl h-14 font-bold text-sm focus:border-secondary transition-all w-full pr-16" />
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black opacity-30 italic">METERS</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 mt-12 pt-8 border-t border-base-content/5">
                        <button type="submit" class="btn btn-primary flex-[2] h-16 rounded-2xl text-white shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all font-black uppercase tracking-[0.2em]">
                            <x-lucide-save class="size-5 mr-2" />
                            {{ __('setting.btn_save') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('styles')
    <style>
        #map { height: 450px !important; width: 100% !important; }
        .leaflet-container { font-family: inherit; z-index: 10 !important; }
        .leaflet-control-zoom { border: none !important; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important; border-radius: 1rem !important; overflow: hidden; margin: 20px !important; }
        .leaflet-bar a { background-color: #fff !important; border-bottom: 1px solid #f1f5f9 !important; color: #000 !important; width: 40px !important; height: 40px !important; line-height: 40px !important; }
        .leaflet-tile-pane { filter: grayscale(0.5) brightness(0.9) contrast(1.1); }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var lat = {{ $setting->latitude ?? -6.200000 }};
            var lng = {{ $setting->longitude ?? 106.816666 }};
            var radius = {{ $setting->radius ?? 100 }};
            
            setTimeout(function() {
                var map = L.map('map', {
                    zoomControl: true,
                    scrollWheelZoom: false
                }).setView([lat, lng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                var marker = L.marker([lat, lng], {draggable: true}).addTo(map);
                var circle = L.circle([lat, lng], {
                    color: '#6366f1',
                    fillColor: '#6366f1',
                    fillOpacity: 0.1,
                    radius: radius
                }).addTo(map);

                function updateInputs(lat, lng) {
                    document.getElementById('latitude').value = lat.toFixed(6);
                    document.getElementById('longitude').value = lng.toFixed(6);
                    fetchAddress(lat, lng);
                }

                function fetchAddress(lat, lng) {
                    const addressField = document.querySelector('textarea[name="address"]');
                    addressField.placeholder = "Mencari alamat...";
                    
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&accept-language=id`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.display_name) {
                                addressField.value = data.display_name;
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching address:', error);
                            addressField.placeholder = "{{ __('setting.placeholder_address') }}";
                        });
                }

                marker.on('dragend', function(e) {
                    var position = marker.getLatLng();
                    updateInputs(position.lat, position.lng);
                    circle.setLatLng(position);
                });

                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    circle.setLatLng(e.latlng);
                    updateInputs(e.latlng.lat, e.latlng.lng);
                });

                document.getElementById('radius').addEventListener('input', function(e) {
                    circle.setRadius(e.target.value);
                });

                document.getElementById('get-location').addEventListener('click', function() {
                    var btn = this;
                    var originalContent = btn.innerHTML;
                    
                    if (navigator.geolocation) {
                        btn.disabled = true;
                        btn.innerHTML = '<span class="loading loading-spinner loading-xs"></span> MENCARI...';
                        
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var newLat = position.coords.latitude;
                            var newLng = position.coords.longitude;
                            
                            map.setView([newLat, newLng], 17);
                            marker.setLatLng([newLat, newLng]);
                            circle.setLatLng([newLat, newLng]);
                            updateInputs(newLat, newLng);
                            
                            btn.disabled = false;
                            btn.innerHTML = originalContent;
                        }, function(error) {
                            alert("Gagal mengambil lokasi: " + error.message);
                            btn.disabled = false;
                            btn.innerHTML = originalContent;
                        }, {
                            enableHighAccuracy: true
                        });
                    } else {
                        alert("Geolokasi tidak didukung oleh browser ini.");
                    }
                });
            }, 800);
        });
    </script>
    @endpush
</x-dashboard.main>
