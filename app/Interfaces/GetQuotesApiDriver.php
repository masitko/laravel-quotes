<?php

namespace App\Interfaces;

interface GetQuotesApiDriver
{
  public function getQuotes(): array;
  
  public function refreshQuotes(): array;
}
