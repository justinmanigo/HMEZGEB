<?php

namespace App\Actions;

use App\Models\AccountingSystem;
use App\Models\AccountingSystemUser;
use App\Models\Settings\ChartOfAccounts\JournalEntries;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAccountingSystem
{
    use AsAction;

    public function handle($request, $subscription)
    {
        $accounting_system = $this->create($request, $subscription);
        
        $as_user = $this->addUserAndPermission($accounting_system->id, $subscription->account_type);

        GenerateAccountingPeriods::run($accounting_system->id, $request->calendar_type, $request->accounting_year, $as_user->id);

        $this->initJournalEntry($accounting_system->id);
        $this->initWithholding($accounting_system->id);
        $this->initOvertimePayrollRules($accounting_system->id);
        $this->initIncomeTaxPayrollRules($accounting_system->id);

        return [
            'accounting_system' => $accounting_system,
            'accounting_system_user' => $as_user,
        ];
    }

    private function create($request, $subscription)
    {
        return AccountingSystem::create([
            'name' => $request->name,
            'subscription_id' => $subscription->id,
            'vat_number' => $request->vat_number,
            'tin_number' => $request->tin_number,
            'business_type' => $request->business_type,
            'address' => $request->address,
            'po_box' => $request->po_box,
            'city' => $request->city,
            'country' => $request->country,
            'mobile_number' => $request->mobile_number,
            'telephone_1' => $request->telephone_1,
            'telephone_2' => $request->telephone_2,
            'fax' => $request->fax,
            'website' => $request->website,
            'contact_person' => $request->contact_person,
            'contact_person_position' => $request->contact_person_position,
            'contact_person_mobile_number' => $request->contact_person_mobile_number,
            'calendar_type' => $request->calendar_type,
            'accounting_year' => $request->accounting_year,
            'settings_inventory_type' => 'average',
        ]);
    }

    private function addUserAndPermission($id, $role)
    {
        $user = AccountingSystemUser::create([
            'accounting_system_id' => $id,
            'user_id' => auth()->user()->id,
            // 'role' => $role == 'super admin' ? 'admin' : $role,
            //! Temporarily disabled due to changes in database structure.
        ]);

        // Loop permissions
        for($j = 1; $j <= 24; $j++)
        {
            $permissions[] = [
                'accounting_system_user_id' => $user->id,
                'access_level' => 'rw',
                'sub_module_id' => $j,
            ];
        }

        DB::table('permissions')->insert($permissions);

        return $user;
    }

    private function initJournalEntry($id)
    {
        // Get first date of accounting year
        $accounting_periods = \App\Models\Settings\ChartOfAccounts\AccountingPeriods::where('accounting_system_id', $id)->get();

        $firstDate = $accounting_periods[0]->date_from;

        JournalEntries::create([
            'date' => $firstDate,
            'accounting_system_id' => $id,
            'notes' => 'Beginning Balance',
        ]);
    }

    private function initWithholding($id)
    {
        DB::table('withholdings')->insert([
            [
                'accounting_system_id' => $id,
                'name' => 'Withholding',
                'percentage' => 2,
            ]
        ]);
    }

    private function initOvertimePayrollRules($id)
    {
        $overtime_payroll_rules[] = [
            'accounting_system_id' => $id,
            'working_days' => 26,
            'working_hours' => 8,
            'day_rate' => 1.25,
            'night_rate' => 1.50,
            'holiday_weekend_rate' => 2.00
        ];

        DB::table('overtime_payroll_rules')->insert($overtime_payroll_rules);
    }

    private function initIncomeTaxPayrollRules($id)
    {
        DB::table('income_tax_payroll_rules')->insert([
            [
                'accounting_system_id' => $id,
                'income' => 10900,
                'rate' => 35,
                'deduction' => 1500
            ],
            [
                'accounting_system_id' => $id,
                'income' => 7800,
                'rate' => 30,
                'deduction' => 955
            ],
            [
                'accounting_system_id' => $id,
                'income' => 5250,
                'rate' => 25,
                'deduction' => 565
            ],
            [
                'accounting_system_id' => $id,
                'income' => 3200,
                'rate' => 20,
                'deduction' => 302.5
            ],
            [
                'accounting_system_id' => $id,
                'income' => 1650,
                'rate' => 15,
                'deduction' => 142.5
            ],
            [
                'accounting_system_id' => $id,
                'income' => 600,
                'rate' => 10,
                'deduction' => 60
            ],
        ]);
    }
}
