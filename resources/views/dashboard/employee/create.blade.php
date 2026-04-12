<x-dashboard.main title="{{ __('employee.modal.add_title') }}">
    <div class="max-w-6xl mx-auto">
        
        <div class="mb-8">
            <a href="{{ route('employees.index') }}" class="btn btn-ghost btn-sm rounded-xl gap-2 opacity-50 hover:opacity-100 transition-all font-bold">
                <x-lucide-arrow-left class="size-4" />
                {{ __('actions.back') }}
            </a>
        </div>

        <form action="{{ route('employees.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf

            <div class="lg:col-span-4 space-y-6">
                <div class="bg-base-100/50 backdrop-blur-xl rounded-[2.5rem] p-8 border border-base-content/5 shadow-sm relative overflow-hidden h-full">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/5 rounded-full blur-3xl"></div>
                    
                    <div class="flex items-center gap-4 mb-10">
                        <div class="size-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                            <x-lucide-shield-check class="size-7" />
                        </div>
                        <div>
                            <h3 class="font-black text-xl tracking-tight">Account</h3>
                            <p class="text-[10px] font-bold opacity-30 uppercase tracking-[0.2em]">Security Info</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="form-control group">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 italic">{{ __('employee.modal.label_name') }}</span></label>
                            <label class="input input-bordered flex items-center gap-4 bg-base-200/50 border-base-content/5 rounded-2xl h-14 focus-within:border-primary transition-all shadow-inner">
                                <x-lucide-user class="size-4 opacity-20" />
                                <input type="text" name="name" value="{{ old('name') }}" class="grow font-bold bg-transparent border-none focus:ring-0 text-sm" placeholder="{{ __('employee.modal.placeholder_name') }}" required />
                            </label>
                            @error('name') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control group">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 italic">{{ __('employee.modal.label_email') }}</span></label>
                            <label class="input input-bordered flex items-center gap-4 bg-base-200/50 border-base-content/5 rounded-2xl h-14 focus-within:border-primary transition-all shadow-inner">
                                <x-lucide-mail class="size-4 opacity-20" />
                                <input type="email" name="email" value="{{ old('email') }}" class="grow font-bold bg-transparent border-none focus:ring-0 text-sm" placeholder="{{ __('employee.modal.placeholder_email') }}" required />
                            </label>
                            @error('email') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control group">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40 italic">System Language</span></label>
                            <label class="input input-bordered flex items-center gap-4 bg-base-200/50 border-base-content/5 rounded-2xl h-14 focus-within:border-primary transition-all shadow-inner">
                                <x-lucide-languages class="size-4 opacity-20" />
                                <select name="locale" class="grow font-bold bg-transparent border-none focus:ring-0 text-sm appearance-none cursor-pointer">
                                    <option value="id" {{ old('locale', 'id') == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                    <option value="en" {{ old('locale') == 'en' ? 'selected' : '' }}>English (US)</option>
                                </select>
                            </label>
                            @error('locale') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-base-100 rounded-[2.5rem] p-10 border border-base-content/5 shadow-2xl relative overflow-hidden">
                    <div class="flex items-center gap-4 mb-10 pb-6 border-b border-base-content/5">
                        <div class="size-14 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary shadow-inner">
                            <x-lucide-contact class="size-7" />
                        </div>
                        <div>
                            <h3 class="font-black text-2xl tracking-tight">Employment Details</h3>
                            <p class="text-[10px] font-bold opacity-30 uppercase tracking-[0.2em]">Personal & Work Info</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="form-control">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">{{ __('employee.modal.label_gender') }}</span></label>
                            <select name="gender" class="select select-bordered bg-base-200/50 rounded-2xl h-14 font-bold text-sm focus:border-secondary transition-all" required>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('employee.gender.male') }}</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('employee.gender.female') }}</option>
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">{{ __('employee.modal.label_dept') }}</span></label>
                            <select name="department_id" class="select select-bordered bg-base-200/50 rounded-2xl h-14 font-bold text-sm focus:border-secondary transition-all" required>
                                <option disabled {{ old('department_id') ? '' : 'selected' }}>---</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">{{ __('employee.modal.label_position') }}</span></label>
                            <select name="position_id" class="select select-bordered bg-base-200/50 rounded-2xl h-14 font-bold text-sm focus:border-secondary transition-all w-full" required>
                                <option disabled {{ old('position_id') ? '' : 'selected' }}>---</option>
                                @foreach($positions as $pos)
                                    <option value="{{ $pos->id }}" {{ old('position_id') == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                                @endforeach
                            </select>
                            @error('position_id') <span class="text-error text-[10px] mt-2 ml-2 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-control mt-6">
                        <label class="label px-1"><span class="label-text font-black text-[10px] uppercase opacity-40">{{ __('employee.modal.label_address') }}</span></label>
                        <textarea name="address" class="textarea textarea-bordered bg-base-200/50 rounded-2xl min-h-[100px] font-bold text-sm w-full focus:border-secondary transition-all" placeholder="{{ __('employee.modal.placeholder_address') }}" required>{{ old('address') }}</textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 mt-12 pt-8 border-t border-base-content/5">
                        <button type="submit" class="btn btn-primary flex-[2] h-16 rounded-2xl text-white shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all font-black uppercase tracking-[0.2em]">
                            <x-lucide-save class="size-5 mr-2" />
                            {{ __('employee.modal.btn_save') }}
                        </button>
                        <a href="{{ route('employees.index') }}" class="btn btn-ghost flex-1 h-16 rounded-2xl font-black uppercase tracking-[0.1em] text-xs opacity-50">
                            {{ __('actions.cancel') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-dashboard.main>