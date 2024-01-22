<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeaderController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SkipperController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

use App\Models\Location;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('admin/dashboard');
});

Route::get('auth/login', [LoginController::class, 'loginPage'])->name('loginPage');
Route::post('auth/login', [LoginController::class, 'login'])->name('login');
Route::get('auth/logout', LogoutController::class)->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware('check_login')
    ->group(function () {
        Route::prefix('dashboard')
            ->name('dashboard.')
            ->controller(DashboardController::class)
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('list-booking', 'list_booking')->name('list-booking');
                Route::get('bookings', 'bookings')->name('bookings');
                Route::get('booking-detail/{id}', 'booking_detail')->name('booking-detail');
                Route::post('admin-action/{id}', 'adminAction')->name('adminAction');
                Route::get('booking-detail/{id}/add-crew-members', 'addCrewMember')->name('addCrewMember');
                Route::post('booking-detail/{id}/create-crew-members', 'createCrewMember')->name('createCrewMember');
                Route::get('search', 'search')->name('search');                
            });

        Route::prefix('category')
            ->name('category.')
            ->controller(CategoryController::class)
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('destroy');
            });

        Route::prefix('location')
            ->name('location.')
            ->controller(LocationController::class)
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('destroy');
            });

        Route::prefix('product')
            ->name('product.')
            ->controller(ProductController::class)
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('show/{id}', 'show')->name('show');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('destroy');
                Route::get('search_info', 'search_info')->name('search_info');
                Route::get('search', 'search')->name('search');
            });

        Route::prefix('user')
            ->name('user.')
            ->controller(UserController::class)
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('show/{id}', 'show')->name('show');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('destroy');
            });

        Route::prefix('skipper')
            ->name('skipper.')
            ->controller(SkipperController::class)
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::post('update/{id}', 'update')->name('update');
                Route::get('destroy/{id}', 'destroy')->name('destroy');
            });

        Route::prefix('booking')
            ->name('booking.')
            ->controller(BookingController::class)
            ->group(function () {
                Route::get('/{id}', 'index')->name('index');
                Route::post('/create', 'createBooking')->name('create');
            });

        Route::prefix('contact')
            ->name('contact.')
            ->controller(ContactController::class)
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
            });        
    });
