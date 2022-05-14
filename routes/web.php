<?php

use Illuminate\Support\Facades\Route;
 
use App\Models\User;
// Customer module
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepositController;
// Banking module
use App\Http\Controllers\AccountsController;
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

// Account Settings
use App\Http\Controllers\AccountSettings\AccountSettingsController;



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
    Route::get('/switch', [App\Http\Controllers\HomeController::class, 'viewAccountingSystems']);
    Route::put('/switch', [App\Http\Controllers\HomeController::class, 'switchAccountingSystem']);
    
    Route::group([
        'middleware' => 'auth.accountingsystem',
    ], function(){
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
});


// Auth::routes();


 
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
 * Customer Menu
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

        Route::delete('/receipt/{id}', [ReceiptController::class, 'destroy']);
        Route::get('/receipt/{id}', [ReceiptController::class, 'edit']);
        Route::put('/receipt/{id}', [ReceiptController::class, 'update']);

        /** AJAX Calls */
        Route::get('/ajax/customer/receipt/proforma/search/{customer}/{value}', [ReceiptController::class, 'ajaxSearchCustomerProforma']);
        Route::get('/ajax/customer/receipt/proforma/get/{proforma}', [ReceiptController::class, 'ajaxGetProforma']);
    });

    Route::group([
        'as'=>'customers.'
    ], function(){ 
        Route::get('/customers/customers/', [CustomerController::class, 'index']);
        Route::post('/customer', [CustomerController::class, 'store']); 
        Route::get('/customer/{id}', [CustomerController::class, 'edit']);
        Route::put('/customer/{id}', [CustomerController::class, 'update']);
        Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);
        
        Route::get('/select/search/customer/{query}', [CustomerController::class, 'queryCustomers']);
        Route::get('/ajax/customer/receipts/topay/{customer}', [CustomerController::class, 'ajaxGetReceiptsToPay']);
    });

    Route::group([
        'as'=>'deposits.'
    ], function(){ 
        Route::get('/customers/deposits/', [DepositController::class, 'index']);
        Route::get('/ajax/customer/deposit/bank/search/{query}', [DepositController::class, 'ajaxSearchBank']);
    });

 
 

/**
 * Vendor Menu
 */  
 
    Route::group([
        'as'=>'bills.'
    ], function(){ 
        Route::get('/vendors/bills/', [BillsController::class, 'index'])->name('bill.index');
        Route::post('/bill',[BillsController::class,'storeBill'])->name('bill.store');
        Route::get('/individual-bill',[BillsController::class,'show'])->name('bill.show');
    });

    Route::group([
        'as'=>'payments.'
    ], function(){ 
        Route::get('/vendors/payments',[PaymentsController::class,'index']);
    });

    Route::group([
        'as'=>'vendors.'
    ], function(){ 
        Route::get('/vendors/vendors/',[VendorsController::class,'index']);
        Route::get('/vendors/{id}',[VendorsController::class,'edit'])->name('vendors.edit');
        Route::post('/vendors/{id}',[VendorsController::class,'update'])->name('vendors.update');
        Route::delete('/vendors/{id}',[VendorsController::class,'destroy'])->name('vendors.destroy');
        Route::post('/vendors', [VendorsController::class, 'store'])->name('vendors.store');

        Route::get('/select/search/vendor/{query}', [VendorsController::class, 'queryVendors']);

    });
 
 
 
 

/**
 * Banking Menu
 */ 
 
    Route::group([
        'as'=>'accounts.'
    ], function(){ 

        Route::get('/banking/accounts', [AccountsController::class, 'index'])->name('bank.accounts');

    });

    Route::group([
        'as'=>'transfers.'
    ], function(){ 
        Route::get('/banking/transfer', [TransfersController::class, 'index'])->name('bank.transfers');
        
    });

  

    Route::group([
        'as'=>'deposits.'
    ], function(){ 
        Route::get('/banking/deposits', [DepositController::class, 'index'])->name('bank.deposits');
        
    });

    Route::group([
        'as'=>'transactions.'
    ], function(){ 

        Route::get('/banking/transactions', [TransactionsController::class, 'index']);
    });
     
 
 
 /**
 * Journal Menu
 */ 
 

  Route::group([
      'as'=>'journals.'
  ], function(){ 

      Route::get('/jv/', [JournalVouchersController::class, 'index'])->name('index');
      Route::get('/journals/{journalVoucher}', [JournalVouchersController::class, 'show'])->name('show');
      Route::post('/journals', [JournalVouchersController::class, 'store'])->name('store');
  });

 
 
 /**
 *  Inventory
 */ 
 

Route::group([
    'as'=>'inventory.'
], function(){ 
    Route::get('/inventory/', [InventoryController::class, 'index']);
    Route::post('/inventory', [InventoryController::class, 'store']);
    Route::get('/inventory/{inventory}', [InventoryController::class, 'edit']);
    Route::put('/inventory/{inventory}', [InventoryController::class, 'update']);

    Route::get('/select/search/inventory/{query}', [InventoryController::class, 'ajaxSearchInventory']);
});

 

/**
 * Human Resource Menu
 */
    Route::group([
        'as' => 'payrolls.'
    ], function(){
        Route::get('/hr/payrolls', [PayrollController::class, 'index']);

    });

    Route::group([
        'as' => 'employees.'
    ], function(){
        Route::get('/hr/employees', [EmployeeController::class, 'index'])->name('index');
        Route::post('/employee', [EmployeeController::class, 'store'])->name('store');
        Route::put('/employee/{employee}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::get('/ajax/hr/employees/get/{employee}', [EmployeeController::class, 'ajaxGetEmployee']);
        Route::get('/employee/{id}', [EmployeeController::class, 'edit']);
        Route::get('/select/search/employee/{query}', [EmployeeController::class, 'queryEmployees']);

    });

    Route::group([
        'as' => 'overtime.'
    ], function(){
        Route::get('/hr/overtime', [OvertimeController::class, 'index']);
        Route::post('/overtime', [OvertimeController::class, 'store'])->name('store');
        Route::delete('/overtime/{id}', [OvertimeController::class, 'destroy']);

    });

    Route::group([
        'as' => 'additions.'
    ], function(){
        Route::get('/hr/addition', [AdditionController::class, 'index']);
        Route::post('/addition', [AdditionController::class, 'store'])->name('store');
        Route::delete('/addition/{id}', [AdditionController::class, 'destroy']);
        
    });

    Route::group([
        'as' => 'deductions.'
    ], function(){
        Route::get('/hr/deduction', [DeductionController::class, 'index']);
        Route::post('/deduction', [DeductionController::class, 'store'])->name('store');
        Route::delete('/deduction/{id}', [DeductionController::class, 'destroy']);


    });

    Route::group([
        'as' => 'loans.'
    ], function(){
        Route::get('/hr/loan', [LoanController::class, 'index']);
        Route::post('/loan', [LoanController::class, 'store'])->name('store');
        Route::delete('/loan/{id}', [LoanController::class, 'destroy']);


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
        Route::view('/settings/company', 'settings.company_info.index')->name('index');
    });

    /**
     * Settings > Users
     */
    Route::group([
        'as' => 'users.'
    ], function() {
        // HTTP
        Route::get('/settings/users', [ManageUsersController::class, 'index'])->name('manageUsers');
        Route::get('/settings/users/{user}/permissions', [ManageUsersController::class, 'editPermissions'])->name('editPermissions');
        Route::put('/settings/users/{user}/permissions', [ManageUsersController::class, 'updatePermissions'])->name('updatePermissions');
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
    });

    /**
     * Settings > Withholding
     */
    Route::group([
        'as' => 'withholding.'
    ], function(){
        // HTTP
        Route::view('/settings/withholding', 'settings.withholding.index')->name('index');
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
        Route::get('/ajax/settings/coa/search/{query}', [ChartOfAccountsController::class, 'ajaxSearchCOA']);
        Route::get('/ajax/settings/coa_categories/search', [ChartOfAccountsController::class, 'ajaxSearchCategories']);
        Route::get('/ajax/settings/coa_categories/search/{query}', [ChartOfAccountsController::class, 'ajaxSearchCategories']);
    });

    /**
     * Settings > Inventory
     */
    Route::group([
        'as' => 'inventory.'
    ], function(){
        // HTTP
        Route::view('/settings/inventory', 'settings.inventory.index')->name('index');
    });

    /**
     * Settings > Defaults
     */
    Route::group([
        'as' => 'defaults.'
    ], function(){
        // HTTP
        Route::view('/settings/defaults', 'settings.defaults.index')->name('index');
    });

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
