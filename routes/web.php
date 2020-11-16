<?php

use Illuminate\Support\Facades\Route;

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
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('home', 'App\Http\Controllers\DashboardController@index');
    Route::apiResource('employees', 'App\Http\Controllers\EmployeeController');
    Route::get('employees-create', 'App\Http\Controllers\EmployeeController@create')->name('employees.create');
    Route::get('employees-edit', 'App\Http\Controllers\EmployeeController@edit')->name('employees.edit');
    Route::get('employee-multimedia/{employee}', 'App\Http\Controllers\EmployeeController@multimedia')->name('employee.multimedia');
    
    Route::apiResource('address', 'App\Http\Controllers\AddressController');
    Route::get('address-create/{employee}', 'App\Http\Controllers\AddressController@create')->name('address.create');
    Route::apiResource('contact', 'App\Http\Controllers\ContactController');
    Route::get('contact-create/{employee}', 'App\Http\Controllers\ContactController@create')->name('contact.create');
    Route::apiResource('next_of_kin', 'App\Http\Controllers\NextOfKinController');
    Route::get('next-of-kin-create/{employee}', 'App\Http\Controllers\NextOfKinController@create')->name('next_of_kin.create');
    Route::apiResource('contract', 'App\Http\Controllers\ContractController');
    Route::get('contract-create/{employee}', 'App\Http\Controllers\ContractController@create')->name('contract.create');
    Route::apiResource('usersetting', 'App\Http\Controllers\UserSettingController');
    Route::apiResource('report', 'App\Http\Controllers\ReportController');

    Route::apiResource('venue', 'App\Http\Controllers\VenueController');
    Route::get('venue-create', 'App\Http\Controllers\VenueController@create')->name('venue.create');

    Route::apiResource('commissions', 'App\Http\Controllers\CommissionController');
    Route::get('commissions-create', 'App\Http\Controllers\CommissionController@create')->name('commissions.create');

    Route::apiResource('payment_methods', 'App\Http\Controllers\PaymentMethodController');
    Route::get('payment_methods-create', 'App\Http\Controllers\PaymentMethodController@create')->name('payment_methods.create');

    Route::apiResource('store_services', 'App\Http\Controllers\StoreServiceController');
    Route::get('store_services-create', 'App\Http\Controllers\StoreServiceController@create')->name('store_services.create');

    Route::apiResource('roles', 'App\Http\Controllers\RoleController');
    Route::get('employee-acl/{employee}', 'App\Http\Controllers\RoleController@fetch_access_control')->name('employee.acl');
    Route::put('employee-update-acl/{employee}', 'App\Http\Controllers\RoleController@update_access_control')->name('employee.update.acl');
});

// Route::group(['middleware' => 'auth:sanctum'], function () {
    
// });