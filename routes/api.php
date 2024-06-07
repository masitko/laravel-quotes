<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuotesController;
use App\Http\Middleware\CheckAuthenticationToken;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarController;
use App\Http\Middleware\CheckJWTToken;
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
      Route::get('/avatar', [AvatarController::class, 'index'])->name('v1.avatar.index');
      Route::get('/quotes', [QuotesController::class, 'index'])->name('v1.quotes.index');
      Route::put('/quotes/refresh', [QuotesController::class, 'refresh'])->name('v1.quotes.refresh');
    }
  );

  /**
   * V2 API Routes Group with upgraded to JWT authentication.
   * 
   * Using the CheckJWTToken middleware to make sure the incoming request has a valid JWT token.
   */
  Route::group(
    [
      'prefix' => 'v2',
      'middleware' => [CheckJWTToken::class]
    ],
    function () {
      Route::get('/avatar', [AvatarController::class, 'index'])->name('v2.avatar.index');
      Route::get('/quotes', [QuotesController::class, 'index'])->name('v2,quotes.index');
      Route::put('/quotes/refresh', [QuotesController::class, 'refresh'])->name('v2.quotes.refresh');
    }
  );

  /**
   * All authentication routes.
   */
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
