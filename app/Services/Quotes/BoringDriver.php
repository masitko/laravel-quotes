<?php

namespace App\Services\Quotes;

use App\Interfaces\GetQuotesApiDriver;

class BoringDriver implements GetQuotesApiDriver
{
  private $boringQuotes = [
    'Hello, World!',
    'I am a boring quote.',
    'I am a boring quote too.',
    'I am a boring quote as well.',
    'I am a boring quote, yet again.'
  ];

  public function getQuotes(): array
  {
    return $this->boringQuotes;
  }
  
  public function refreshQuotes(): array
  {
    return $this->boringQuotes;
  }
}