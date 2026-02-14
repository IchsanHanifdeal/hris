<nav class="navbar sticky top-0 z-30 flex h-16 w-full justify-center bg-base-100/60 backdrop-blur-xl border-b border-base-content/5">
    <div class="flex w-full items-center justify-between px-4">
        
        <div class="flex items-center gap-2">
            <label for="my-drawer-2" class="btn btn-ghost btn-square lg:hidden">
                <x-lucide-menu class="w-6 h-6" />
            </label>

            <div class="hidden sm:inline-block text-sm breadcrumbs px-2">
                <ul class="text-base-content/60 font-medium">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">
                            <x-lucide-home class="w-4 h-4 mr-2" />
                            HRIS
                        </a>
                    </li>
                    <li class="text-base-content capitalize">
                        {{ str_replace('.', ' / ', Request::route()->getName()) }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex items-center gap-3">
            
            <div class="hidden md:flex relative group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-base-content/30 group-focus-within:text-primary transition-colors">
                    <x-lucide-search class="w-4 h-4" />
                </div>
                <input type="text" id="searchInput" 
                       placeholder="{{ __('actions.search') }}" 
                       class="input input-sm input-bordered z-10 w-64 pl-10 bg-base-200/50 border-transparent rounded-xl transition-all" />
            </div>

            <div class="dropdown dropdown-end ml-2">
                <div tabindex="0" role="button" class="flex items-center gap-3 p-1 pl-3 pr-1 rounded-2xl border border-base-content/10 hover:bg-base-200 transition-all active:scale-95 bg-base-200/30 group">
                    <div class="flex flex-col items-end hidden sm:flex">
                        <span class="text-xs font-bold leading-none">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] opacity-50 uppercase tracking-tighter mt-1">{{ Auth::user()->getRoleNames()->first() ?? 'Staff' }}</span>
                    </div>
                    <div class="avatar">
                        <div class="w-9 rounded-xl ring ring-primary/20 ring-offset-base-100 ring-offset-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=ff79c6&background=44475a" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>