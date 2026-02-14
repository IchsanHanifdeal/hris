<x-dashboard.main title="{{ __('payroll.title') }}">
    <div class="relative space-y-8 pb-12">
        {{-- Ambient Background --}}
        <div class="absolute -top-16 -right-16 -z-10 size-72 bg-primary/5 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-20 -left-20 -z-10 size-52 bg-success/5 rounded-full blur-[100px]"></div>

        {{-- Header Section --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="size-14 rounded-2xl bg-base-100 shadow-2xl flex items-center justify-center border border-white/5 ring-8 ring-primary/5 transition-transform hover:rotate-6 hover:scale-110">
                    <x-lucide-banknote class="size-7 text-primary" />
                </div>
                <div>
                    <h2 class="text-2xl font-black tracking-tighter uppercase">{{ __('payroll.title') }}</h2>
                    <p class="text-[9px] font-bold uppercase tracking-[0.2em] opacity-30 mt-1">{{ __('payroll.subtitle') }}</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Period Filter --}}
                <form action="{{ route('payrolls.index') }}" method="GET" class="flex items-center gap-2 bg-base-100/50 backdrop-blur-md p-1.5 rounded-2xl border border-white/5 shadow-inner">
                    <select name="month" onchange="this.form.submit()" class="select select-sm bg-transparent border-none font-black text-[10px] uppercase focus:outline-none rounded-xl">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" onchange="this.form.submit()" class="select select-sm bg-transparent border-none font-black text-[10px] uppercase focus:outline-none rounded-xl">
                        @for($y = now()->year - 2; $y <= now()->year + 1; $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2 bg-base-100/30 backdrop-blur-md p-1.5 rounded-2xl border border-white/5 shadow-inner">
                    <button onclick="simulation_modal.showModal()" class="btn btn-ghost btn-sm rounded-xl hover:bg-primary/10 transition-all gap-2 px-4 group">
                        <x-lucide-calculator class="size-4 opacity-40 group-hover:opacity-100 group-hover:text-primary transition-all" />
                        <span class="text-[10px] font-black uppercase hidden sm:inline">{{ __('payroll.action.simulate') }}</span>
                    </button>

                    <form action="{{ route('payrolls.batch-generate') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm rounded-xl text-white shadow-xl shadow-primary/20 hover:scale-105 active:scale-95 transition-all gap-2 px-5">
                            <x-lucide-zap class="size-4 fill-current" />
                            <span class="text-[10px] font-black uppercase">{{ __('payroll.action.sync') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <x-dashboard.card.info 
                title="{{ __('payroll.stats.disbursement') }}" 
                value="Rp {{ number_format($totalPaid, 0, ',', '.') }}" 
                icon="trending-up" 
                variant="success" />
            <x-dashboard.card.info 
                title="{{ __('payroll.stats.drafts') }}" 
                value="{{ $draftCount }}" 
                icon="layers" 
                variant="warning" />
            <x-dashboard.card.info 
                title="{{ __('payroll.stats.period') }}" 
                value="{{ \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}" 
                icon="calendar-check" 
                variant="primary" />
        </div>

        {{-- Main Table --}}
        <x-dashboard.card.table 
            title="{{ __('payroll.title') }}"
            description="{{ __('payroll.subtitle') }}" 
            tableId="payrollTable"
            :headers="[
                __('payroll.table.employee'), 
                __('payroll.table.period'), 
                __('payroll.table.breakdown'), 
                __('payroll.table.net'), 
                __('payroll.table.status'), 
                __('payroll.table.action')
            ]" 
            :paginator="$payrolls" 
        >
            @forelse ($payrolls as $payroll)
                <tr class="group/row hover:bg-primary/[0.03] border-b border-base-content/5 transition-all duration-200">
                    {{-- Employee Info --}}
                    <td class="py-5 px-5">
                        <div class="flex items-center gap-4">
                            <div class="avatar {{ $payroll->status === 'paid' ? 'online' : '' }}">
                                <div class="mask mask-squircle size-12 bg-gradient-to-tr from-primary/20 to-secondary/20 p-0.5 group-hover/row:shadow-lg group-hover/row:shadow-primary/10 transition-shadow">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($payroll->employee->user->name) }}&background=1a1a1a&color=fff&bold=true&size=128" class="mask mask-squircle" />
                                </div>
                            </div>
                            <div class="min-w-0">
                                <div class="font-black text-[13px] tracking-tight group-hover/row:text-primary transition-colors truncate">
                                    {{ $payroll->employee->user->name }}
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="badge badge-ghost border-none bg-base-200/80 text-[7px] font-black uppercase tracking-widest h-5 rounded-lg">
                                        {{ $payroll->employee->employee_code }}
                                    </span>
                                    <span class="text-[8px] font-bold opacity-25 truncate">
                                        {{ $payroll->employee->position->name ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Period --}}
                    <td class="text-center">
                        <div class="inline-flex flex-col items-center gap-1">
                            <span class="text-[10px] font-black font-mono bg-base-200/50 px-3 py-1.5 rounded-lg border border-white/5">
                                {{ $payroll->period_start->format('d/m') }} — {{ $payroll->period_end->format('d/m') }}
                            </span>
                            <span class="text-[8px] font-bold opacity-20 uppercase">
                                {{ $payroll->period_start->translatedFormat('M Y') }}
                            </span>
                        </div>
                    </td>

                    {{-- Breakdown --}}
                    <td>
                        <div class="space-y-1.5 min-w-[160px]">
                            <div class="flex items-center justify-between text-[10px]">
                                <span class="font-bold opacity-40 flex items-center gap-1.5">
                                    <span class="size-1.5 rounded-full bg-success"></span>
                                    {{ __('payroll.table.income') }}
                                </span>
                                <span class="font-black text-success">Rp {{ number_format($payroll->basic_salary + $payroll->allowances + $payroll->overtime_pay, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-[10px]">
                                <span class="font-bold opacity-40 flex items-center gap-1.5">
                                    <span class="size-1.5 rounded-full bg-error"></span>
                                    {{ __('payroll.table.cut') }}
                                </span>
                                <span class="font-black text-error">Rp {{ number_format($payroll->deductions, 0, ',', '.') }}</span>
                            </div>
                            {{-- Mini progress bar --}}
                            @php
                                $totalIncome = $payroll->basic_salary + $payroll->allowances + $payroll->overtime_pay;
                                $deductPercent = $totalIncome > 0 ? min(($payroll->deductions / $totalIncome) * 100, 100) : 0;
                            @endphp
                            <div class="w-full bg-base-200/50 rounded-full h-1 mt-1">
                                <div class="bg-gradient-to-r from-success to-success/50 h-1 rounded-full transition-all" style="width: {{ 100 - $deductPercent }}%"></div>
                            </div>
                        </div>
                    </td>

                    {{-- Net Salary --}}
                    <td class="text-center">
                        <span class="text-sm font-mono font-black text-primary bg-primary/5 px-4 py-2 rounded-xl border border-primary/10">
                            Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td class="text-center">
                        @if($payroll->status === 'paid')
                            <div class="badge badge-success border-none font-black text-[8px] uppercase px-4 py-3 rounded-xl text-white shadow-lg shadow-success/20 gap-1.5">
                                <x-lucide-check-circle class="size-3" />
                                {{ __('payroll.status.paid') }}
                            </div>
                        @else
                            <div class="badge badge-warning border-none font-black text-[8px] uppercase px-4 py-3 rounded-xl text-white shadow-lg shadow-warning/20 gap-1.5 animate-pulse">
                                <x-lucide-clock class="size-3" />
                                {{ __('payroll.status.draft') }}
                            </div>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="flex items-center gap-2 justify-center">
                            @if($payroll->status === 'draft')
                                <div class="tooltip tooltip-left" data-tip="{{ __('payroll.action.edit') }}">
                                    <button onclick="openEditPayroll('{{ $payroll->id }}', '{{ (int)$payroll->basic_salary }}', '{{ (int)$payroll->allowances }}', '{{ (int)$payroll->deductions }}')" 
                                        class="p-2.5 bg-base-200/50 text-base-content/40 hover:bg-primary/20 hover:text-primary rounded-xl transition-all hover:scale-110 active:scale-90">
                                        <x-lucide-edit-3 class="size-4" />
                                    </button>
                                </div>
                                <div class="tooltip tooltip-left" data-tip="{{ __('payroll.action.pay') }}">
                                    <form action="{{ route('payrolls.pay', $payroll->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="p-2.5 bg-success/10 text-success hover:bg-success hover:text-white rounded-xl transition-all shadow-sm hover:scale-110 active:scale-90 hover:shadow-success/30">
                                            <x-lucide-rocket class="size-4" />
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <div class="tooltip tooltip-left" data-tip="{{ __('payroll.action.print') }}">
                                <button onclick="printPayslip({{ $payroll->id }})" 
                                    class="p-2.5 bg-base-200/50 text-base-content/40 hover:bg-slate-700 hover:text-white rounded-xl transition-all hover:scale-110 active:scale-90">
                                    <x-lucide-printer class="size-4" />
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                {{-- Hidden Payslip Print Layout (Per Row) --}}
                <tr class="hidden">
                    <td colspan="6">
                        <div id="payslip_{{ $payroll->id }}" class="payslip-container">
                            <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 700px; margin: 0 auto; padding: 40px; color: #1a1a1a;">
                                {{-- Company Header --}}
                                <div style="text-align: center; border-bottom: 3px solid #1a1a1a; padding-bottom: 20px; margin-bottom: 30px;">
                                    <h1 style="font-size: 22px; font-weight: 900; letter-spacing: 2px; margin: 0; text-transform: uppercase;">{{ config('app.name', 'MyHRIS') }}</h1>
                                    <p style="font-size: 10px; letter-spacing: 4px; opacity: 0.5; margin-top: 4px; text-transform: uppercase;">{{ __('payroll.print.title') }}</p>
                                </div>

                                {{-- Employee Info Grid --}}
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 30px; font-size: 12px;">
                                    <div style="background: #f8f8f8; padding: 12px 16px; border-radius: 8px;">
                                        <span style="font-size: 9px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.4; font-weight: 700;">{{ __('payroll.print.employee_name') }}</span>
                                        <p style="font-weight: 800; margin: 4px 0 0;">{{ $payroll->employee->user->name }}</p>
                                    </div>
                                    <div style="background: #f8f8f8; padding: 12px 16px; border-radius: 8px;">
                                        <span style="font-size: 9px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.4; font-weight: 700;">{{ __('payroll.print.employee_code') }}</span>
                                        <p style="font-weight: 800; margin: 4px 0 0; font-family: monospace;">{{ $payroll->employee->employee_code }}</p>
                                    </div>
                                    <div style="background: #f8f8f8; padding: 12px 16px; border-radius: 8px;">
                                        <span style="font-size: 9px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.4; font-weight: 700;">{{ __('payroll.print.position') }}</span>
                                        <p style="font-weight: 800; margin: 4px 0 0;">{{ $payroll->employee->position->name ?? '-' }}</p>
                                    </div>
                                    <div style="background: #f8f8f8; padding: 12px 16px; border-radius: 8px;">
                                        <span style="font-size: 9px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.4; font-weight: 700;">{{ __('payroll.print.period_label') }}</span>
                                        <p style="font-weight: 800; margin: 4px 0 0;">{{ $payroll->period_start->translatedFormat('d M Y') }} — {{ $payroll->period_end->translatedFormat('d M Y') }}</p>
                                    </div>
                                </div>

                                {{-- Earnings & Deductions Table --}}
                                <table style="width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 24px;">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left; padding: 12px 16px; background: #1a1a1a; color: white; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; border-radius: 8px 0 0 0;">{{ __('payroll.print.earnings') }}</th>
                                            <th style="text-align: right; padding: 12px 16px; background: #1a1a1a; color: white; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">{{ __('payroll.table.basic') }}</th>
                                            <th style="text-align: left; padding: 12px 16px; background: #dc2626; color: white; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;">{{ __('payroll.print.deductions') }}</th>
                                            <th style="text-align: right; padding: 12px 16px; background: #dc2626; color: white; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; border-radius: 0 8px 0 0;">{{ __('payroll.table.basic') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0; font-weight: 600;">{{ __('payroll.print.basic_salary') }}</td>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0; text-align: right; font-family: monospace; font-weight: 700;">Rp {{ number_format($payroll->basic_salary, 0, ',', '.') }}</td>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0; font-weight: 600;">{{ __('payroll.print.deductions') }}</td>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0; text-align: right; font-family: monospace; font-weight: 700; color: #dc2626;">Rp {{ number_format($payroll->deductions, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0; font-weight: 600;">{{ __('payroll.print.overtime_pay') }}</td>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0; text-align: right; font-family: monospace; font-weight: 700;">Rp {{ number_format($payroll->overtime_pay, 0, ',', '.') }}</td>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0;"></td>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0;"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0; font-weight: 600;">{{ __('payroll.print.allowances') }}</td>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0; text-align: right; font-family: monospace; font-weight: 700;">Rp {{ number_format($payroll->allowances, 0, ',', '.') }}</td>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0;"></td>
                                            <td style="padding: 10px 16px; border-bottom: 1px solid #f0f0f0;"></td>
                                        </tr>
                                        <tr style="font-weight: 900;">
                                            <td style="padding: 12px 16px; border-top: 2px solid #1a1a1a;">{{ __('payroll.print.total_earnings') }}</td>
                                            <td style="padding: 12px 16px; border-top: 2px solid #1a1a1a; text-align: right; font-family: monospace;">Rp {{ number_format($payroll->basic_salary + $payroll->overtime_pay + $payroll->allowances, 0, ',', '.') }}</td>
                                            <td style="padding: 12px 16px; border-top: 2px solid #dc2626;">{{ __('payroll.print.total_deductions') }}</td>
                                            <td style="padding: 12px 16px; border-top: 2px solid #dc2626; text-align: right; font-family: monospace; color: #dc2626;">Rp {{ number_format($payroll->deductions, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                {{-- Net Salary Highlight --}}
                                <div style="background: linear-gradient(135deg, #1a1a1a, #2d2d2d); color: white; padding: 24px 28px; border-radius: 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                                    <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; opacity: 0.7;">{{ __('payroll.print.net_salary') }}</span>
                                    <span style="font-size: 26px; font-weight: 900; font-family: monospace; letter-spacing: -1px;">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</span>
                                </div>

                                {{-- Signatures --}}
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 50px; text-align: center; font-size: 11px;">
                                    <div>
                                        <p style="opacity: 0.4; font-size: 9px; text-transform: uppercase; letter-spacing: 2px;">{{ __('payroll.print.signature_employee') }}</p>
                                        <div style="border-bottom: 1px solid #ccc; height: 60px; margin: 10px auto; width: 180px;"></div>
                                        <p style="font-weight: 800;">{{ $payroll->employee->user->name }}</p>
                                    </div>
                                    <div>
                                        <p style="opacity: 0.4; font-size: 9px; text-transform: uppercase; letter-spacing: 2px;">{{ __('payroll.print.signature_hr') }}</p>
                                        <div style="border-bottom: 1px solid #ccc; height: 60px; margin: 10px auto; width: 180px;"></div>
                                        <p style="font-weight: 800;">{{ Auth::user()->name }}</p>
                                    </div>
                                </div>

                                {{-- Footer --}}
                                <div style="margin-top: 40px; padding-top: 16px; border-top: 1px solid #eee; text-align: center;">
                                    <p style="font-size: 9px; opacity: 0.3; letter-spacing: 1px;">{{ __('payroll.print.generated_at') }}: {{ now()->translatedFormat('d F Y, H:i') }}</p>
                                    <p style="font-size: 8px; opacity: 0.2; margin-top: 4px; font-style: italic;">{{ __('payroll.print.confidential') }}</p>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-32">
                        <div class="flex flex-col items-center gap-4">
                            <div class="size-20 rounded-3xl bg-base-200/50 flex items-center justify-center">
                                <x-lucide-inbox class="size-8 opacity-10" />
                            </div>
                            <p class="font-black text-[10px] uppercase tracking-[0.2em] opacity-20">{{ __('payroll.table.empty') }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-dashboard.card.table>
    </div>

    {{-- Simulation Modal --}}
    <dialog id="simulation_modal" class="modal modal-bottom sm:modal-middle backdrop-blur-md">
        <div class="modal-box bg-base-100/90 backdrop-blur-3xl rounded-[2.5rem] border border-white/10 p-0 overflow-hidden max-w-md shadow-2xl">
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-8 text-white relative overflow-hidden">
                <div class="absolute right-0 top-0 size-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
                <div class="relative z-10">
                    <div class="size-12 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center mb-4">
                        <x-lucide-calculator class="size-6" />
                    </div>
                    <h3 class="font-black text-xl tracking-tight">{{ __('payroll.modal.sim_title') }}</h3>
                    <p class="text-[9px] font-bold uppercase tracking-widest opacity-40 mt-1">{{ __('payroll.modal.sim_subtitle') }}</p>
                </div>
            </div>
            <div class="p-8 space-y-6">
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label px-1"><span class="label-text font-black text-[9px] uppercase opacity-30 tracking-widest">{{ __('payroll.modal.basic') }}</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[10px] font-black opacity-20">Rp</span>
                            <input type="text" id="sim_basic_display" oninput="formatAndSync(this, 'sim_basic_hidden'); runSimulation()" placeholder="5.000.000" class="input input-bordered w-full pl-10 bg-base-200/50 border-none rounded-xl font-bold text-xs h-12 focus:ring-2 ring-primary/20 transition-all" />
                            <input type="hidden" id="sim_basic_hidden" value="5000000">
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label px-1"><span class="label-text font-black text-[9px] uppercase opacity-30 tracking-widest">{{ __('payroll.modal.allowance') }}</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[10px] font-black opacity-20">Rp</span>
                            <input type="text" id="sim_allow_display" oninput="formatAndSync(this, 'sim_allow_hidden'); runSimulation()" placeholder="0" class="input input-bordered w-full pl-10 bg-base-200/50 border-none rounded-xl font-bold text-xs h-12 focus:ring-2 ring-primary/20 transition-all" />
                            <input type="hidden" id="sim_allow_hidden" value="0">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label px-1"><span class="label-text font-black text-[9px] uppercase opacity-30 tracking-widest">{{ __('payroll.modal.late_count') }}</span></label>
                        <input type="number" id="sim_late" oninput="runSimulation()" placeholder="0" min="0" class="input bg-error/5 border border-error/10 rounded-xl font-bold text-xs h-12 text-center focus:ring-2 ring-error/20 transition-all" />
                        <p class="text-[8px] text-error/50 font-bold mt-1 px-1">{{ __('payroll.modal.late_penalty') }}: Rp 35.000</p>
                    </div>
                    <div class="form-control">
                        <label class="label px-1"><span class="label-text font-black text-[9px] uppercase opacity-30 tracking-widest">{{ __('payroll.modal.absent_count') }}</span></label>
                        <input type="number" id="sim_absent" oninput="runSimulation()" placeholder="0" min="0" class="input bg-error/5 border border-error/10 rounded-xl font-bold text-xs h-12 text-center focus:ring-2 ring-error/20 transition-all" />
                        <p class="text-[8px] text-error/50 font-bold mt-1 px-1">{{ __('payroll.modal.absent_penalty') }}: Rp 100.000</p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-[2rem] p-8 border border-primary/10 text-center space-y-2">
                    <p class="text-[9px] font-black uppercase tracking-widest opacity-30">{{ __('payroll.modal.net_result') }}</p>
                    <h4 id="sim_result" class="text-3xl font-black text-primary tracking-tighter">Rp 0</h4>
                </div>

                <button onclick="simulation_modal.close()" class="btn btn-ghost w-full rounded-2xl font-black uppercase text-[10px] h-12 opacity-50 hover:opacity-100 bg-error transition-all">
                    {{ __('payroll.modal.btn_close') }}
                </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop bg-base-content/40 backdrop-blur-sm"><button>close</button></form>
    </dialog>

    {{-- Edit Payroll Modal --}}
    <dialog id="edit_payroll_modal" class="modal modal-bottom sm:modal-middle backdrop-blur-md">
        <div class="modal-box bg-base-100/90 backdrop-blur-3xl rounded-[2.5rem] border border-white/10 p-0 overflow-hidden max-w-sm shadow-2xl">
            <div class="bg-gradient-to-br from-primary to-primary-focus p-8 text-white relative overflow-hidden">
                <div class="absolute right-0 top-0 size-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
                <div class="relative z-10">
                    <div class="size-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center mb-4">
                        <x-lucide-edit-3 class="size-6" />
                    </div>
                    <h3 class="font-black text-xl tracking-tight">{{ __('payroll.modal.edit_title') }}</h3>
                    <p class="text-[9px] font-bold uppercase tracking-widest opacity-50 mt-1">{{ __('payroll.modal.edit_subtitle') }}</p>
                </div>
            </div>
            <form id="edit_payroll_form" action="" method="POST" class="p-8 space-y-5">
                @csrf @method('PATCH')
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label px-1"><span class="label-text font-black text-[9px] uppercase opacity-30 tracking-widest">{{ __('payroll.modal.basic') }}</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[10px] font-black opacity-20">Rp</span>
                            <input type="text" id="edit_basic_display" oninput="formatAndSync(this, 'edit_basic_hidden')" class="input input-bordered w-full pl-10 bg-base-200/50 border-none rounded-xl font-bold text-xs h-12 focus:ring-2 ring-primary/20 transition-all" />
                            <input type="hidden" id="edit_basic_hidden" name="basic_salary" />
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label px-1"><span class="label-text font-black text-[9px] uppercase opacity-30 tracking-widest">{{ __('payroll.modal.allowance') }}</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[10px] font-black opacity-20">Rp</span>
                            <input type="text" id="edit_allow_display" oninput="formatAndSync(this, 'edit_allow_hidden')" class="input input-bordered w-full pl-10 bg-base-200/50 border-none rounded-xl font-bold text-xs h-12 focus:ring-2 ring-primary/20 transition-all" />
                            <input type="hidden" id="edit_allow_hidden" name="allowances" />
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label px-1"><span class="label-text font-black text-[9px] uppercase opacity-30 tracking-widest text-error">{{ __('payroll.modal.deduction') }}</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[10px] font-black opacity-20">Rp</span>
                            <input type="text" id="edit_deduct_display" oninput="formatAndSync(this, 'edit_deduct_hidden')" class="input input-bordered w-full pl-10 bg-error/5 border border-error/10 rounded-xl font-bold text-xs h-12 focus:ring-2 ring-error/20 transition-all" />
                            <input type="hidden" id="edit_deduct_hidden" name="deductions" />
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="edit_payroll_modal.close()" class="btn btn-ghost flex-1 rounded-2xl font-black uppercase text-[10px] h-14 opacity-50">
                        {{ __('payroll.modal.btn_close') }}
                    </button>
                    <button type="submit" class="btn btn-primary flex-[2] rounded-2xl text-white font-black uppercase text-[10px] h-14 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        <x-lucide-save class="size-4 mr-2" />
                        {{ __('payroll.modal.btn_update') }}
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop bg-base-content/40 backdrop-blur-sm"><button>close</button></form>
    </dialog>

    <style>
        @media print {
            body * { visibility: hidden !important; }
            .payslip-print-area, .payslip-print-area * { visibility: visible !important; }
            .payslip-print-area { 
                position: absolute; left: 0; top: 0; width: 100%; 
                background: white !important; z-index: 99999; 
            }
            @page { margin: 15mm; size: A4; }
        }
    </style>

    <div id="print_area" class="payslip-print-area hidden"></div>

    <script>
        // Currency Format & Sync
        function formatAndSync(el, hiddenId) {
            let val = el.value.replace(/\D/g, "");
            if (val === "") {
                el.value = "";
                document.getElementById(hiddenId).value = 0;
                return;
            }
            document.getElementById(hiddenId).value = val;
            el.value = new Intl.NumberFormat('id-ID').format(val);
        }

        // Edit Payroll Modal
        function openEditPayroll(id, basic, allow, deduct) {
            const form = document.getElementById('edit_payroll_form');
            form.action = `/dashboard/payrolls/${id}`;

            document.getElementById('edit_basic_display').value = basic;
            document.getElementById('edit_allow_display').value = allow;
            document.getElementById('edit_deduct_display').value = deduct;

            formatAndSync(document.getElementById('edit_basic_display'), 'edit_basic_hidden');
            formatAndSync(document.getElementById('edit_allow_display'), 'edit_allow_hidden');
            formatAndSync(document.getElementById('edit_deduct_display'), 'edit_deduct_hidden');

            edit_payroll_modal.showModal();
        }

        // Live Salary Simulator
        function runSimulation() {
            const basic = parseFloat(document.getElementById('sim_basic_hidden').value) || 0;
            const allowance = parseFloat(document.getElementById('sim_allow_hidden').value) || 0;
            const late = parseInt(document.getElementById('sim_late').value) || 0;
            const absent = parseInt(document.getElementById('sim_absent').value) || 0;

            const net = (basic + allowance) - (late * 35000) - (absent * 100000);
            document.getElementById('sim_result').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.max(net, 0));
        }

        // Print Payslip Function
        function printPayslip(id) {
            const source = document.getElementById('payslip_' + id);
            if (!source) return;

            const printArea = document.getElementById('print_area');
            printArea.innerHTML = source.innerHTML;
            printArea.classList.remove('hidden');

            setTimeout(() => {
                window.print();
                setTimeout(() => {
                    printArea.classList.add('hidden');
                    printArea.innerHTML = '';
                }, 500);
            }, 300);
        }
    </script>
</x-dashboard.main>