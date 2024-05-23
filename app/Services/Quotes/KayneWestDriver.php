<?php

namespace App\Services\Quotes;

use App\Interfaces\GetQuotesApiDriver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class KayneWestDriver implements GetQuotesApiDriver
{
  /**
   * Get the quotes from the cache or the remote API.
   * 
   * @param none
   * @return array
   */
  public function getQuotes(): array
  {
    $quotes = Cache::get('quotes:kayne-west');
    if ($quotes === null) {
      $quotes = $this->getReomteQuotes();
    }
    return $quotes;
  }

  /*
    * Refresh the quotes from the remote API.
    * 
    * @param none
    * @return array
    */
  public function refreshQuotes(): array
  {
    Cache::forget('quotes:kayne-west');
    return $this->getReomteQuotes();
  }

  /**
   * Get the quotes from the remote API.
   * 
   * @param none
   * @return array
   */
  private function getReomteQuotes(): array
  {
    $quotes = [];
    $quotesCount = Config::get('quotes.amount');

    for ($i = 0; $i < $quotesCount; $i++)
      array_push($quotes, (Http::get('https://api.kanye.rest'))['quote']);
    Cache::forever('quotes:kayne-west', $quotes);

    return $quotes;
  }
}
