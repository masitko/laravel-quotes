<?php

namespace Tests\Feature;

use App\Facades\Quotes;
use App\Services\Quotes\BoringDriver;
use App\Services\Quotes\KayneWestDriver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class QuotesManagerTest extends TestCase
{
  public function test_quote_manager_should_return_a_default_driver_if_none_specified(): void
  {
    Config::set('quotes.default_driver', 'kayne-west');
    $driver = Quotes::driver();
    $this->assertInstanceOf(KayneWestDriver::class, $driver);

    Config::set('quotes.default_driver', 'boring');
    $driver = Quotes::driver();
    $this->assertInstanceOf(BoringDriver::class, $driver);
  }

  public function test_quote_manager_should_return_requested_driver(): void
  {
    Config::set('quotes.default_driver', 'boring');
    $driver = Quotes::driver('kayne-west');
    $this->assertInstanceOf(KayneWestDriver::class, $driver);

    Config::set('quotes.default_driver', 'kayne-west');
    $driver = Quotes::driver('boring');
    $this->assertInstanceOf(BoringDriver::class, $driver);
  }
}
