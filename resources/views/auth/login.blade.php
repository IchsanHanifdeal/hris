<x-main.main>
    @php $setting = \App\Models\Setting::first(); @endphp
    <div class="min-h-screen w-full flex bg-base-100 text-base-content font-sans">

        {{-- Left Section: Experience & Branding --}}
        <div class="hidden lg:flex w-7/12 relative bg-base-300 overflow-hidden flex-col justify-between p-20">
            
            <div class="absolute inset-0 opacity-10" 
                 style="background-image: radial-gradient(currentColor 1.5px, transparent 1.5px); background-size: 48px 48px;">
            </div>

            <div class="absolute top-0 left-0 w-[30rem] h-[30rem] bg-primary/20 rounded-full blur-[140px] animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-[30rem] h-[30rem] bg-secondary/10 rounded-full blur-[140px] animate-pulse delay-1000"></div>

            <div class="relative z-10 flex items-center gap-5">
                @if($setting && $setting->app_logo)
                    <img src="{{ asset('storage/' . $setting->app_logo) }}" class="w-14 h-14 rounded-2xl object-contain bg-white/10 p-2 shadow-2xl shadow-primary/20 ring-1 ring-white/10">
                @else
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center shadow-2xl shadow-primary/20 ring-1 ring-white/10">
                        <x-lucide-command class="w-8 h-8 text-white" stroke-width="2" />
                    </div>
                @endif
                <span class="text-3xl font-black tracking-tighter">{{ $setting->app_name ?? config('app.name', 'HRIS PRO') }}</span>
            </div>

            <div class="relative z-10 space-y-6">
                <h1 class="text-6xl font-black leading-tight tracking-tight">
                    {{ __('login.hero_title_1') }} <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">
                        {{ __('login.hero_title_2') }}
                    </span>
                </h1>
                <p class="text-base-content/60 text-xl leading-relaxed max-w-lg font-medium opacity-80">
                    {{ __('login.hero_description') }}
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] text-base-content/30">
                <span>&copy; {{ date('Y') }} {{ $setting->app_name ?? config('app.name') }}</span>
                <span class="w-1.5 h-1.5 rounded-full bg-primary/20"></span>
                <span>SYSTEM VERSION 1.2.0</span>
            </div>
        </div>

        {{-- Right Section: Login Form --}}
        <div class="w-full lg:w-5/12 flex items-center justify-center p-8 sm:p-16 xl:p-24 bg-base-100 relative overflow-hidden">
            
            {{-- Language Switcher --}}
            <div class="absolute top-8 right-8 z-50">
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-sm glass border-base-content/10 gap-2 text-base-content/80 hover:bg-base-200/50 shadow-sm rounded-xl">
                        <span class="text-lg">
                            {{ app()->getLocale() == 'id' ? '🇮🇩' : '🇺🇸' }}
                        </span>
                        <span class="uppercase font-black text-[10px] tracking-wider">{{ app()->getLocale() }}</span>
                        <x-lucide-chevron-down class="w-3 h-3 opacity-50" />
                    </div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-2xl bg-base-100 rounded-2xl w-40 mt-3 border border-base-content/5 ring-1 ring-black/5 animate-in fade-in slide-in-from-top-2">
                        <li><a href="{{ route('lang.switch', 'id') }}" class="{{ app()->getLocale() == 'id' ? 'bg-primary/10 text-primary active' : '' }} font-bold text-xs uppercase tracking-widest py-3">🇮🇩 Indonesia</a></li>
                        <li><a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'bg-primary/10 text-primary active' : '' }} font-bold text-xs uppercase tracking-widest py-3">🇺🇸 English</a></li>
                    </ul>
                </div>
            </div>

            <div class="w-full max-w-md relative z-10">
                <div class="lg:hidden text-center mb-12 flex flex-col items-center gap-4">
                    @if($setting && $setting->app_logo)
                        <img src="{{ asset('storage/' . $setting->app_logo) }}" class="h-16 w-auto object-contain mb-2">
                    @else
                        <div class="size-16 rounded-2xl bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-white shadow-xl rotate-3">
                            <x-lucide-command class="size-8" />
                        </div>
                    @endif
                    <h1 class="text-4xl font-black text-base-content tracking-tighter">{{ $setting->app_name ?? config('app.name') }}</h1>
                </div>

                <div class="mb-10 space-y-2">
                    <h2 class="text-4xl font-black tracking-tight text-base-content">{{ __('login.welcome') }} 👋</h2>
                    <p class="text-base-content/60 text-lg font-medium">{{ __('login.subtitle') }}</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-base-content/40 ml-1 uppercase tracking-[0.2em]">{{ __('login.label_email') }}</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-transform group-focus-within:scale-110">
                                <x-lucide-mail class="h-5 w-5 text-base-content/20 z-10 group-focus-within:text-primary" />
                            </div>
                            <input type="email" name="email" required autofocus
                                class="input input-bordered w-full h-16 pl-14 bg-base-200/50 text-base-content rounded-[1.25rem] border-transparent focus:border-primary/50 focus:bg-base-100 focus:ring-4 focus:ring-primary/10 transition-all duration-300 placeholder:text-base-content/20 font-bold text-sm"
                                placeholder="{{ __('login.placeholder_email') }}" value="{{ old('email') }}">
                        </div>
                        @error('email') <span class="text-error text-[10px] font-bold ml-2 mt-1 block uppercase tracking-wide">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-[10px] font-black text-base-content/40 ml-1 uppercase tracking-[0.2em]">{{ __('login.label_password') }}</label>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-transform group-focus-within:scale-110">
                                <x-lucide-lock-keyhole class="h-5 w-5 text-base-content/20 z-10 group-focus-within:text-primary" />
                            </div>
                            <input type="password" name="password" required
                                class="input input-bordered w-full h-16 pl-14 bg-base-200/50 text-base-content rounded-[1.25rem] border-transparent focus:border-primary/50 focus:bg-base-100 focus:ring-4 focus:ring-primary/10 transition-all duration-300 placeholder:text-base-content/20 font-bold text-sm"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                            class="btn btn-primary w-full h-16 rounded-[1.25rem] text-white font-black uppercase tracking-[0.2em] shadow-[0_20px_40px_rgba(var(--p),0.3)] hover:shadow-primary/50 hover:-translate-y-1 active:scale-95 transition-all duration-300 border-none">
                            {{ __('login.btn_login') }}
                            <x-lucide-arrow-right class="h-5 w-5 ml-2" stroke-width="3" />
                        </button>
                    </div>
                    
                    <div class="pt-8">
                        <div class="relative flex items-center justify-center">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-base-content/5"></div>
                            </div>
                            <span class="relative px-6 bg-base-100 text-[9px] font-black text-base-content/20 uppercase tracking-[0.4em]">
                                ENTERPRISE SECURED
                            </span>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</x-main.main>