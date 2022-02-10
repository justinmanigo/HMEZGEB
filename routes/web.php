<?php

use Illuminate\Support\Facades\Route;
 
use App\Models\User;
// Customer module
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepositController;
// Vendor module
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\TransfersController;
use App\Http\Controllers\DepositsController;
use App\Http\Controllers\TransactionsController;  
// Banking module
use App\Http\Controllers\BillsController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\PaymentsController; 
// Journal module
use App\Http\Controllers\JournalVouchersController; 
// Human Resource module

// Inventory module

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
        Route::get('/receipt', [ReceiptController::class, 'index']);
        
    });

    Route::group([
        'as'=>'customers.'
    ], function(){ 
        Route::get('/customer', [CustomerController::class, 'index']);

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
        Route::get('/bill',[BillsController::class,'index']);

    });

    Route::group([
        'as'=>'vendors.'
    ], function(){ 

        Route::get('/vendorPage',[VendorsController::class,'index']);
        Route::get('/individualVendor',[VendorsController::class,'individualVendor']);
    });

    Route::group([
        'as'=>'payments.'
    ], function(){ 
        
        
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

      Route::get('/journals', [JournalVouchersController::class, 'index']);
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
        Route::get('/employee', [EmployeeController::class, 'index']);

    });

    Route::group([
        'as' => 'overtime.'
    ], function(){
        Route::get('/overtime', [OvertimeController::class, 'index']);

    });

    Route::group([
        'as' => 'additions.'
    ], function(){
        Route::get('/addition', [AdditionController::class, 'index']);

    });

    Route::group([
        'as' => 'deductions.'
    ], function(){
        Route::get('/deduction', [DeductionController::class, 'index']);

    });

    Route::group([
        'as' => 'loans.'
    ], function(){
        Route::get('/loan', [LoanController::class, 'index']);

    });
