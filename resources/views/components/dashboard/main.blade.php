@php $setting = \App\Models\Setting::first(); @endphp
<x-main.main title="{{ $title ?? ($setting->app_name ?? 'HRIS Dashboard') }}">

    @if (Auth::check() && Auth::user()->hasRole('karyawan') && !Auth::user()->employee)
        
       <div class="flex items-center justify-center min-h-screen bg-base-300 px-4 py-12 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
                <div class="absolute top-[-5%] left-[-5%] w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] animate-pulse"></div>
                <div class="absolute bottom-[-5%] right-[-5%] w-[500px] h-[500px] bg-secondary/10 rounded-full blur-[120px] animate-pulse delay-1000"></div>
            </div>

            <div class="w-full max-w-3xl bg-base-100/80 backdrop-blur-2xl rounded-[2.5rem] shadow-2xl border border-white/10 p-8 sm:p-12 relative z-10">

                <div class="mb-10 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-tr from-primary to-secondary mb-6 shadow-2xl shadow-primary/20 rotate-3">
                        <x-lucide-user-plus class="w-10 h-10 text-white -rotate-3" />
                    </div>
                    <h2 class="text-4xl font-black text-base-content tracking-tight mb-2">
                        {{ __('profile.welcome') }}, <span class="text-primary">{{ Auth::user()->name }}</span>
                    </h2>
                </div>

                <form method="POST" action="{{ route('employees.store_self') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-4">
                        <div class="flex items-center gap-2 px-1">
                            <x-lucide-contact class="w-5 h-5 text-primary" />
                            <span class="text-sm font-bold uppercase tracking-widest text-base-content/40">Personal Information</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-control">
                                <label class="label"><span class="label-text font-bold">{{ __('profile.phone') }}</span></label>
                                <label class="input input-bordered focus-within:outline-primary flex items-center gap-3 bg-base-200/40 border-none h-14 rounded-2xl">
                                    <x-lucide-phone class="w-5 h-5 opacity-30" />
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="grow font-medium" placeholder="08123456789" required />
                                </label>
                                @error('phone') <span class="text-error text-xs mt-1 ml-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-bold">{{ __('profile.gender') }}</span></label>
                                <div class="join w-full h-14 bg-base-200/40 rounded-2xl p-1 border-none">
                                    <input class="join-item btn flex-1 !border-none checked:!bg-primary checked:!text-white hover:bg-primary/20" type="radio" name="gender" value="male" aria-label="Laki-laki" checked />
                                    <input class="join-item btn flex-1 !border-none checked:!bg-primary checked:!text-white hover:bg-primary/20" type="radio" name="gender" value="female" aria-label="Perempuan" />
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-bold">{{ __('profile.place_of_birth') }}</span></label>
                                <label class="input input-bordered focus-within:outline-primary flex items-center gap-3 bg-base-200/40 border-none h-14 rounded-2xl">
                                    <x-lucide-map-pin class="w-5 h-5 opacity-30" />
                                    <input type="text" name="place_of_birth" value="{{ old('place_of_birth') }}" class="grow" placeholder="Jakarta" required />
                                </label>
                            </div>

                            <div class="form-control">
                                <label class="label"><span class="label-text font-bold">{{ __('profile.date_of_birth') }}</span></label>
                                <label class="input input-bordered focus-within:outline-primary flex items-center gap-3 bg-base-200/40 border-none h-14 rounded-2xl">
                                    <x-lucide-calendar class="w-5 h-5 opacity-30" />
                                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="grow" required />
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-bold">{{ __('profile.address') }}</span></label><br>
                            <textarea name="address" class="textarea textarea-bordered w-full bg-base-200/40 border-none rounded-2xl h-28 focus:outline-secondary leading-relaxed p-4" placeholder="Alamat lengkap domisili saat ini..." required>{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-4 pt-6 border-t border-base-content/5">
                        <button type="button" onclick="logout_modal.showModal()" class="btn btn-ghost w-full sm:w-auto h-14 px-8 rounded-2xl text-error hover:bg-error/10">
                            <x-lucide-log-out class="w-5 h-5 mr-2" />
                            {{ __('profile.btn_cancel') }}
                        </button>
                        <button type="submit" class="btn btn-primary flex-1 w-full h-14 rounded-2xl text-white shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                            <x-lucide-check-circle class="w-5 h-5 mr-2" />
                            {{ __('profile.btn_save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <dialog id="logout_modal" class="modal modal-bottom sm:modal-middle transition-all duration-300">
            <div class="modal-box bg-base-100/80 backdrop-blur-2xl border border-base-content/10 rounded-[2rem] shadow-2xl p-8">
                
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="w-20 h-20 rounded-3xl bg-error/10 flex items-center justify-center text-error mb-2 rotate-3 hover:rotate-0 transition-transform duration-500">
                        <x-lucide-log-out class="w-10 h-10" />
                    </div>
                    
                    <h3 class="font-black text-2xl text-base-content tracking-tight">
                        {{ __('menu.logout_confirm_title') }}
                    </h3>
                    
                    <p class="text-base-content/60 leading-relaxed max-w-xs">
                        {{ __('menu.logout_confirm_msg') }}
                    </p>
                </div>

                <div class="modal-action grid grid-cols-2 gap-4 mt-8">
                    <form method="dialog" class="w-full">
                        <button class="btn btn-ghost w-full h-14 rounded-2xl border border-base-content/5 hover:bg-base-200 transition-all font-bold">
                            {{ __('menu.cancel') }}
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="btn btn-error w-full h-14 rounded-2xl text-white shadow-xl shadow-error/20 hover:scale-[1.02] active:scale-95 transition-all font-bold">
                            {{ __('menu.yes_logout') }}
                        </button>
                    </form>
                </div>

                <form method="dialog" class="absolute right-4 top-4">
                    <button class="btn btn-sm btn-circle btn-ghost opacity-30 hover:opacity-100">
                        <x-lucide-x class="w-4 h-4" />
                    </button>
                </form>
            </div>

            <form method="dialog" class="modal-backdrop bg-base-900/60 backdrop-blur-md transition-all duration-500">
                <button>close</button>
            </form>
        </dialog>
    @else 
        <div class="drawer lg:drawer-open bg-base-200 min-h-screen">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col">
                @include('components.dashboard.navbar')
                <main class="flex-1 p-6 lg:p-10 animate-fade-in">
                    <div class="max-w-full mb-6 space-y-3">
                        @if (session('success'))
                            <div x-data="{ show: true }" x-show="show" 
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                class="alert alert-success shadow-lg border-l-4 border-success-content/20 bg-success/20 text-success-content">
                                <x-lucide-check-circle class="size-5 text-white" />
                                <span class="font-bold text-sm text-white">{{ session('success') }}</span>
                                <button @click="show = false" class="btn btn-ghost btn-xs btn-circle ml-auto">
                                    <x-lucide-x class="size-4" />
                                </button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div x-data="{ show: true }" x-show="show"
                                class="alert alert-error shadow-lg border-l-4 border-error-content/20 bg-error/20 text-error-content">
                                <x-lucide-alert-circle class="size-5" />
                                <span class="font-bold text-sm text-white">{{ session('error') }}</span>
                                <button @click="show = false" class="btn btn-ghost btn-xs btn-circle ml-auto">
                                    <x-lucide-x class="size-4" />
                                </button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div x-data="{ show: true }" x-show="show"
                                class="alert alert-warning shadow-lg border-l-4 border-warning-content/20 bg-warning/20 text-warning-content">
                                <x-lucide-alert-triangle class="size-5" />
                                <div class="flex flex-col text-white">
                                    <span class="font-bold text-sm">Aduh, ada input yang ngaco:</span>
                                    <ul class="text-xs list-disc list-inside opacity-80">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button @click="show = false" class="btn btn-ghost btn-xs btn-circle ml-auto">
                                    <x-lucide-x class="size-4" />
                                </button>
                            </div>
                        @endif
                    </div>
                    {{ $slot }}
                </main>
                @include('components.dashboard.footer')
            </div> 
            @include('components.dashboard.aside')
        </div>
    <!-- @endif -->

</x-main.main>