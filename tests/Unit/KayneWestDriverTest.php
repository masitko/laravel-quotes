<?php

namespace Tests\Unit;

use App\Services\Quotes\KayneWestDriver;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\MockObject\MockObject;

class KayneWestDriverTest extends TestCase
{
  private KayneWestDriver | MockObject $driverMock;
  public function setUp(): void {
    $this->driverMock = $this->getMockBuilder(KayneWestDriver::class)->onlyMethods(['getRemoteQuotes'])->getMock();
  }

  public function test_get_quotes_should_try_to_get_quotes_from_cache_first(): void
  {
    $testQuotes = ['some_mocked_quotes'];

    Cache::shouldReceive('get')
      ->once()
      ->with('quotes:kayne-west')
      ->andReturn($testQuotes);

    $driver = new KayneWestDriver();
    $result = $driver->getQuotes();
    $this->assertEquals($testQuotes, $result);
  }

  public function test_get_quotes_should_call_get_remote_quotes_if_cache_is_empty(): void
  {
    $testQuotes = ['some_mocked_quotes'];

    Cache::shouldReceive('get')
      ->once()
      ->with('quotes:kayne-west')
      ->andReturn(null);

    $this->driverMock->expects($this->once())->method('getRemoteQuotes')->willReturn($testQuotes);
    $result = $this->driverMock->getQuotes();
    $this->assertEquals($testQuotes, $result);
  }


  public function test_refresh_quotes_should_clear_quotes_from_cache_and_call_get_remote_quotes_method(): void
  {
    $testQuotes = ['some_mocked_quotes'];

    Cache::shouldReceive('forget')
      ->once()
      ->with('quotes:kayne-west')
      ->andReturn(true);

    $this->driverMock->expects($this->once())->method('getRemoteQuotes')->willReturn($testQuotes);
    $result = $this->driverMock->refreshQuotes();
    $this->assertEquals($testQuotes, $result);
  }
}
