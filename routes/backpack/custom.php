<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::get('registration', 'RegistrationController@index')->name('page.registration.index');
    Route::get('adminpanel', 'AdminpanelController@index')->name('page.adminpanel.index');
    Route::crud('room', 'RoomCrudController');
    Route::crud('doctor', 'DoctorCrudController');
    Route::crud('bill', 'BillCrudController');
    Route::get('checkout', 'CheckoutController@index')->name('page.checkout.index');
}); // this should be the absolute last line of this file
