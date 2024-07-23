<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Auth;
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

// Default route for the welcome page
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (login, register, etc.)
Auth::routes();

// Route for the home page after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Resource routes for EmployeeController with authentication middleware
Route::resource('employees', EmployeeController::class)->middleware('auth');

// Route for searching employees
Route::post('employees/search', [EmployeeController::class, 'search'])->name('employees.search');

