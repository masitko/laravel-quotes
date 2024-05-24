<?php

namespace Tests\Unit;

use App\Services\Quotes\BoringDriver;
use PHPUnit\Framework\TestCase;

class BoringDriverTest extends TestCase
{
  public function test_get_boring_quotes_should_return_5_quotes() {
    $boringDriver = new BoringDriver();
    $result = $boringDriver->getQuotes();
    $this->assertIsArray($result);
    $this->assertCount(5, $result);
    $this->assertContains('Hello, World!', $result);
  }

  public function test_refresh_quotes_should_also_return_5_quotes_but_hello_world_should_not_be_first() {
    $boringDriver = new BoringDriver();
    $result = $boringDriver->refreshQuotes();
    $this->assertIsArray($result);
    $this->assertCount(5, $result);
    $this->assertNotEquals('Hello, World!', $result[0]);
  }

}
