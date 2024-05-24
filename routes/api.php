<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuotesController;
use App\Http\Middleware\CheckAuthenticationToken;

/**
 * 
 * V1 API Routes Group so that we can have a versioned API.
 * 
 * Using the CheckAuthenticationToken middleware to check if the incoming request has a valid 'Authorization' header.
 * 
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
