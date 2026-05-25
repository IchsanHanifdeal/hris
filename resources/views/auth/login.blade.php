<x-main.main>
    @php $setting = \App\Models\Setting::first(); @endphp
    <div class="min-h-screen w-full flex items-center justify-center bg-base-200 text-base-content font-sans relative overflow-hidden p-4 sm:p-8">

        {{-- Premium background glows --}}
        <div class="absolute -top-40 -left-40 w-[30rem] h-[30rem] bg-primary/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute -bottom-40 -right-40 w-[30rem] h-[30rem] bg-secondary/10 rounded-full blur-[120px] animate-pulse delay-1000"></div>

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

        {{-- Card login --}}
        <div class="w-full max-w-md bg-base-100 rounded-[2.5rem] border border-base-content/5 shadow-2xl relative z-10 p-8 sm:p-12 overflow-hidden">
            
            {{-- App Logo and Name --}}
            <div class="text-center mb-8 flex flex-col items-center gap-4">
                @if($setting && $setting->app_logo)
                    <img src="{{ asset('storage/' . $setting->app_logo) }}" class="h-16 w-auto object-contain mb-2">
                @else
                    <div class="size-16 rounded-2xl bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-white shadow-xl rotate-3">
                        <x-lucide-command class="size-8" />
                    </div>
                @endif
                <h1 class="text-3xl font-black text-base-content tracking-tighter">{{ $setting->app_name ?? config('app.name', 'HRIS PRO') }}</h1>
            </div>

            {{-- Welcome headers --}}
            <div class="mb-8 space-y-2 text-center">
                <h2 class="text-2xl font-black tracking-tight text-base-content">{{ __('login.welcome') }} 👋</h2>
                <p class="text-base-content/60 text-sm font-medium">{{ __('login.subtitle') }}</p>
            </div>

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Email Input --}}
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

                {{-- Password Input --}}
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

                {{-- Submit button --}}
                <div class="pt-2">
                    <button type="submit" 
                        class="btn btn-primary w-full h-16 rounded-[1.25rem] text-white font-black uppercase tracking-[0.2em] shadow-[0_20px_40px_rgba(var(--p),0.3)] hover:shadow-primary/50 hover:-translate-y-1 active:scale-95 transition-all duration-300 border-none">
                        {{ __('login.btn_login') }}
                        <x-lucide-arrow-right class="h-5 w-5 ml-2" stroke-width="3" />
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-main.main>