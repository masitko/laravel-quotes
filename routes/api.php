<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuotesController;
use App\Http\Middleware\CheckAuthenticationToken;

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JsonResponseMiddleware;


/**
 * Middleware group to ensure that all responses are in JSON format.
 * 
 */
Route::middleware([JsonResponseMiddleware::class])->group(function () {

/**
 * V1 API Routes Group so that we can have a versioned API.
 * 
 * Using the CheckAuthenticationToken middleware to make sure the incoming request has a valid 'Authorization' header.
 */
Route::group(
    [
      'prefix' => 'v1',
      'middleware' => [CheckAuthenticationToken::class]
    ],
    function () {
      Route::get('/quotes', [QuotesController::class, 'index'])->name('quotes.index');
      Route::put('/quotes/refresh', [QuotesController::class, 'refresh'])->name('quotes.refresh');
    }
  );

  Route::group(
    [
      'prefix' => 'auth',
    ],
    function () {
      Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
      Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    }
  );
});
