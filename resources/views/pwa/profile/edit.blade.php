<x-pwa.main>
    <div class="flex flex-col gap-8 pb-32 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Identity Header -->
        <div class="relative px-2">
            <div class="absolute -inset-2 bg-gradient-to-tr from-primary/20 via-secondary/10 to-primary/20 rounded-[3rem] blur-3xl opacity-50"></div>
            <div class="relative flex flex-col items-center gap-4">
                <div class="group relative">
                    <div class="absolute -inset-1.5 bg-gradient-to-tr from-primary/30 to-secondary/30 rounded-[2.5rem] blur-md opacity-0 group-hover:opacity-100 transition-all duration-700"></div>
                    <div class="relative w-28 h-28 rounded-[2rem] p-1 bg-gradient-to-tr from-primary/20 via-transparent to-secondary/20 border border-base-content/5 shadow-2xl overflow-hidden bg-base-100 ring-1 ring-base-content/5">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff&bold=true&size=256" 
                             alt="{{ auth()->user()->name }}"
                             class="w-full h-full object-cover rounded-[1.75rem] transition-transform duration-700 group-hover:scale-110" />
                    </div>
                    <div class="absolute -bottom-1 -right-1 size-8 bg-primary rounded-2xl border-4 border-base-100 flex items-center justify-center text-white shadow-lg">
                        <x-lucide-camera class="size-4" />
                    </div>
                </div>
                
                <div class="text-center flex flex-col gap-1">
                    <h1 class="text-xl font-black text-base-content uppercase tracking-tight group-hover:text-primary transition-colors">
                        {{ auth()->user()->name }}
                    </h1>
                    <div class="flex items-center justify-center gap-2">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-primary/70">{{ auth()->user()->employee->position->name ?? 'Employee' }}</span>
                        <div class="size-1 rounded-full bg-base-content/20"></div>
                        <span class="text-[10px] font-bold uppercase tracking-widest opacity-40">{{ auth()->user()->employee->employee_code ?? 'EMP-000' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forms & Info -->
        <form method="post" action="{{ route('profile.update') }}" class="flex flex-col gap-6">
            @csrf
            @method('patch')

            <!-- Personal Data Section -->
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3 px-2">
                    <div class="h-4 w-1 bg-primary rounded-full"></div>
                    <h3 class="text-[11px] font-black uppercase tracking-[0.2em] opacity-40">Personal Identity</h3>
                </div>

                <div class="bg-base-100/50 backdrop-blur-xl border border-base-content/5 rounded-[2.5rem] p-6 flex flex-col gap-5 shadow-sm">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest opacity-30 ml-4">Full Name</label>
                        <div class="relative group">
                            <x-lucide-user class="absolute left-5 top-1/2 -translate-y-1/2 size-4 opacity-20 group-focus-within:opacity-100 group-focus-within:text-primary transition-all" />
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                                   class="w-full h-14 pl-12 pr-6 rounded-2xl bg-base-content/[0.02] border-none ring-1 ring-base-content/5 focus:ring-2 focus:ring-primary/40 transition-all text-sm font-bold tracking-tight" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest opacity-30 ml-4">Email Address</label>
                        <div class="relative group">
                            <x-lucide-mail class="absolute left-5 top-1/2 -translate-y-1/2 size-4 opacity-20 group-focus-within:opacity-100 group-focus-within:text-primary transition-all" />
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                                   class="w-full h-14 pl-12 pr-6 rounded-2xl bg-base-content/[0.02] border-none ring-1 ring-base-content/5 focus:ring-2 focus:ring-primary/40 transition-all text-sm font-bold tracking-tight" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest opacity-30 ml-4">Phone Number</label>
                        <div class="relative group">
                            <x-lucide-phone class="absolute left-5 top-1/2 -translate-y-1/2 size-4 opacity-20 group-focus-within:opacity-100 group-focus-within:text-primary transition-all" />
                            <input type="text" name="phone" value="{{ old('phone', auth()->user()->employee->phone ?? '') }}" 
                                   class="w-full h-14 pl-12 pr-6 rounded-2xl bg-base-content/[0.02] border-none ring-1 ring-base-content/5 focus:ring-2 focus:ring-primary/40 transition-all text-sm font-bold tracking-tight" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Details (Read Only) -->
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3 px-2">
                    <div class="h-4 w-1 bg-secondary rounded-full"></div>
                    <h3 class="text-[11px] font-black uppercase tracking-[0.2em] opacity-40">Employment Status</h3>
                </div>

                <div class="bg-base-200/40 border border-base-content/5 rounded-[2.5rem] p-6 flex flex-col gap-6">
                    <div class="flex justify-between items-center group/card">
                        <div class="flex items-center gap-4">
                            <div class="size-10 rounded-xl bg-base-content/5 flex items-center justify-center text-base-content/40 group-hover/card:bg-primary/20 group-hover/card:text-primary transition-all">
                                <x-lucide-building-2 class="size-5" />
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-widest opacity-30">Department</span>
                                <span class="text-xs font-black uppercase tracking-tight">{{ auth()->user()->employee->department->name ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center group/card">
                        <div class="flex items-center gap-4">
                            <div class="size-10 rounded-xl bg-base-content/5 flex items-center justify-center text-base-content/40 group-hover/card:bg-secondary/20 group-hover/card:text-secondary transition-all">
                                <x-lucide-briefcase class="size-5" />
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-widest opacity-30">Position</span>
                                <span class="text-xs font-black uppercase tracking-tight">{{ auth()->user()->employee->position->name ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="px-3 py-1 rounded-full bg-success/10 text-success text-[8px] font-black uppercase tracking-[0.2em]">Active Partner</div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="px-2 mt-2">
                <button type="submit" class="group relative w-full h-16 rounded-3xl bg-primary text-white overflow-hidden shadow-xl shadow-primary/30 transition-all duration-300 active:scale-95">
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-center justify-center gap-3">
                        <x-lucide-save class="size-5" />
                        <span class="text-sm font-black uppercase tracking-[0.2em]">Update Identity</span>
                    </div>
                </button>
            </div>
        </form>

        <!-- Security: Change Password -->
        <form method="post" action="{{ route('password.update') }}" class="flex flex-col gap-6">
            @csrf
            @method('put')

            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3 px-2">
                    <div class="h-4 w-1 bg-accent rounded-full"></div>
                    <h3 class="text-[11px] font-black uppercase tracking-[0.2em] opacity-40">Security Access</h3>
                </div>

                <div class="bg-base-100/50 backdrop-blur-xl border border-base-content/5 rounded-[2.5rem] p-6 flex flex-col gap-5 shadow-sm">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest opacity-30 ml-4">Current Password</label>
                        <div class="relative group">
                            <x-lucide-lock class="absolute left-5 top-1/2 -translate-y-1/2 size-4 opacity-20 group-focus-within:opacity-100 group-focus-within:text-accent transition-all" />
                            <input type="password" name="current_password" placeholder="••••••••"
                                   class="w-full h-14 pl-12 pr-6 rounded-2xl bg-base-content/[0.02] border-none ring-1 ring-base-content/5 focus:ring-2 focus:ring-accent/40 transition-all text-sm font-bold tracking-tight" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest opacity-30 ml-4">New Password</label>
                        <div class="relative group">
                            <x-lucide-shield-check class="absolute left-5 top-1/2 -translate-y-1/2 size-4 opacity-20 group-focus-within:opacity-100 group-focus-within:text-accent transition-all" />
                            <input type="password" name="password" placeholder="Min. 8 characters"
                                   class="w-full h-14 pl-12 pr-6 rounded-2xl bg-base-content/[0.02] border-none ring-1 ring-base-content/5 focus:ring-2 focus:ring-accent/40 transition-all text-sm font-bold tracking-tight" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest opacity-30 ml-4">Confirm New Password</label>
                        <div class="relative group">
                            <x-lucide-shield-check class="absolute left-5 top-1/2 -translate-y-1/2 size-4 opacity-20 group-focus-within:opacity-100 group-focus-within:text-accent transition-all" />
                            <input type="password" name="password_confirmation" placeholder="Confirm password"
                                   class="w-full h-14 pl-12 pr-6 rounded-2xl bg-base-content/[0.02] border-none ring-1 ring-base-content/5 focus:ring-2 focus:ring-accent/40 transition-all text-sm font-bold tracking-tight" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-2">
                <button type="submit" class="group relative w-full h-16 rounded-3xl bg-accent text-accent-content overflow-hidden shadow-xl shadow-accent/20 transition-all duration-300 active:scale-95">
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-center justify-center gap-3">
                        <x-lucide-key-round class="size-5" />
                        <span class="text-sm font-black uppercase tracking-[0.2em]">Secure Session</span>
                    </div>
                </button>
            </div>
        </form>

        <!-- Logout Action -->
        <div class="px-2">
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="group w-full h-16 rounded-3xl bg-error/5 hover:bg-error/10 border-2 border-error/20 flex items-center justify-center gap-4 transition-all duration-300 active:scale-95">
                    <div class="size-10 rounded-2xl bg-error/10 flex items-center justify-center text-error group-hover:bg-error group-hover:text-white transition-all duration-500">
                        <x-lucide-log-out class="size-5" />
                    </div>
                    <span class="text-sm font-black uppercase tracking-[0.2em] text-error group-hover:tracking-[0.3em] transition-all duration-500">Terminate Session</span>
                </button>
            </form>
        </div>

        <div class="text-center px-4 pb-12">
            <p class="text-[9px] font-bold text-base-content/20 uppercase tracking-[0.4em]">Engineered for Excellence &bull; Version 2.4.0</p>
        </div>
    </div>
</x-pwa.main>