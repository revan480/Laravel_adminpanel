<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::post('/store',
    [RegistrationController::class, 'store']
)->name('page.registration.store');

// Make default page '/admin/login'
Route::get('/', function () {
    return redirect('/admin/login');
});

Route::match(['get','post'],'/checkout/search',
    [CheckoutController::class, 'show']
)->name('page.bill.checkout');


Route::get('/admin/show',function(){
    return view('admin.show');
})->name("page.checkout.show");
