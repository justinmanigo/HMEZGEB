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
use App\Http\Controllers\TaxController;
use App\Http\Controllers\SettingChartOfAccountsController;
use App\Http\Controllers\SettingPayrollRulesController;

// Account Settings
use App\Http\Controllers\AccountSettingsController;


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

Route::get('/', function () {
    return view('welcome');
})->name('logins');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

 
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
        Route::get('/receipt', [ReceiptController::class, 'index'])->name('receipt.index');
        
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
        Route::get('/customer', [CustomerController::class, 'index']);
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
        Route::get('/deposit', [DepositController::class, 'index']);
    });

 
 

/**
 * Vendor Menu
 */  
 
    Route::group([
        'as'=>'bills.'
    ], function(){ 
        Route::get('/bill', [BillsController::class, 'index'])->name('bill.index');
        Route::post('/bill',[BillsController::class,'storeBill'])->name('bill.store');
        Route::get('/individual-bill',[BillsController::class,'show'])->name('bill.show');
    });

    Route::group([
        'as'=>'vendors.'
    ], function(){ 
        Route::get('/vendors',[VendorsController::class,'index']);
        Route::get('/vendors/{id}',[VendorsController::class,'edit'])->name('vendors.edit');
        Route::post('/vendors/{id}',[VendorsController::class,'update'])->name('vendors.update');
        Route::delete('/vendors/{id}',[VendorsController::class,'destroy'])->name('vendors.destroy');
        Route::post('/vendors', [VendorsController::class, 'store'])->name('vendors.store');

        Route::get('/select/search/vendor/{query}', [VendorsController::class, 'queryVendors']);

    });

    Route::group([
        'as'=>'payments.'
    ], function(){ 
        Route::get('/payment',[PaymentsController::class,'index']);
    });
 
 
 
 

/**
 * Banking Menu
 */ 
 
    Route::group([
        'as'=>'accounts.'
    ], function(){ 

        Route::get('/accounts', [AccountsController::class, 'index'])->name('bank.accounts');

    });

    Route::group([
        'as'=>'transfers.'
    ], function(){ 
        Route::get('/transfers', [TransfersController::class, 'index'])->name('bank.transfers');
        
    });

  

    Route::group([
        'as'=>'deposits.'
    ], function(){ 
        Route::get('/deposits', [DepositsController::class, 'index'])->name('bank.deposits');
        
    });

    Route::group([
        'as'=>'transactions.'
    ], function(){ 

        Route::get('/transactions', [TransactionsController::class, 'index']);
    });
     
 
 
 /**
 * Journal Menu
 */ 
 

  Route::group([
      'as'=>'journals.'
  ], function(){ 

      Route::get('/journals', [JournalVouchersController::class, 'index'])->name('index');
      Route::get('/journals/{journalVoucher}', [JournalVouchersController::class, 'show'])->name('show');
      Route::post('/journals', [JournalVouchersController::class, 'store'])->name('store');
  });

 
 
 /**
 *  Inventory
 */ 
 

Route::group([
    'as'=>'inventory.'
], function(){ 
    Route::get('/inventory', [InventoryController::class, 'index']);
    Route::post('/inventory', [InventoryController::class, 'store']);

    Route::get('/select/search/inventory/{query}', [InventoryController::class, 'ajaxSearchInventory']);
});

 

/**
 * Human Resource Menu
 */
    Route::group([
        'as' => 'payrolls.'
    ], function(){
        Route::get('/payroll', [PayrollController::class, 'index']);

    });

    Route::group([
        'as' => 'employees.'
    ], function(){
        Route::get('/employee', [EmployeeController::class, 'index'])->name('index');
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
        Route::get('/overtime', [OvertimeController::class, 'index']);
        Route::post('/overtime', [OvertimeController::class, 'store'])->name('store');
        Route::delete('/overtime/{id}', [OvertimeController::class, 'destroy']);

    });

    Route::group([
        'as' => 'additions.'
    ], function(){
        Route::get('/addition', [AdditionController::class, 'index']);
        Route::post('/addition', [AdditionController::class, 'store'])->name('store');
        Route::delete('/addition/{id}', [AdditionController::class, 'destroy']);
        
    });

    Route::group([
        'as' => 'deductions.'
    ], function(){
        Route::get('/deduction', [DeductionController::class, 'index']);
        Route::post('/deduction', [DeductionController::class, 'store'])->name('store');
        Route::delete('/deduction/{id}', [DeductionController::class, 'destroy']);


    });

    Route::group([
        'as' => 'loans.'
    ], function(){
        Route::get('/loan', [LoanController::class, 'index']);
        Route::post('/loan', [LoanController::class, 'store'])->name('store');
        Route::delete('/loan/{id}', [LoanController::class, 'destroy']);


    });

    /**
 * Settings Menu
 */ 


    // Route::get('/company-info', function () {
    //     return view('settings.company_info.index');
    // })->name('company-info');
    // Route::get('/users', function () {
    //     return view('settings.users.index');
    // })->name('users');
    // Route::get('/taxes', function () {
    //     return view('settings.taxes.index');
    // })->name('taxes');
    // Route::get('/withholding', function () {
    //     return view('settings.withholding.index');
    // })->name('withholding');
    // Route::get('/theme', function () {
    //     return view('settings.theme.index');
    // })->name('theme');
    Route::view('/company-info', 'settings.company_info.index')->name('company-info');
    Route::view('/users', 'settings.users.index')->name('users');
    // Route::view('/taxes', 'settings.taxes.index')->name('taxes');

    

    Route::view('/withholding', 'settings.withholding.index')->name('withholding');
    Route::view('/themes', 'settings.themes.index')->name('themes');

    Route::view('/setting_inventory', 'settings.inventory.index')->name('setting_inventory');
    Route::view('/setting_defaults', 'settings.defaults.index')->name('setting_defaults');
    Route::view('/setting_payrollrules', 'settings.payroll_rules.index')->name('setting_payrollrules');

    // Settings
    Route::group([
        'as' => 'settings.'
    ], function() {

        // Chart of Accounts
        Route::get('/setting_chartofaccounts', [SettingChartofAccountsController::class, 'index']);
        
        Route::get('/ajax/settings/coa/search/{query}', [SettingChartOfAccountsController::class, 'ajaxSearchCOA']);

        // Taxes
        Route::get('/settings/taxes', [TaxController::class, 'index'])->name('tax.index');
        Route::post('/settings/taxes', [TaxController::class, 'store'])->name('tax.store');
        Route::put('/settings/taxes/{tax}', [TaxController::class, 'update'])->name('tax.update');
        Route::delete('/settings/taxes/{tax}', [TaxController::class, 'destroy'])->name('tax.destroy');
        Route::get('/ajax/settings/taxes/get/{tax}', [TaxController::class, 'ajaxGetTax']);

        // Payroll 
        Route::get('/settings/payroll', [SettingPayrollRulesController::class, 'index']);
        Route::post('/settings/payroll/incometax', [SettingPayrollRulesController::class, 'storeIncomeTaxRules'])->name('store_income_tax');
        Route::post('/settings/payroll/overtime', [SettingPayrollRulesController::class, 'storeOvertimeRules'])->name('store_overtime');

    });

    Route::get('/select/search/coa_categories/{query}', [SettingChartOfAccountsController::class, 'ajaxSearchCategories']);
    Route::post('/settings/coa', [SettingChartOfAccountsController::class, 'store']);

/**
 * Account Settings
 */
Route::group([
    'as' => 'account.'
], function() {
    Route::get('/account', [AccountSettingsController::class, 'index'])->name('index');
});
