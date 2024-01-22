<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\YachtController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\LocationController;
use App\Http\Controllers\Client\PaypalController;
use App\Http\Controllers\Notifi\TelegramBotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Routes for Admin
//api delete images from storage
Route::get('/delete-image/{id}', [ProductController::class, 'deleteImage'])->name('delete-image');

//api create admin account
Route::get('/createAdmin', [UserController::class, 'createUserAdmin']);

//api getBookingDate
Route::post('/getBookingDate', [AdminBookingController::class, 'getBookingDateByYacht'])->name('getBookingDate');

//Routes for Client
//Api Login-Register service
Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
    });

//Api authen service
Route::prefix('auth')
    ->middleware(['auth:api'])
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('profile', 'profile');
        Route::get('refresh', 'refreshToken');
        Route::get('logout', 'logout');
        Route::put('edit-user', 'update');
        Route::put('change-password', 'changePassword');
    });


Route::prefix('v1')->group(function () {

    // Api Bookings service
    Route::prefix('bookings')
        ->middleware(['auth:api'])
        ->controller(BookingController::class)
        ->group(function () {
            Route::post('', 'booking');
            Route::get('/payment-status/{id}', 'paymentStatus');
            Route::get('', 'getBookingsByUser');
            Route::get('/{id}', 'getBookingById');
            Route::post('feedback/{id}', 'feedBack');
        });

    Route::prefix('bookings')
        ->controller(BookingController::class)
        ->group(function () {
            Route::get('/date/{id}', 'getBookingDateYacht');
            Route::get('/feedback/{id}', 'getFeedBack');
        });

    // Api Yachts service
    Route::prefix('yachts')
        ->controller(YachtController::class)
        ->group(function () {
            Route::get('', 'getYachts');
            Route::post('', 'getYachtsByFilter');
            Route::get('/{id}', 'getYacht');
            Route::get('/feedback/{id}', 'getFeedBack');
        });

    Route::prefix('categories')
        ->controller(CategoryController::class)
        ->group(function () {
            Route::get('', 'getCategories');
        });

    Route::prefix('locations')
        ->controller(LocationController::class)
        ->group(function () {
            Route::get('', 'getLocations');
        });

    Route::prefix('contact')
        ->controller(ContactController::class)
        ->group(function () {
            Route::post('', 'contact');
        });
});


//api Payment
Route::prefix('paypal')
    ->controller(PaypalController::class)
    ->group(function () {
        Route::post('/{id}', 'paypal');
        Route::get('/{id}/success', 'success')->name('success');
        Route::get('/{id}/cancel', 'cancel')->name('cancel');
    });

//api send Email
Route::prefix('email')
    ->controller(MailController::class)
    ->group(function () {
        Route::post('/booking/{id}', 'bookingSuccess');
    });

Route::get('/updated-activity', [TelegramBotController::class, 'updatedActivity']);
