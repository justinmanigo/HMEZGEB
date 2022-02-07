<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;   
use Illuminate\Support\Facades\Auth;
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
Route::get('/payroll', [App\Http\Controllers\PayrollController::class, 'index'])->name('payroll.index');
Route::get('/employees', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.index');
Route::get('/overtime', [App\Http\Controllers\OvertimeController::class, 'index'])->name('overtime.index');
Route::get('/addition', [App\Http\Controllers\AdditionController::class, 'index'])->name('addition.index');
Route::get('/deduction', [App\Http\Controllers\DeductionController::class, 'index'])->name('deduction.index');
Route::get('/loan', [App\Http\Controllers\LoanController::class, 'index'])->name('loan.index');