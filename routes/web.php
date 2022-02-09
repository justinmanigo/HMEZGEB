<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
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

Route::get('/bill',[App\Http\Controllers\HomeController::class, 'bill'])->name('bill');
Route::get('/vendorPage',[App\Http\Controllers\HomeController::class, 'vendor'])->name('vendors');

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
Route::get('/receipt', [App\Http\Controllers\ReceiptController::class, 'index'])->name('receipt.index');
Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
Route::get('/deposit', [App\Http\Controllers\DepositController::class, 'index'])->name('deposit.index');

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