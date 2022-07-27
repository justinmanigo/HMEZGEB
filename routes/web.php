<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;

// Home
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReferralsController;

// Customer module
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepositController;
// Banking module
use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\TransfersController;
use App\Http\Controllers\DepositsController;
use App\Http\Controllers\TransactionsController;  
// Vendor module
use App\Http\Controllers\BillsController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\PaymentsController; 
// Journal module
use App\Http\Controllers\JournalVouchersController; 
// Human Resource module

// Inventory module
use App\Http\Controllers\InventoryController; 
// Settings module


use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;   
use Illuminate\Support\Facades\Auth;

// Human Resource Module
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\AdditionController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\LoanController;

// Settings
use App\Http\Controllers\Settings\TaxController;
use App\Http\Controllers\Settings\ManageUsersController;
use App\Http\Controllers\Settings\ChartOfAccountsController;
use App\Http\Controllers\Settings\PayrollRulesController;
use App\Http\Controllers\Settings\InventoryController as InventorySettingsController;
use App\Http\Controllers\Settings\WithholdingController;

// Account Settings
use App\Http\Controllers\AccountSettings\AccountSettingsController;

// Reports
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Settings\CompanyInfoController;

// Notifications
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Settings\DefaultsController;
 
//Register
use App\Http\Controllers\RegisterController;

// Control Panel
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\Subscription\SummaryController;
// Subscription Panel
use App\Http\Controllers\Subscription\ManageAccountingSystemsController;
use App\Http\Controllers\Subscription\ManageSubscriptionUsersController;

;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware' => 'auth',
], function(){
    /**
     * Switch Accounting Systems
     */
    Route::get('/switch', [HomeController::class, 'viewAccountingSystems']);
    Route::put('/switch', [HomeController::class, 'switchAccountingSystem']);
    
    /**
     * Notification
     */
    Route::resource('notifications', NotificationController::class);

    Route::group([
        'middleware' => 'auth.accountingsystem',
    ], function(){
        /**
         * Home
         */
        Route::get('/', [HomeController::class, 'index']);
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        
        /**===================== ACCOUNT MODULES =====================**/

        /**
         * Referral Module
         */
        Route::group([
            'as' => 'referrals.'
        ], function(){
            Route::get('/referrals', [ReferralsController::class, 'index'])->name('index');
            Route::post('/referrals', [ReferralsController::class, 'storeNormalReferral'])->name('store.normal');
            Route::put('/referrals', [ReferralsController::class, 'storeAdvancedReferral'])->name('store.advanced');
            Route::patch('/referrals', [ReferralsController::class, 'generateReferrals'])->name('generate');
        });

        /**
         * Account Settings Module
         */
        Route::group([
            'as' => 'account.'
        ], function() {
            // HTTP
            Route::get('/account/', [AccountSettingsController::class, 'index'])->name('index');
            Route::post('/account/2fa/confirm', [AccountSettingsController::class, 'confirm2FA'])->name('confirm2FA');

            // AJAX
            Route::post('/ajax/account/show/recoverycodes', [AccountSettingsController::class, 'showRecoveryCodes']);
            Route::put('/ajax/account/update/username', [AccountSettingsController::class, 'updateUsername']);
            Route::put('/ajax/account/update/email', [AccountSettingsController::class, 'updateEmail']);
            Route::put('/ajax/account/update/password', [AccountSettingsController::class, 'updatePassword']);
        });

        /**
         * Subscription Module
         */
        Route::group([
            'as' => 'subscription.',
            'middleware' => 'auth.subscription',
        ], function(){
            // HTML
            Route::get('/subscription', [SummaryController::class, 'index'])->name('subscription.index');
            Route::get('/subscription/accounting-systems', [ManageAccountingSystemsController::class, 'index'])->name('subscription.accountingSystems.index');
            Route::post('/ajax/subscription/accounting-systems/select-subscription/', [ManageAccountingSystemsController::class, 'ajaxSelectSubscription']);

            Route::get('/subscription/users', [ManageSubscriptionUsersController::class, 'index']);


            // AJAX
            Route::group([
                'as', 'ajax.',
                'prefix' => 'ajax/subscription/user',
            ], function(){
                Route::get('/get/{user}', [ManageSubscriptionUsersController::class, 'ajaxGetUser']);
                Route::get('/u/{subscriptionUser}', [ManageSubscriptionUsersController::class, 'ajaxGetSubscriptionUser']);
                Route::get('/search/{query?}', [ManageSubscriptionUsersController::class, 'ajaxSearchUser']);
                Route::get('/get/accounting-systems/{subscription}', [ManageSubscriptionUsersController::class, 'ajaxGetAccountingSystems']);

                // Part 1: When adding new user.
                Route::post('/add/new', [ManageSubscriptionUsersController::class, 'ajaxAddNewUser']); 
                Route::post('/add/existing', [ManageSubscriptionUsersController::class, 'ajaxAddExistingUser']);

                // Part 2: Adding access after adding new user.
                Route::post('/add/access/{subscriptionUser}', [ManageSubscriptionUsersController::class, 'ajaxAddAccess']);

                // TODO: Editing a user. Both parts are merged since there is already an ID.
                Route::get('/edit/{subscriptionUser}', [ManageSubscriptionUsersController::class, 'ajaxEditUser']);
                Route::put('/update/{subscriptionUser}', [ManageSubscriptionUsersController::class, 'ajaxUpdateUser']);

                Route::delete('/remove/{subscriptionUser}', [ManageSubscriptionUsersController::class, 'ajaxRemoveUser']);
            });
        });

        /**===================== SIDEBAR MODULES =====================**/

        /**
         * Customers Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
        ], function(){

            /**
             * Customers > Receipts
             */
            Route::group([
                'as'=>'receipts.'
            ], function(){
                Route::get('/customers/receipts/', [ReceiptController::class, 'index'])->name('receipt.index');
                
                // Store
                Route::post('/receipt',[ReceiptController::class,'storeReceipt'])->name('receipt.store');
                Route::post('/advance-receipt',[ReceiptController::class,'storeAdvanceRevenue'])->name('advanceReceipt.store');
                Route::post('/credit-receipt',[ReceiptController::class,'storeCreditReceipt'])->name('creditReceipt.store');
                Route::post('/proforma',[ReceiptController::class,'storeProforma'])->name('proforma.store');
        
                Route::get('/receipt/csv',[ReceiptController::class,'exportReceipts'])->name('export.csv');
                Route::delete('/receipt/{id}', [ReceiptController::class, 'destroy']);
                Route::get('/receipt/{id}', [ReceiptController::class, 'edit']);
                Route::put('/receipt/{id}', [ReceiptController::class, 'update']);
        
                /** AJAX Calls */
                Route::get('/ajax/customer/receipt/proforma/search/{customer}/{value}', [ReceiptController::class, 'ajaxSearchCustomerProforma']);
                Route::get('/ajax/customer/receipt/proforma/get/{proforma}', [ReceiptController::class, 'ajaxGetProforma']);
                Route::get('/ajax/get/receipts', [ReceiptController::class, 'ajaxGetReceiptCashTransactions']);
            });
        
            /**
             * Customers > Customers
             */
            Route::group([
                'as'=>'customers.'
            ], function(){ 
                Route::get('/customers/customers/', [CustomerController::class, 'index']);
                Route::post('/customers/customers/', [CustomerController::class, 'store']); 
                Route::get('/customers/customers/{id}', [CustomerController::class, 'edit']);
                Route::put('/customers/customers/{id}', [CustomerController::class, 'update']);
                Route::delete('/customers/customers/{id}', [CustomerController::class, 'destroy']);
            
                Route::get('/customers/export/csv', [CustomerController::class, 'toCSV'])->name('customers.export.csv');
                Route::get('/select/search/customer/{query}', [CustomerController::class, 'queryCustomers']);
                Route::get('/ajax/customer/receipts/topay/{customer}', [CustomerController::class, 'ajaxGetReceiptsToPay']);
            });
        
            /**
             * Customers > Deposits
             */
            Route::group([
                'as'=>'deposits.'
            ], function(){ 
                Route::get('/customers/deposits/', [DepositsController::class, 'index']);
                Route::get('/ajax/customer/deposit/bank/search/{query}', [DepositsController::class, 'ajaxSearchBank']);
                // RESOURCE
                Route::resource('/deposits', DepositsController::class);
                
            });
        });

        /**
         * Vendors Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
        ], function(){
            
            /**
             * Vendors > Bills
             */
            Route::group([
                'as'=>'bills.'
            ], function(){ 
                // HTML
                Route::get('/vendors/bills/', [BillsController::class, 'index'])->name('bill.index');
                Route::post('/bill',[BillsController::class,'storeBill'])->name('bill.store');
                Route::get('/individual-bill',[BillsController::class,'show'])->name('bill.show');
                Route::post('/purchaseorder',[BillsController::class,'storePurchaseOrder'])->name('purchaseOrder.store');

                // AJAX
                Route::get('/ajax/vendor/bill/purchase-order/search/{vendor}/{value}', [VendorsController::class, 'ajaxSearchVendorPurchaseOrder']);
                Route::get('/ajax/vendor/bill/purchase-order/get/{purchaseOrder}', [VendorsController::class, 'ajaxGetPurchaseOrder']);
            });
        
            /**
             * Vendors > Payments
             */
            Route::group([
                'as'=>'payments.'
            ], function(){ 
                // HTML
                Route::get('/vendors/payments',[PaymentsController::class,'index']);
                Route::post('/payment/bill',[PaymentsController::class,'storeBillPayment'])->name('billPayment.store');
                Route::post('/payment/income_tax',[PaymentsController::class,'storeIncomeTaxPayment'])->name('incomeTax.store');  
                Route::post('/payment/pension',[PaymentsController::class,'storePensionPayment'])->name('pension.store');
                Route::post('/payment/withholding',[PaymentsController::class,'storeWithholdingPayment'])->name('withholdingPayment.store');
        
                // AJAX
                Route::get('/ajax/vendor/payments/topay/{vendor}', [VendorsController::class, 'ajaxGetPaymentsToPay']);
                Route::get('/ajax/vendor/withholding/topay/{vendor}', [VendorsController::class, 'ajaxGetWithholdingToPay']);
                

            });
        
            /**
             * Vendors > Vendors
             */
            Route::group([
                'as'=>'vendors.'
            ], function(){ 
                // HTML
                Route::get('/vendors/vendors/',[VendorsController::class,'index']);
                Route::get('/vendors/{id}',[VendorsController::class,'edit'])->name('vendors.edit');
                Route::post('/vendors/{id}',[VendorsController::class,'update'])->name('vendors.update');
                Route::delete('/vendors/{id}',[VendorsController::class,'destroy'])->name('vendors.destroy');
                Route::post('/vendors', [VendorsController::class, 'store'])->name('vendors.store');
                
                // AJAX
                Route::get('/select/search/vendor/{query}', [VendorsController::class, 'queryVendors']);
                Route::get('/vendors/export/csv', [VendorsController::class, 'toCSV'])->name('vendors.export.csv');
            });
        });

        /**
         * Banking Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
        ], function(){

            /**
             * Banking > Accounts
             */
            Route::group([
                'as'=>'accounts.'
            ], function(){ 
                // HTML
                Route::get('/banking/accounts', [BankAccountsController::class, 'index']);
                Route::get('/banking/accounts/{id}', [BankAccountsController::class, 'edit'])->name('bank.accounts.edit');
         
                // RESOURCE
                Route::resource('/banking/accounts', BankAccountsController::class);
            });
        
            /**
             * Banking > Transfer
             */
            Route::group([
                'as'=>'transfers.'
            ], function(){ 
                // HTML
                Route::get('/banking/transfer', [TransfersController::class, 'index']);
                Route::get('/ajax/search/bank/{query}', [TransfersController::class, 'queryBank']);

                // RESOURCE
                Route::resource('/banking/transfer', TransfersController::class);
            });
        
            /**
             * Banking > Deposits
             * Same content as Customer > Deposits
             */
            Route::group([
                'as'=>'deposits.'
            ], function(){ 
                // HTML
                Route::redirect('/banking/deposits', '/customers/deposits');    
            });
        
            /**
             * Banking > Transactions
             */
            Route::group([
                'as'=>'transactions.'
            ], function(){ 
                // HTML
                Route::get('/banking/transactions', [TransactionsController::class, 'index']);
            });

            /**
             * TODO: Banking > Bank Reconcilation
             */
            
        });

        /**
         * Journal Vouchers Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
            'as'=>'journals.'
        ], function(){ 
            // HTML
            Route::get('/jv/', [JournalVouchersController::class, 'index'])->name('index');
            Route::get('/journals/{journalVoucher}', [JournalVouchersController::class, 'show'])->name('show');
            Route::post('/journals', [JournalVouchersController::class, 'store'])->name('store');
        });

        /**
         * Inventory Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
            'as'=>'inventory.'
        ], function(){ 
            // HTML
            Route::get('/inventory/', [InventoryController::class, 'index']);
            Route::post('/inventory', [InventoryController::class, 'store']);
            Route::get('/inventory/{inventory}', [InventoryController::class, 'show']);
            Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit']);
            Route::put('/inventory/{inventory}', [InventoryController::class, 'update']);
            Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy']);
        
            // AJAX
            Route::get('/select/search/inventory/{query}', [InventoryController::class, 'ajaxSearchInventory']);
        });

        /**
         * Human Resource Module
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
        ], function(){

            /**
             * Human Resource > Payrolls
             */
            Route::group([
                'as' => 'payrolls.'
            ], function(){
                // HTML
                Route::resource('/hr/payrolls', PayrollController::class);
            });
        
            /**
             * Human Resource > Employees
             */
            Route::group([
                'as' => 'employees.'
            ], function(){
                // HTML
                Route::get('/hr/employees', [EmployeeController::class, 'index'])->name('index');
                Route::post('/employee', [EmployeeController::class, 'store'])->name('store');
                Route::get('/employee/{id}', [EmployeeController::class, 'edit']);
                Route::put('/employee/{employee}', [EmployeeController::class, 'update'])->name('update');
                Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');

                // AJAX
                Route::get('/select/search/employee/{query}', [EmployeeController::class, 'queryEmployees']);
                Route::get('/ajax/hr/employees/get/{employee}', [EmployeeController::class, 'ajaxGetEmployee']);
                Route::get('/ajax/employee/commission/topay/{employee}', [EmployeeController::class, 'ajaxSearchCommission']);
            });
        
            /**
             * Human Resource > Overtime
             */
            Route::group([
                'as' => 'overtime.'
            ], function(){
                // HTML
                Route::get('/hr/overtime', [OvertimeController::class, 'index']);
                Route::post('/overtime', [OvertimeController::class, 'store'])->name('store');
                Route::delete('/overtime/{id}', [OvertimeController::class, 'destroy']);
            });
        
            /**
             * Human Resource > Additions
             */
            Route::group([
                'as' => 'additions.'
            ], function(){
                // HTML
                Route::get('/hr/addition', [AdditionController::class, 'index']);
                Route::post('/addition', [AdditionController::class, 'store'])->name('store');
                Route::delete('/addition/{id}', [AdditionController::class, 'destroy']);
            });
        
            /**
             * Human Resource > Deductions
             */
            Route::group([
                'as' => 'deductions.'
            ], function(){
                // HTML
                Route::get('/hr/deduction', [DeductionController::class, 'index']);
                Route::post('/deduction', [DeductionController::class, 'store'])->name('store');
                Route::delete('/deduction/{id}', [DeductionController::class, 'destroy']);
            });
        
            /**
             * Human Resource > Loans
             */
            Route::group([
                'as' => 'loans.'
            ], function(){
                // HTML
                Route::get('/hr/loan', [LoanController::class, 'index']);
                Route::post('/loan', [LoanController::class, 'store'])->name('store');
                Route::delete('/loan/{id}', [LoanController::class, 'destroy']);
            });
        });

        /**
         * Reports Module
         */
        Route::group([
            'as' => 'reports.',
            'prefix' => 'reports'
        ], function() {
            // HTTP
            // Views
            Route::get('/customers', [ReportsController::class, 'customers'])->name('customers');
            Route::get('/vendors', [ReportsController::class, 'vendors'])->name('vendors');
            Route::get('/sales', [ReportsController::class, 'sales'])->name('sales');
            Route::get('/entries', [ReportsController::class, 'entries'])->name('entries');
            Route::get('/financial_statement', [ReportsController::class, 'financial_statement'])->name('financial_statement');
            
            // pdf
            // customers
            Route::post('/customers/aged_receivable/pdf', [ReportsController::class, 'agedReceivablePDF'])->name('aged_receivable.pdf');
            Route::post('/customers/cash_receipts_journal/pdf', [ReportsController::class, 'cashReceiptsJournalPDF'])->name('cash_receipts_journal.pdf');
            Route::post('/customers/ledgers/pdf', [ReportsController::class, 'customerLedgersPDF'])->name('customer_ledgers.pdf');

            // vendors
            Route::post('/vendors/aged_payables/pdf', [ReportsController::class, 'agedPayablesPDF'])->name('aged_payables.pdf');
            Route::post('/vendors/cash_disbursements_journal/pdf', [ReportsController::class, 'cashDisbursementsJournalPDF'])->name('cash_disbursements_journal.pdf');
            Route::post('/vendors/cash_requirements/pdf', [ReportsController::class, 'cashRequirementsPDF'])->name('cash_requirements.pdf');
            Route::post('/vendors/ledgers/pdf', [ReportsController::class, 'vendorLedgersPDF'])->name('vendor_ledgers.pdf');
            
            // sales
            Route::post('/sales/pdf', [ReportsController::class, 'salesPDF'])->name('sales.pdf');
            
            // entries
            Route::post('/entries/bill/pdf', [ReportsController::class, 'billPDF'])->name('bill.pdf');
            Route::post('/entries/general_journal/pdf', [ReportsController::class, 'generalJournalPDF'])->name('general_journal.pdf');
            Route::post('/entries/general_ledger/pdf', [ReportsController::class, 'generalLedgerPDF'])->name('general_ledger.pdf');
            Route::post('/entries/payment/pdf', [ReportsController::class, 'paymentPDF'])->name('payment.pdf');
            Route::post('/entries/receipt/pdf', [ReportsController::class, 'receiptPDF'])->name('receipt.pdf');
            Route::post('/entries/journal_voucher/pdf', [ReportsController::class, 'journalVoucherPDF'])->name('journal_voucher.pdf');

            
            // financial statement
            Route::post('/financial_statement/balance/pdf', [ReportsController::class, 'balanceSheetPDF'])->name('balance_sheet.pdf');
            Route::post('/financial_statement/balance/zero_account/pdf', [ReportsController::class, 'balanceSheetZeroAccountPDF'])->name('balance_sheet_zero_account.pdf');
            Route::post('/financial_statement/income_statement_single/pdf', [ReportsController::class, 'incomeStatementSinglePDF'])->name('income_statement_single.pdf');
            Route::post('/financial_statement/income_statement_multiple/pdf', [ReportsController::class, 'incomeStatementMultiplePDF'])->name('income_statement_multiple.pdf');
        });
            
        /**
         * Settings Module
         */
        Route::group([
            'as' => 'settings.'
        ], function() {

            /**
             * Settings > Company Info
             */
            Route::group([
                'as' => 'company.'
            ], function(){
                // HTTP
                Route::get('/settings/company', [CompanyInfoController::class, 'index'])->name('index');

                // AJAX
                Route::put('/settings/company', [CompanyInfoController::class, 'updateAjax'])->name('updateAjax');
            });

            /**
             * Settings > Users
             */
            Route::group([
                'as' => 'users.'
            ], function() {
                // HTTP
                Route::get('/settings/users', [ManageUsersController::class, 'index'])->name('manageUsers');
                Route::get('/settings/users/{accountingSystemUser}/permissions', [ManageUsersController::class, 'editPermissions'])->name('editPermissions');
                Route::put('/settings/users/{accountingSystemUser}/permissions', [ManageUsersController::class, 'updatePermissions'])->name('updatePermissions');
            });

            /**
            * Settings > Themes
            */
            Route::group([
                'as' => 'themes.'
            ], function() {
                // HTTP
                Route::view('/settings/themes', 'settings.themes.index')->name('index');
            });

            /**
            * Settings > Taxes
            */
            Route::group([
                'as' => 'tax.'
            ], function() {
                // HTTP
                Route::get('/settings/taxes', [TaxController::class, 'index'])->name('index');
                Route::post('/settings/taxes', [TaxController::class, 'store'])->name('store');
                Route::put('/settings/taxes/{tax}', [TaxController::class, 'update'])->name('update');
                Route::delete('/settings/taxes/{tax}', [TaxController::class, 'destroy'])->name('destroy');

                // AJAX
                Route::get('/ajax/settings/taxes/get/{tax}', [TaxController::class, 'ajaxGetTax']);
                Route::get('/ajax/settings/taxes/search/{query}', [TaxController::class, 'ajaxSearchTax']);
            });

            /**
            * Settings > Withholding
            */
            Route::group([
                'as' => 'withholding.'
            ], function(){
                // HTTP
                Route::get('/settings/withholding', [WithholdingController::class, 'index'])->name('index');
                Route::post('/settings/withholding', [WithholdingController::class, 'store'])->name('store');
                Route::put('/settings/withholding/{withholding}', [WithholdingController::class, 'update'])->name('update');
                Route::delete('/settings/withholding/{withholding}', [WithholdingController::class, 'destroy'])->name('destroy');

                // AJAX
                Route::get('/ajax/settings/withholding/get/{withholding}', [WithholdingController::class, 'ajaxGetWithholding']);
            });


            /**
            * Settings > Payroll Rules
            */
            Route::group([
                'as' => 'payroll.'
            ], function(){
                // HTTP
                Route::get('/settings/payroll', [PayrollRulesController::class, 'index'])->name('index');
                Route::post('/settings/payroll/update/incometax', [PayrollRulesController::class, 'updateIncomeTaxRules'])->name('updateIncomeTaxRules');
                Route::post('/settings/payroll/update/overtime', [PayrollRulesController::class, 'updateOvertimeRules'])->name('updateOvertimeRules');
            });

            /**
            * Settings > Chart of Accounts
            */
            Route::group([
                'as' => 'coa.'
            ], function() {
                // HTTP
                Route::get('/settings/coa', [ChartOfAccountsController::class, 'index'])->name('index');
                Route::post('/settings/coa', [ChartOfAccountsController::class, 'store'])->name('store');
                
                // AJAX
                Route::get('/ajax/settings/coa/search/{query?}', [ChartOfAccountsController::class, 'ajaxSearchCOA']);
                Route::get('/ajax/settings/coa_categories/search', [ChartOfAccountsController::class, 'ajaxSearchCategories']);
                Route::get('/ajax/settings/coa_categories/search/{query}', [ChartOfAccountsController::class, 'ajaxSearchCategories']);
                Route::get('/ajax/settings/coa/beginning-balance', [ChartOfAccountsController::class, 'ajaxGetCOAForBeginningBalance']);
                Route::post('/ajax/settings/coa/beginning-balance', [ChartOfAccountsController::class, 'storeBeginningBalance']);
            });

            /**
            * Settings > Inventory
            */
            Route::group([
                'as' => 'inventory.'
            ], function(){
                // HTTP
                Route::get('/settings/inventory', [InventorySettingsController::class, 'index'])->name('index');
                Route::put('/settings/inventory', [InventorySettingsController::class, 'store'])->name('store');            
            });

            /**
            * Settings > Defaults
            */
            Route::group([
                'as' => 'defaults.'
            ], function(){
                // HTTP
                Route::get('/settings/defaults', [DefaultsController::class, 'index'])->name('index');

                // AJAX
                Route::group([
                    'as' => 'ajax.',
                    'prefix' => 'ajax/settings/defaults',
                ], function(){
                    Route::get('/', [DefaultsController::class, 'getDefaults'])->name('getDefaults');

                    Route::post('/receipts', [DefaultsController::class, 'updateReceipts'])->name('updateReceipts');
                    Route::post('/advance-receipts', [DefaultsController::class, 'updateAdvanceReceipts'])->name('updateAdvanceReceipts');
                    Route::post('/credit-receipts', [DefaultsController::class, 'updateCreditReceipts'])->name('updateCreditReceipts');
                    Route::post('/bills', [DefaultsController::class, 'updateBills'])->name('updateBills');
                    Route::post('/payments' ,[DefaultsController::class, 'updatePayments'])->name('updatePayments');
                });
            });
        });

        /**
         * Control Panel
         */
        Route::group([
            'as' => 'control.',
        ], function() {
            Route::get('/control', [ControlPanelController::class, 'index'])->name('index');
            
            Route::put('/control/admins/add', [ControlPanelController::class, 'addNewSuperAdmin'])->name('addNewSuperAdmin');
            Route::post('/control/admins/add', [ControlPanelController::class, 'addExistingUserAsSuperAdmin'])->name('addExistingUserAsSuperAdmin');

            Route::put('/control/admins/edit/{user}', [ControlPanelController::class, 'editSuperAdmin'])->name('editSuperAdmin');
            Route::delete('/control/admins/remove/{user}', [ControlPanelController::class, 'removeSuperAdmin'])->name('removeSuperAdmin');

            // AJAX
            Route::group([
                'as', 'ajax.',
                'prefix' => 'ajax/control/user',
            ], function(){
                Route::get('/get/{user}', [ControlPanelController::class, 'ajaxGetUser']);
                Route::get('/search/{query?}', [ControlPanelController::class, 'ajaxSearchUser']);
            });
        });
    });
});

Route::post('/userlogin', function (Request $request){
   

    $credentials = $request->only('email', 'password');
    Log::info($credentials);
    //  $accessCode = User::where('email',$request->email)->first();
    // Log::info($accessCode);

    // if (Hash::check($request->password, 'test')) {
    //     session(['adminauthenticated' => 'true']);
    //     Log::info("sod");
    // }else{
    //     Log::info("wa sod");
    // }

    
    if (Auth::attempt($credentials)) {
        // if success login
        Log::info("sod");
        session(['adminauthenticated' => 'true']);
        

        // return redirect()->intended('/dashboard');
        return redirect()->intended('/home');
    }else{
        Log::info(" wa sod");
        return redirect()->route('logins')->with('error', "Invalid user credentials.");
    }
    // if failed login

})->name('userlogin');


/**
 * Referral Module
 */
Route::group([
    'as' => 'register.'
], function(){ 

    /**
     * Step 0 - 2b (UI)
     */
    // Step 0
    Route::get('/create-account', [RegisterController::class, 'createAccountView'])->name('createAccountView');
    // Step 1
    Route::get('/create-password', [RegisterController::class, 'createPasswordView'])->name('createPasswordView');
    // Step 2a
    Route::get('/create-user', [RegisterController::class, 'createUserView'])->name('createUser');
    // Step 2b
    Route::get('/verify-password', [RegisterController::class, 'verifyPasswordView'])->name('verifyPasswordView');

    /**
     * Step 0 - 2b (AJAX)
     */
    // Step 0
    Route::post('/submit-referral-code', [RegisterController::class, 'findReferralCode'])->name('submitReferral');
    // Step 1
    Route::post('/check-email-registration', [RegisterController::class, 'checkIfEmailExists'])->name('checkIfEmailExists');
    // Step 2a
    Route::post('/validate-account', [RegisterController::class, 'validateExistingAccount'])->name('validateAccount');
    // Step 2b
    Route::post('/create-account', [RegisterController::class, 'createAccount'])->name('createAccount');
    
    /**
     * Step 3
     */
    Route::group([
        'middleware' => 'auth',
    ], function(){
        // HTML
        Route::get('/onboarding', [RegisterController::class, 'createCompanyInfoView'])->name('createCompanyInfoView');
        // AJAX
        Route::post('/onboarding', [RegisterController::class, 'createAccountingSystem'])->name('createAccountingSystem');
        Route::post('/onboarding/cancel', [RegisterController::class, 'cancelOnboarding'])->name('cancelOnboarding');
    });

    /**
     * Deprecated Routes
     */ 
    // Route::get('/create-company-info', [RegisterController::class, 'createCompanyInfoView'])->name('createCompanyInfoView');
    // Route::post('/create-account-post', [RegisterController::class, 'createAccount'])->name('submitEmail');
    // Route::post('/create-password-post', [RegisterController::class, 'createPassword'])->name('submitPassword');
    // Route::post('/verify-password-post', [RegisterController::class, 'verifyPassword'])->name('verifyPassword');
    // Route::get('/create-company-info-post', [RegisterController::class, 'createCompanyInfo'])->name('createCompanyInfo');
});
