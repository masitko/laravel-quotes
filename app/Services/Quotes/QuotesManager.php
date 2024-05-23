<?php

namespace App\Services\Quotes;

use App\Interfaces\GetQuotesApiDriver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Manager;


class QuotesManager extends Manager
{
  public function createBoringDriver(): GetQuotesApiDriver
  {
    return new BoringDriver();
  }

  public function createKayneWestDriver(): GetQuotesApiDriver
  {
    return new KayneWestDriver();
  }

  /**
   * Get the default driver, trying config first.
   *
   * @return string
   */
  public function getDefaultDriver(): string
  {
    return Config::get('quotes.default_driver', 'kayne-west');
  }
}
