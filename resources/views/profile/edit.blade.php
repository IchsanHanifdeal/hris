<x-dashboard.main title="{{ __('profile.edit') }}">
    <div class="relative space-y-6 pb-12">
        
        <div class="absolute -top-12 -right-12 -z-10 size-64 bg-primary/5 rounded-full blur-[80px]"></div>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 px-2">
            <div class="flex items-center gap-4">
                <div class="size-12 rounded-2xl bg-base-100 shadow-lg flex items-center justify-center border border-white/5">
                    <x-lucide-user-cog class="size-6 text-primary" />
                </div>
                <div>
                    <h1 class="text-xl font-black tracking-tight uppercase">{{ __('profile.edit') }}</h1>
                    <p class="text-[9px] font-bold uppercase opacity-30 tracking-widest mt-0.5">Manage your digital identity</p>
                </div>
            </div>

            <div class="flex items-center gap-1 bg-base-100/50 backdrop-blur-xl p-1 rounded-xl border border-white/5 shadow-sm">
                <a href="{{ url('lang/id') }}" 
                   class="btn btn-xs rounded-lg px-4 border-none {{ app()->getLocale() == 'id' ? 'btn-primary shadow-sm' : 'btn-ghost opacity-40' }}">
                    ID
                </a>
                <a href="{{ url('lang/en') }}" 
                   class="btn btn-xs rounded-lg px-4 border-none {{ app()->getLocale() == 'en' ? 'btn-primary shadow-sm' : 'btn-ghost opacity-40' }}">
                    EN
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <div class="lg:col-span-4 lg:sticky lg:top-6">
                <div class="card bg-base-100/40 backdrop-blur-2xl border border-white/5 shadow-xl rounded-[2.5rem] overflow-hidden">
                    <div class="h-24 bg-gradient-to-tr from-primary/10 to-secondary/10 relative"></div>
                    
                    <div class="px-6 pb-8 -mt-12 text-center relative z-10">
                        <div class="relative inline-block">
                            <div class="mask mask-squircle w-28 h-28 bg-base-100 p-1 shadow-xl">
                                <div class="mask mask-squircle w-full h-full bg-gradient-to-br from-primary to-secondary p-0.5">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1a1a1a&color=fff&bold=true&size=256" 
                                         class="mask mask-squircle object-cover w-full h-full" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h2 class="text-lg font-black tracking-tight">{{ auth()->user()->name }}</h2>
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] text-primary bg-primary/10 py-1.5 px-4 rounded-lg mt-2 inline-block">
                                {{ auth()->user()->employee->position->name ?? 'Core Developer' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 gap-2 mt-6">
                            <div class="flex items-center gap-3 p-3 bg-base-200/40 rounded-2xl border border-white/5">
                                <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                    <x-lucide-hash class="size-3.5" />
                                </div>
                                <div class="text-left">
                                    <p class="text-[7px] font-black uppercase opacity-20">Employee Node</p>
                                    <p class="text-xs font-bold font-mono">{{ auth()->user()->employee->employee_code ?? 'EMP-001' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-base-200/40 rounded-2xl border border-white/5">
                                <div class="size-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary">
                                    <x-lucide-mail class="size-3.5" />
                                </div>
                                <div class="text-left overflow-hidden">
                                    <p class="text-[7px] font-black uppercase opacity-20">Network Path</p>
                                    <p class="text-xs font-bold truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-6">
                
                <div class="card bg-base-100/50 backdrop-blur-2xl border border-white/5 shadow-lg rounded-[2.5rem] overflow-hidden">
                    <div class="p-6 md:p-8">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="size-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-md">
                                <x-lucide-id-card class="size-5" />
                            </div>
                            <h3 class="text-base font-black tracking-widest uppercase italic">{{ __('profile.personal_info') }}</h3>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                            @csrf @method('PATCH')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-control">
                                    <label class="label px-1 mb-1 text-[9px] font-black uppercase tracking-widest opacity-30">Identity Name</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                                        class="input input-bordered bg-base-200/30 border-none rounded-xl font-bold text-xs h-12 px-5 transition-all focus:ring-2 ring-primary/20" />
                                </div>
                                <div class="form-control">
                                    <label class="label px-1 mb-1 text-[9px] font-black uppercase tracking-widest opacity-30">Email Protocol</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                                        class="input input-bordered bg-base-200/30 border-none rounded-xl font-bold text-xs h-12 px-5 transition-all focus:ring-2 ring-primary/20" />
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-primary btn-sm rounded-xl px-8 h-10 text-[10px] font-black uppercase tracking-widest shadow-md hover:scale-105 active:scale-95 transition-all">
                                    {{ __('profile.btn_save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card bg-base-100/50 backdrop-blur-2xl border border-white/5 shadow-lg rounded-[2.5rem] overflow-hidden relative">
                    <div class="p-6 md:p-8 relative z-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="size-10 rounded-xl bg-error flex items-center justify-center text-white shadow-md">
                                <x-lucide-fingerprint class="size-5" />
                            </div>
                            <h3 class="text-base font-black tracking-widest uppercase italic">{{ __('profile.security') }}</h3>
                        </div>

                        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                            @csrf @method('PUT')
                            
                            <div class="form-control max-w-xs">
                                <label class="label px-1 mb-1 text-[9px] font-black uppercase tracking-widest opacity-30">{{ __('profile.current_password') }}</label>
                                <input type="password" name="current_password" placeholder="••••••••" 
                                    class="input input-bordered bg-base-200/30 border-none rounded-xl font-bold text-xs h-12 px-5 transition-all focus:ring-2 ring-error/20" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-control">
                                    <label class="label px-1 mb-1 text-[9px] font-black uppercase tracking-widest opacity-30">{{ __('profile.new_password') }}</label>
                                    <input type="password" name="password" placeholder="••••••••" 
                                        class="input input-bordered bg-base-200/30 border-none rounded-xl font-bold text-xs h-12 px-5 transition-all focus:ring-2 ring-primary/20" />
                                </div>
                                <div class="form-control">
                                    <label class="label px-1 mb-1 text-[9px] font-black uppercase tracking-widest opacity-30">{{ __('profile.confirm_password') }}</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••" 
                                        class="input input-bordered bg-base-200/30 border-none rounded-xl font-bold text-xs h-12 px-5 transition-all focus:ring-2 ring-primary/20" />
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-error btn-sm rounded-xl px-8 h-10 text-[10px] font-black uppercase tracking-widest shadow-md hover:scale-105 active:scale-95 transition-all">
                                    {{ __('profile.btn_save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.main>