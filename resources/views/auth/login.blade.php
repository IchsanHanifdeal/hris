<x-main.main>
    <div class="min-h-screen w-full flex bg-base-100 text-base-content font-sans">

        <div class="hidden lg:flex w-7/12 relative bg-base-300 overflow-hidden flex-col justify-between p-20">
            
            <div class="absolute inset-0 opacity-10" 
                 style="background-image: radial-gradient(currentColor 1.5px, transparent 1.5px); background-size: 48px 48px;">
            </div>

            <div class="absolute top-0 left-0 w-[30rem] h-[30rem] bg-primary/20 rounded-full blur-[140px] animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-[30rem] h-[30rem] bg-secondary/10 rounded-full blur-[140px] animate-pulse delay-1000"></div>

            <div class="relative z-10 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center shadow-2xl shadow-primary/20 ring-1 ring-white/10">
                    <x-lucide-command class="w-8 h-8 text-white" stroke-width="2" />
                </div>
                <span class="text-3xl font-bold tracking-wide">{{ config('app.name', 'HRIS PRO') }}</span>
            </div>

            <div class="relative z-10 space-y-6">
                <h1 class="text-6xl font-black leading-tight tracking-tight">
                    {{ __('login.hero_title_1') }} <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">
                        {{ __('login.hero_title_2') }}
                    </span>
                </h1>
                <p class="text-base-content/60 text-xl leading-relaxed max-w-lg">
                    {{ __('login.hero_description') }}
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-4 text-sm font-medium text-base-content/40">
                <span>&copy; {{ date('Y') }} Enterprise System</span>
                <span class="w-1 h-1 rounded-full bg-base-content/40"></span>
                <span>v1.0.0</span>
            </div>
        </div>

        <div class="w-full lg:w-5/12 flex items-center justify-center p-8 sm:p-16 xl:p-24 bg-base-100 relative">
            
            <div class="absolute top-8 right-8 z-50">
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-sm glass border-base-content/10 gap-2 text-base-content/80 hover:bg-base-200/50 shadow-sm">
                        <span class="text-lg">
                            {{ app()->getLocale() == 'id' ? '🇮🇩' : '🇺🇸' }}
                        </span>
                        <span class="uppercase font-bold text-xs tracking-wider">{{ app()->getLocale() }}</span>
                        <x-lucide-chevron-down class="w-3 h-3 opacity-50" />
                    </div>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-2xl bg-base-100 rounded-xl w-40 mt-3 border border-base-content/5">
                        <li><a href="{{ route('lang.switch', 'id') }}" class="{{ app()->getLocale() == 'id' ? 'bg-base-200' : '' }} font-medium">🇮🇩 Indonesia</a></li>
                        <li><a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'bg-base-200' : '' }} font-medium">🇺🇸 English</a></li>
                    </ul>
                </div>
            </div>

            <div class="w-full max-w-md">
                <div class="lg:hidden text-center mb-12">
                    <h1 class="text-4xl font-black text-primary tracking-tighter">{{ config('app.name') }}</h1>
                </div>

                <div class="mb-10 space-y-2">
                    <h2 class="text-4xl font-bold tracking-tight text-base-content">{{ __('login.welcome') }} 👋</h2>
                    <p class="text-base-content/60 text-lg">{{ __('login.subtitle') }}</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-7">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-base-content/80 ml-1 uppercase tracking-wide text-[11px]">{{ __('login.label_email') }}</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <x-lucide-mail class="h-5 w-5 text-base-content/30 z-10" />
                            </div>
                            <input type="email" name="email" required autofocus
                                class="input input-bordered w-full h-auto py-4 pl-12 bg-base-200/50 text-base-content rounded-2xl border-transparent focus:border-primary focus:bg-base-100 focus:ring-4 focus:ring-primary/10 transition-all duration-300 placeholder:text-base-content/30 font-medium"
                                placeholder="{{ __('login.placeholder_email') }}" value="{{ old('email') }}">
                        </div>
                        @error('email') <span class="text-error text-xs font-semibold ml-1 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-bold text-base-content/80 ml-1 uppercase tracking-wide text-[11px]">{{ __('login.label_password') }}</label>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <x-lucide-lock-keyhole class="h-5 w-5 text-base-content/30 z-10" />
                            </div>
                            <input type="password" name="password" required
                                class="input input-bordered w-full h-auto py-4 pl-12 bg-base-200/50 text-base-content rounded-2xl border-transparent focus:border-primary focus:bg-base-100 focus:ring-4 focus:ring-primary/10 transition-all duration-300 placeholder:text-base-content/30 font-medium"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" 
                        class="btn btn-primary w-full h-auto py-4 rounded-2xl text-white font-bold text-lg shadow-xl shadow-primary/20 hover:shadow-primary/40 hover:-translate-y-1 transition-all duration-300 border-none">
                        {{ __('login.btn_login') }}
                        <x-lucide-arrow-right class="h-5 w-5 ml-2" stroke-width="3" />
                    </button>
                    
                    <div class="pt-6">
                        <div class="relative flex items-center justify-center">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-base-content/10"></div>
                            </div>
                            <span class="relative px-4 bg-base-100 text-xs font-semibold text-base-content/40 uppercase tracking-widest">
                                Secured by Enterprise Guard
                            </span>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</x-main.main>