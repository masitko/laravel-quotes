<?php

namespace App\Http\Controllers;

use App\Facades\Quotes;
use Illuminate\Http\JsonResponse;

class QuotesController extends Controller
{

  /**
   * Display listing of the current quotes.
   */
  public function index(): JsonResponse
  {
    return response()->json(['quotes' =>  Quotes::getQuotes()]);
  }

  /**
   * Refresh the quotes.
   */
  public function refresh(): JsonResponse
  {
    return response()->json(['quotes' =>  Quotes::refreshQuotes()]);
  }
}
