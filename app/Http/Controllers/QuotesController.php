<?php

namespace App\Http\Controllers;

use App\Services\Quotes\QuotesManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class QuotesController extends Controller
{

  /**
   * Display listing of the current quotes.
   */
  public function index(QuotesManager $quoteManager): JsonResponse
  {
    return response()->json(['quotes' =>  $quoteManager->getQuotes()]);
  }

  /**
   * Refresh the quotes.
   */
  public function refresh(QuotesManager $quoteManager): JsonResponse
  {
    return response()->json(['quotes' =>  $quoteManager->refreshQuotes()]);
  }
}
