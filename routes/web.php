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
});

// Route::group(['middleware' => 'auth:sanctum'], function () {
    
// });