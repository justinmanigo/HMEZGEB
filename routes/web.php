<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;

// Home
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReferralsController;

// Customer module
use App\Http\Controllers\Customers\ReceiptsController;
use App\Http\Controllers\Customers\Receipts\SaleController;
use App\Http\Controllers\Customers\Receipts\ReceiptController;
use App\Http\Controllers\Customers\Receipts\AdvanceRevenueController;
use App\Http\Controllers\Customers\Receipts\CreditReceiptController;
use App\Http\Controllers\Customers\Receipts\ProformaController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepositController;
// Banking module
use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\TransfersController;
use App\Http\Controllers\DepositsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\Banking\BankReconciliationController;
// Vendor module
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\BillsController;
use App\Http\Controllers\Vendors\Bills\BillController;
use App\Http\Controllers\Vendors\Bills\CostOfGoodsSoldController;
use App\Http\Controllers\Vendors\Bills\ExpenseController;
use App\Http\Controllers\Vendors\Bills\PurchaseOrderController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\Vendors\Payments\BillPaymentController;
use App\Http\Controllers\Vendors\Payments\WithholdingPaymentController;
use App\Http\Controllers\Vendors\Payments\PayrollPaymentController;
use App\Http\Controllers\Vendors\Payments\IncomeTaxPaymentController;
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
use App\Http\Controllers\Settings\AccountingPeriodsController;

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
use App\Http\Controllers\Control\SuperAdminController;
use App\Http\Controllers\Control\SubscriptionController;

// Subscription Panel
use App\Http\Controllers\Subscription\SummaryController;
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

Route::get('/test', function () {
    return var_dump(App\Actions\Vendors\Payments\Withholding\CheckIfWithholdingPeriodPaid::run('2022-10-20'));
});

Route::get('/check-authentication', function() {
    return Auth::check();
});

Route::get('/reject-invitation/{encrypted}', [ReferralsController::class, 'rejectInvitation']);

Route::group([
    'middleware' => 'auth',
], function()
{
    /**
     * ========== Mandatory Update Password ==========
     */
    Route::get('/update-password', function() {
        if(auth()->user()->must_update_password == true) {
            return view('account_settings.update-password');
        }
        return redirect('/');
    });

    /**
     * ========== Mandatory Update Name ==========
     */
    Route::get('/update-name', function() {
        if(auth()->user()->firstName == 'New' && auth()->user()->lastName == 'User') {
            return view('account_settings.update-name');
        }
        return redirect('/');
    })->name('must-update-name');

    /**
     * ========== Accounting System Switcher ==========
     */
    Route::group([
        'middleware' => ['auth.name', 'auth.password'],
        'prefix' => '/switch'
    ], function(){
        Route::get('/', [HomeController::class, 'viewAccountingSystems']);
        Route::put('/', [HomeController::class, 'switchAccountingSystem']);
    });

    /**
     * ========== Referrals ==========
     */
    Route::group([
        'middleware' => ['auth.name', 'auth.password'],
        'as' => 'referrals.'
    ], function(){
        Route::get('/referrals', [ReferralsController::class, 'index'])->name('index');
        Route::post('/referrals', [ReferralsController::class, 'storeNormalReferral'])->name('store.normal');
        Route::put('/referrals', [ReferralsController::class, 'storeAdvancedReferral'])->name('store.advanced');
        Route::patch('/referrals', [ReferralsController::class, 'generateReferrals'])->name('generate');

        Route::get('/referrals/{referral}', [ReferralsController::class, 'show'])->name('show');

        // AJAX
        Route::post('/ajax/referrals/resend/{referral}', [ReferralsController::class, 'resendEmail'])->name('resend');
    });

    /**
     * ========== Account Settings ==========
     */
    Route::group([
        'as' => 'account.'
    ], function() {
        Route::group([
            'middleware' => ['auth.name', 'auth.password'],
        ], function(){
            // HTTP
            Route::get('/account/', [AccountSettingsController::class, 'index'])->name('index');
            Route::post('/account/2fa/confirm', [AccountSettingsController::class, 'confirm2FA'])->name('confirm2FA');
        });

        // AJAX
        Route::post('/ajax/account/show/recoverycodes', [AccountSettingsController::class, 'showRecoveryCodes']);
        Route::put('/ajax/account/update/name', [AccountSettingsController::class, 'updateName']);
        Route::put('/ajax/account/update/username', [AccountSettingsController::class, 'updateUsername']);
        Route::put('/ajax/account/update/email', [AccountSettingsController::class, 'updateEmail']);
        Route::put('/ajax/account/update/password', [AccountSettingsController::class, 'updatePassword']);
    });

    /**
     * ========== Control Panel ==========
     */
    Route::group([
        'as' => 'control.',
        'middleware' => ['auth.name', 'auth.password', 'auth.control'],
    ], function() {
        /** Super Admins */
        Route::get('/control', [SuperAdminController::class, 'index'])->name('index');
        Route::get('/control/admins', [SuperAdminController::class, 'index']);
        Route::put('/control/accept', [SuperAdminController::class, 'acceptInvitation'])->name('accept');
        Route::post('/control/reject', [SuperAdminController::class, 'rejectInvitation'])->name('reject');
        Route::put('/control/admins/add', [SuperAdminController::class, 'ajaxInviteUser'])->name('ajaxInviteUser');
        Route::put('/control/admins/edit/{user}', [SuperAdminController::class, 'editSuperAdmin'])->name('editSuperAdmin');
        Route::delete('/control/admins/remove/{user}', [SuperAdminController::class, 'removeSuperAdmin'])->name('removeSuperAdmin');

        /** Subscriptions */
        Route::get('/control/subscriptions', [SubscriptionController::class, 'index'])->name('index');
        Route::get('/control/subscriptions/view/{subscription}', [SubscriptionController::class, 'showAjax'])->name('show');
        Route::post('/control/subscriptions/activate/{subscription}', [SubscriptionController::class, 'activate'])->name('activate');
        Route::post('/control/subscriptions/suspend/{subscription}', [SubscriptionController::class, 'suspend'])->name('suspend');
        Route::post('/control/subscriptions/reinstate/{subscription}', [SubscriptionController::class, 'reinstate'])->name('reinstate');

        // AJAX
        Route::group([
            'as', 'ajax.',
            'prefix' => 'ajax/control/user',
        ], function(){
            Route::get('/get/{user}', [SuperAdminController::class, 'ajaxGetUser']);
            Route::get('/search/{query?}', [SuperAdminController::class, 'ajaxSearchUser']);
        });
    });

    /**
     * ========== Subscription Panel ==========
     */
    Route::group([
        'as' => 'subscription.',
        'middleware' => ['auth.name', 'auth.password'],
    ], function(){
        // HTML
        Route::get('/subscription', [SummaryController::class, 'index'])->name('subscription.index');

        // Invitation Accept/Reject
        Route::patch('/ajax/subscription/accept-invitation', [SummaryController::class, 'ajaxAcceptInvitation']);
        Route::delete('/ajax/subscription/reject-invitation', [SummaryController::class, 'ajaxRejectInvitation']);

        Route::group([
            'middleware' => 'auth.subscription',
        ], function(){
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
                Route::post('/add/new', [ManageSubscriptionUsersController::class, 'ajaxInviteUser']);
                // Route::post('/add/new', [ManageSubscriptionUsersController::class, 'ajaxAddNewUser']);
                // Route::post('/add/existing', [ManageSubscriptionUsersController::class, 'ajaxAddExistingUser']);

                // Part 2: Adding access after adding new user.
                Route::post('/add/access/{subscriptionUser}', [ManageSubscriptionUsersController::class, 'ajaxAddAccess']);

                // TODO: Editing a user. Both parts are merged since there is already an ID.
                Route::get('/edit/{subscriptionUser}', [ManageSubscriptionUsersController::class, 'ajaxEditUser']);
                Route::put('/update/{subscriptionUser}', [ManageSubscriptionUsersController::class, 'ajaxUpdateUser']);

                Route::delete('/remove/{subscriptionUser}', [ManageSubscriptionUsersController::class, 'ajaxRemoveUser']);
            });
        });

    });

    /**
     * ========== Accounting System Routes ==========
     */
    Route::group([
        'middleware' => ['auth.name', 'auth.password', 'auth.accountingsystem'],
    ], function()
    {
        /**
         * ========== Accounting System Dashboard ==========
         */
        Route::get('/', [HomeController::class, 'index']);
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        /**
         * ========== Customers Module ==========
         */
        Route::group([

        ], function(){

            /**
             * Customers > Receipts
             */
            Route::group([
                'as'=>'receipts.',
                'middleware' => 'acctsys.permission:2',
            ], function(){
                // Route::get('/customers/receipts/', [ReceiptsController::class, 'index'])->name('receipt.index');
                Route::resource('/customers/receipts', ReceiptsController::class);

                Route::group([
                    'as'=>'sales.',
                ], function(){
                    Route::post('/customers/receipts/sales', [SaleController::class, 'store'])->name('store');
                });

                Route::group([
                    'as'=>'receipts.',
                ], function(){
                    Route::post('/receipt',[ReceiptController::class,'store'])->name('store');
                    // TODO: impklement show receipt
                    Route::get('/receipt/void/{rr}', [ReceiptController::class, 'void'])->name('void');
                    Route::get('/receipt/reactivate/{rr}', [ReceiptController::class, 'reactivate'])->name('reactivate');
                    Route::get('/receipt/mail/{r}', [ReceiptController::class, 'mail'])->name('mail');
                    Route::get('/receipt/print/{r}', [ReceiptController::class, 'print'])->name('print');
                });

                Route::group([
                    'as'=>'advance_revenues.',
                ], function(){
                    Route::post('/advance-receipt',[AdvanceRevenueController::class,'store'])->name('store');
                    Route::get('/advance-receipt/{receipt}',[AdvanceRevenueController::class,'show'])->name('show');
                    Route::get('/advance-revenue/void/{id}', [AdvanceRevenueController::class, 'void'])->name('void');
                    Route::get('/advance-revenue/reactivate/{id}', [AdvanceRevenueController::class, 'reactivate'])->name('reactivate');
                    Route::get('/advance-revenue/mail/{id}', [AdvanceRevenueController::class, 'mail'])->name('mail');
                    Route::get('/advance-revenue/print/{id}', [AdvanceRevenueController::class, 'print'])->name('print');
                });

                Route::group([
                    'as'=>'credit_receipts.',
                ], function(){
                    Route::post('/credit-receipt',[CreditReceiptController::class,'store'])->name('store');
                    Route::get('/credit-receipt/{cr}',[CreditReceiptController::class,'show'])->name('show');
                    Route::get('/credit-receipt/void/{rr}', [CreditReceiptController::class, 'void'])->name('void');
                    Route::get('/credit-receipt/reactivate/{rr}', [CreditReceiptController::class, 'reactivate'])->name('reactivate');
                    Route::get('/credit-receipt/mail/{cr}', [CreditReceiptController::class, 'mail'])->name('mail');
                    Route::get('/credit-receipt/print/{cr}', [CreditReceiptController::class, 'print'])->name('print');
                });

                Route::group([
                    'as'=>'proformas.',
                ], function(){
                    Route::post('/proforma',[ProformaController::class,'store'])->name('store');
                    Route::get('/proforma/{proforma}',[ProformaController::class,'show'])->name('show');
                    Route::get('/proforma/void/{proforma}', [ProformaController::class, 'void'])->name('void');
                    Route::get('/proforma/reactivate/{proforma}', [ProformaController::class, 'reactivate'])->name('reactivate');
                    Route::get('/proforma/mail/{proforma}', [ProformaController::class, 'mail'])->name('mail');
                    Route::get('/proforma/print/{proforma}', [ProformaController::class, 'print'])->name('print');

                    /** AJAX Calls */
                    Route::get('/ajax/customer/receipt/proforma/search/{customer}/{value}', [ProformaController::class, 'ajaxSearchCustomer']);
                    Route::get('/ajax/customer/receipt/proforma/get/{proforma}', [ProformaController::class, 'ajaxGet']);
                });

                // Other Functions
                Route::get('/receipt/csv',[ReceiptsController::class,'exportReceipts'])->name('export.csv');
                // Route::delete('/receipt/{id}', [ReceiptsController::class, 'destroy']);
                // Route::get('/receipt/{id}', [ReceiptsController::class, 'edit']);
                // Route::put('/receipt/{id}', [ReceiptsController::class, 'update']);              
            });

            /**
             * Customers > Customers
             */
            Route::group([
                'as'=>'customers.',
                'middleware' => 'acctsys.permission:1',
            ], function(){
                // Resource
                Route::resource('/customers/customers', CustomerController::class);
                // Mail
                // Route::get('/customers/mail/statements', [CustomerController::class, 'mailCustomerStatements'])->name('statements.mail');
                Route::get('/customers/mail/statement/{id}', [CustomerController::class, 'mailCustomerStatement'])->name('statement.mail');
                // Print
                Route::get('/customers/print/statement/{id}', [CustomerController::class, 'print'])->name('statement.print');
                // Import Export
                Route::post('/customers/import', [CustomerController::class, 'import'])->name('import');
                Route::post('/customers/export', [CustomerController::class, 'export'])->name('export');
                // AJAX
                Route::get('/select/search/customer/{query}', [CustomerController::class, 'queryCustomers']);
                Route::get('/ajax/customer/receipts/topay/{customer}', [CustomerController::class, 'ajaxGetReceiptsToPay']);
            });

            /**
             * Customers > Deposits
             */
            Route::group([
                'as'=>'deposits.',
                'middleware' => 'acctsys.permission:3',
            ], function(){
                Route::get('/ajax/customer/deposit/bank/search/{query}', [DepositsController::class, 'ajaxSearchBank']);
                // RESOURCE
                Route::resource('customers/deposits', DepositsController::class);
                // Mail
                Route::get('/customers/deposits/mail/{id}', [DepositsController::class, 'mailDeposit'])->name('deposit.mail');
                // Print
                Route::get('/customers/deposits/print/{id}', [DepositsController::class, 'printDeposit'])->name('deposit.print');

                // AJAX
                Route::get('/ajax/customer/deposit/receipts/undeposited/get', [DepositsController::class, 'ajaxGetUndepositedReceipts']);
            });
        });

        /**
         * ========== Vendors Module ==========
         */
        Route::group([

        ], function(){

            /**
             * Vendors > Bills
             */
            Route::group([
                'as'=>'bills.',
                'middleware' => 'acctsys.permission:5',
            ], function(){
                // HTML
                Route::get('/vendors/bills', [BillsController::class, 'index'])->name('index');
                Route::get('/vendors/bills/{bills}', [BillsController::class, 'show'])->name('show');

                // Bill
                Route::group([
                    'as' => 'bill.',
                ], function() {
                    // HTML
                    Route::post('/vendors/bills/bill', [BillController::class, 'store'])->name('store');
                    // TODO: Convert to POST
                    Route::get('/bill/void/{id}', [BillController::class, 'void'])->name('void');
                    Route::get('/bill/reactivate/{id}', [BillController::class, 'revalidate'])->name('revalidate');
                    Route::get('/bill/mail/{id}', [BillController::class, 'mail'])->name('mail');
                    Route::get('/bill/print/{id}', [BillController::class, 'print'])->name('print');

                    // AJAX
                    Route::get('/ajax/vendor/bill/purchase-order/search/{vendor}/{value}', [BillController::class, 'ajaxGetVendorPurchaseOrders']);
                });

                // Purchase Order
                Route::group([
                    'as' => 'purchaseOrder.',
                ], function() {
                    // HTML
                    Route::post('/vendors/bills/purchaseorder', [PurchaseOrderController::class, 'store'])->name('store');
                    Route::get('/purchaseorder/{id}',[PurchaseOrderController::class,'show'])->name('show');
                    // TODO: Convert to POST
                    Route::get('/purchaseOrder/void/{id}', [PurchaseOrderController::class, 'void'])->name('void');
                    Route::get('/purchaseOrder/reactivate/{id}', [PurchaseOrderController::class, 'revalidate'])->name('revalidate');
                    Route::get('/purchaseOrder/mail/{id}', [PurchaseOrderController::class, 'mail'])->name('mail');
                    Route::get('/purchaseOrder/print/{id}', [PurchaseOrderController::class, 'print'])->name('print');

                    // AJAX
                    Route::get('/ajax/vendor/bill/purchase-order/get/{purchaseOrder}', [PurchaseOrderController::class, 'ajaxGet']);

                });

                // COGS
                Route::group([
                    'as' => 'cogs.',
                ], function(){
                    Route::post('/vendors/bills/cogs', [CostOfGoodsSoldController::class, 'store'])->name('store');
                });

                // Expense
                Route::group([
                    'as' => 'expense',
                ], function(){
                    Route::post('/vendors/bills/expense', [ExpenseController::class, 'store'])->name('store');
                });

                // Route::get('/vendors/bills/', [BillsController::class, 'index'])->name('bill.index');
                // Route::post('/bill',[BillsController::class,'storeBill'])->name('bill.store');

                /**
                 * TODO: Update bill.show route
                 */
                // Route::get('/individual-bill',[BillsController::class,'show'])->name('bill.show');

                // Mail


                // Print

                // Void

                // Reactivate

            });

            /**
             * Vendors > Payments
             */
            Route::group([
                'as'=>'payments.',
                'middleware' => 'acctsys.permission:6',
            ], function(){
                // HTML
                Route::get('/vendors/payments',[PaymentsController::class,'index']);
                Route::post('/payment/pension',[PaymentsController::class,'storePensionPayment'])->name('pension.store');

                Route::group([
                    'as' => 'bill.',
                ], function(){
                    // HTML
                    Route::post('/vendors/payments/bill', [BillPaymentController::class, 'store'])->name('store');

                    // AJAX
                    Route::get('/ajax/vendor/bills/topay/{vendor}', [BillPaymentController::class, 'ajaxGetEntriesToPay']);
                });

                Route::group([
                    'as' => 'withholding.',
                ], function() {
                    // HTML
                    Route::post('/vendors/payments/withholding', [WithholdingPaymentController::class, 'store'])->name('store');

                    // AJAX
                    Route::get('/ajax/vendors/payments/withholding/all/', [WithholdingPaymentController::class, 'ajaxGetAll']);
                    Route::get('/ajax/vendor/withholding/topay/{vendor}', [WithholdingPaymentController::class, 'ajaxGetEntriesToPay']);
                });

                Route::group([
                    'as' => 'payroll.',
                ], function() {
                    // HTML
                    Route::post('/payment/payroll', [PayrollPaymentController::class, 'store'])->name('store');
                });

                Route::group([
                    'as' => 'incometax.',
                ], function() {
                    // HTML
                    Route::post('/vendors/payments/incometax', [IncomeTaxPaymentController::class, 'store'])->name('store');

                    // AJAX
                    Route::get('/ajax/vendors/payments/incometax/unpaid/search/{query?}', [IncomeTaxPaymentController::class, 'ajaxGetUnpaid']);
                });

            });

            /**
             * Vendors > Vendors
             */
            Route::group([
                'as'=>'vendors.',
                'middleware' => 'acctsys.permission:4',
            ], function(){
                // Resource
                Route::resource('/vendors/vendors', VendorsController::class);
                // Mail
                Route::get('/vendors/mail/statement/{id}', [VendorsController::class, 'mail'])->name('statement.mail');
                // Print
                Route::get('/vendors/print/statement/{id}', [VendorsController::class, 'print'])->name('statement.print');
                // Import Export
                Route::post('/vendors/import', [VendorsController::class, 'import'])->name('import');
                Route::post('/vendors/export', [VendorsController::class, 'export'])->name('export');
                // AJAX
                Route::get('/select/search/vendor/{query}', [VendorsController::class, 'ajaxSearch']);
            });
        });

        /**
         * ========== Banking Module ==========
         */
        Route::group([
            // TODO: Disallow access if user does not have privileges (R/RW) through a custom middleware.
        ], function(){

            /**
             * Banking > Accounts
             */
            Route::group([
                'as'=>'accounts.',
                'middleware' => 'acctsys.permission:7',
            ], function(){
                // RESOURCE
                Route::resource('/banking/accounts', BankAccountsController::class);
                // Import Export
                Route::post('/banking/accounts/import', [BankAccountsController::class, 'import'])->name('accounts.import');
                Route::post('/banking/accounts/export', [BankAccountsController::class, 'export'])->name('accounts.export');
                // Mail
                Route::get('/banking/accounts/mail/{id}', [BankAccountsController::class, 'mail'])->name('accounts.mail');
                // Print
                Route::get('/banking/accounts/print/{id}', [BankAccountsController::class, 'print'])->name('accounts.print');
            });

            /**
             * Banking > Transfer
             */
            Route::group([
                'as'=>'transfers.',
                'middleware' => 'acctsys.permission:8',
            ], function(){
                // RESOURCE
                Route::resource('/banking/transfer', TransfersController::class);
                // HTML
                Route::post('/banking/transfer/{id}/void', [TransfersController::class, 'void'])->name('transfer.void');
                Route::get('/ajax/search/bank/{query}', [TransfersController::class, 'queryBank']);
                // Mail
                Route::get('/banking/transfer/mail/{id}', [TransfersController::class, 'mail'])->name('transfer.mail');
                // Print
                Route::get('/banking/transfer/print/{id}', [TransfersController::class, 'print'])->name('transfer.print');
                // Import Export
                Route::post('/banking/transfers/import', [TransfersController::class, 'import'])->name('transfers.import');
                Route::post('/banking/transfers/export', [TransfersController::class, 'export'])->name('transfers.export');
            });

            /**
             * Banking > Deposits
             * Same content as Customer > Deposits
             */
            Route::group([
                'as'=>'deposits.',
                'middleware' => 'acctsys.permission:3', // & 9 but duplicate
            ], function(){
                // HTML
                Route::redirect('/banking/deposits', '/customers/deposits');
            });

            /**
             * Banking > Transactions
             */
            Route::group([
                'as'=>'transactions.',
                'middleware' => 'acctsys.permission:10',
            ], function(){
                // HTML
                Route::get('/banking/transactions', [TransactionsController::class, 'index']);
            });

            /**
             * TODO: Banking > Bank Reconcilation
             */
            Route::group([
                'as' => 'reconciliation.',
                'middleware' => 'acctsys.permission:11',
            ], function(){
                // HTML
                Route::get('/banking/reconciliation', [BankReconciliationController::class, 'index']);
            });

        });

        /**
         * ========== Journal Vouchers Module ==========
         */
        Route::group([
            'as'=>'journals.',
            'middleware' => 'acctsys.permission:12',
        ], function(){
            // HTML
            Route::get('/jv/', [JournalVouchersController::class, 'index'])->name('index');
            Route::get('/journals/{journalVoucher}', [JournalVouchersController::class, 'show'])->name('show');
            Route::post('/journals', [JournalVouchersController::class, 'store'])->name('store');
        });

        /**
         * ========== Inventory Module ==========
         */
        Route::group([
            'as'=>'inventory.',
            'middleware' => 'acctsys.permission:19',
        ], function(){
            // HTML
            Route::resource('/inventory', InventoryController::class);
            // import export
            Route::post('/inventory/import', [InventoryController::class, 'import'])->name('import');
            Route::post('/inventory/export', [InventoryController::class, 'export'])->name('export');
            // Route::get('/inventory', [InventoryController::class, 'index']);
            // Route::post('/inventory', [InventoryController::class, 'store']);
            // Route::get('/inventory/{inventory}', [InventoryController::class, 'show']);
            // Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit']);
            // Route::put('/inventory/{inventory}', [InventoryController::class, 'update']);
            // Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy']);

            // AJAX
            Route::get('/select/search/inventory/{query}', [InventoryController::class, 'ajaxSearchInventory']);
        });

        /**
         * ========== Human Resource Module ==========
         */
        Route::group([

        ], function(){

            /**
             * Human Resource > Payrolls
             */
            Route::group([
                'as' => 'payrolls.',
                'middleware' => 'acctsys.permission:14',
            ], function(){
                // HTML
                // Route::resource('/hr/payrolls', PayrollController::class);

                Route::get('/hr/payrolls', [PayrollController::class, 'index'])->name('index');
                Route::post('/hr/payrolls', [PayrollController::class, 'store'])->name('store');
                Route::get('/hr/payrolls/{payroll_period}', [PayrollController::class, 'show'])->name('show');
                Route::delete('/hr/payrolls/{payroll_period}', [PayrollController::class, 'destroy'])->name('destroy');

                // AJAX
                Route::get('/ajax/hr/payrolls/unpaid/search/{query?}', [PayrollController::class, 'ajaxGetUnpaidPayrollPeriods']);

            });

            /**
             * Human Resource > Employees
             */
            Route::group([
                'as' => 'employees.',
                'middleware' => 'acctsys.permission:13',
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
                'as' => 'overtimes.',
                'middleware' => 'acctsys.permission:17',
            ], function(){
                // HTML
                Route::resource('/hr/overtime', OvertimeController::class);
            });

            /**
             * Human Resource > Additions
             */
            Route::group([
                'as' => 'additions.',
                'middleware' => 'acctsys.permission:15',
            ], function(){
                // HTML
                Route::resource('/hr/addition', AdditionController::class);
            });

            /**
             * Human Resource > Deductions
             */
            Route::group([
                'as' => 'deductions.',
                'middleware' => 'acctsys.permission:16',
            ], function(){
                // HTML
                Route::resource('/hr/deduction', DeductionController::class);
            });

            /**
             * Human Resource > Loans
             */
            Route::group([
                'as' => 'loans.',
                'middleware' => 'acctsys.permission:18',
            ], function(){
                // HTML
                Route::resource('/hr/loan', LoanController::class);
            });
        });

        /**
         * ========== Reports Module ==========
         */
        Route::group([
            // TODO: Add permission middleware
            'as' => 'reports.',
            'prefix' => 'reports'
        ], function() {

            /**
             * Reports > Customers
             */
            Route::group([
                // 'as' => 'customers.',
                'middleware' => 'acctsys.permission:20',
            ], function() {
                Route::get('/customers', [ReportsController::class, 'customers'])->name('customers');

                // pdf
                // customers
                Route::post('/customers/aged_receivable/pdf', [ReportsController::class, 'agedReceivablePDF'])->name('aged_receivable.pdf');
                Route::post('/customers/cash_receipts_journal/pdf', [ReportsController::class, 'cashReceiptsJournalPDF'])->name('cash_receipts_journal.pdf');
                Route::post('/customers/ledgers/pdf', [ReportsController::class, 'customerLedgersPDF'])->name('customer_ledgers.pdf');
            });


            /**
             * Reports > Vendors
             */
            Route::group([
                // 'as' => 'vendors.',
                'middleware' => 'acctsys.permission:21',
            ], function() {
                Route::get('/vendors', [ReportsController::class, 'vendors'])->name('vendors');

                // vendors
                Route::post('/vendors/aged_payables/pdf', [ReportsController::class, 'agedPayablesPDF'])->name('aged_payables.pdf');
                Route::post('/vendors/cash_disbursements_journal/pdf', [ReportsController::class, 'cashDisbursementsJournalPDF'])->name('cash_disbursements_journal.pdf');
                Route::post('/vendors/cash_requirements/pdf', [ReportsController::class, 'cashRequirementsPDF'])->name('cash_requirements.pdf');
                Route::post('/vendors/ledgers/pdf', [ReportsController::class, 'vendorLedgersPDF'])->name('vendor_ledgers.pdf');
            });


            /**
             * Reports > Sales
             */
            Route::group([
                // 'as' => 'sales.',
                'middleware' => 'acctsys.permission:22',
            ], function() {
                Route::get('/sales', [ReportsController::class, 'sales'])->name('sales');

                // sales
                Route::post('/sales/pdf', [ReportsController::class, 'salesPDF'])->name('sales.pdf');
            });

            /**
             * Reports > Entries
             */
            Route::group([
                // 'as' => 'entries.',
                'middleware' => 'acctsys.permission:23',
            ], function() {
                Route::get('/entries', [ReportsController::class, 'entries'])->name('entries');

                // entries
                Route::post('/entries/bill/pdf', [ReportsController::class, 'billPDF'])->name('bill.pdf');
                Route::post('/entries/general_journal/pdf', [ReportsController::class, 'generalJournalPDF'])->name('general_journal.pdf');
                Route::post('/entries/general_ledger/pdf', [ReportsController::class, 'generalLedgerPDF'])->name('general_ledger.pdf');
                Route::post('/entries/payment/pdf', [ReportsController::class, 'paymentPDF'])->name('payment.pdf');
                Route::post('/entries/receipt/pdf', [ReportsController::class, 'receiptPDF'])->name('receipt.pdf');
                Route::post('/entries/journal_voucher/pdf', [ReportsController::class, 'journalVoucherPDF'])->name('journal_voucher.pdf');
            });


            /**
             * Reports > Financial Statement
             */
            Route::group([
                // 'as' => 'financial.',
                'middleware' => 'acctsys.permission:24',
            ], function() {
                Route::get('/financial_statement', [ReportsController::class, 'financial_statement'])->name('financial_statement');

                // financial statement
                Route::post('/financial_statement/balance/pdf', [ReportsController::class, 'balanceSheetPDF'])->name('balance_sheet.pdf');
                Route::post('/financial_statement/balance/zero_account/pdf', [ReportsController::class, 'balanceSheetZeroAccountPDF'])->name('balance_sheet_zero_account.pdf');
                Route::post('/financial_statement/income_statement_single/pdf', [ReportsController::class, 'incomeStatementSinglePDF'])->name('income_statement_single.pdf');
                Route::post('/financial_statement/income_statement_multiple/pdf', [ReportsController::class, 'incomeStatementMultiplePDF'])->name('income_statement_multiple.pdf');
            });
        });

        /**
         * ========== Settings Module ==========
         */
        Route::group([
            'as' => 'settings.',
            'middleware' => 'acctsys.settings'
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
                Route::post('/settings/users/add/new', [ManageUsersController::class, 'inviteUser'])->name('inviteUser');

                Route::get('/settings/users/{accountingSystemUser}/permissions', [ManageUsersController::class, 'editPermissions'])->name('editPermissions');
                Route::put('/settings/users/{accountingSystemUser}/permissions', [ManageUsersController::class, 'updatePermissions'])->name('updatePermissions');

                // Mail
                Route::get('/settings/users/{accountingSystemUser}/mail', [ManageUsersController::class, 'sendMailNewSuperAdmin'])->name('mail');

                Route::delete('/settings/users/{accountingSystemUser}', [ManageUsersController::class, 'removeUser'])->name('removeUser');
            });

            /**
             * Settings > Accounting Periods
             */
            Route::group([
                'as' => 'periods.',
            ], function() {
                // HTTP
                Route::get('/settings/periods', [AccountingPeriodsController::class, 'index']);

                // AJAX
                Route::put('/settings/periods', [AccountingPeriodsController::class, 'updateAjax']);
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
                // Import Export
                Route::post('/settings/taxes/import', [TaxController::class, 'import'])->name('import');
                Route::post('/settings/taxes/export', [TaxController::class, 'export'])->name('export');

                // AJAX
                Route::get('/ajax/settings/taxes/get/{tax}', [TaxController::class, 'ajaxGetTax']);
                Route::get('/ajax/settings/taxes/search/{query}', [TaxController::class, 'ajaxSearchTax']);
            });

            /**
             * TEMPORARY DISABLED AS OF OCT 1 2022
             * Settings > Withholding
             */
            // Route::group([
            //     'as' => 'withholding.'
            // ], function(){
            //     // HTTP
            //     Route::get('/settings/withholding', [WithholdingController::class, 'index'])->name('index');
            //     Route::post('/settings/withholding', [WithholdingController::class, 'store'])->name('store');
            //     Route::put('/settings/withholding/{withholding}', [WithholdingController::class, 'update'])->name('update');
            //     Route::delete('/settings/withholding/{withholding}', [WithholdingController::class, 'destroy'])->name('destroy');
            //     // Import Export
            //     Route::post('/settings/withholding/import', [WithholdingController::class, 'import'])->name('import');
            //     Route::post('/settings/withholding/export', [WithholdingController::class, 'export'])->name('export');

            //     // AJAX
            //     Route::get('/ajax/settings/withholding/get/{withholding}', [WithholdingController::class, 'ajaxGetWithholding']);
            // });


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
                // Import Export
                Route::post('/settings/coa/import', [ChartOfAccountsController::class, 'import'])->name('import');
                Route::post('/settings/coa/export', [ChartOfAccountsController::class, 'export'])->name('export');
                // AJAX
                Route::get('/ajax/settings/coa/search/{query?}', [ChartOfAccountsController::class, 'ajaxSearchCOA']);
                Route::get('/ajax/settings/coa/cash/search/{query?}', [ChartOfAccountsController::class, 'ajaxSearchCashCOA']);
                Route::get('/ajax/settings/coa/expense/search/{query?}', [ChartOfAccountsController::class, 'ajaxSearchExpenseCOA']);
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
         * ========== Misclaneous Routes (required for some functions to work) ==========
         */

        // Notifications
        Route::resource('notifications', NotificationController::class);
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
