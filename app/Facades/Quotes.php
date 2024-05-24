<?php

namespace App\Facades;

use App\Services\Quotes\QuotesManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string driver(string $driver = null)
 * @method static string getQuotes()
 * @method static string refreshQuotes()
 *
 * @see QuotesManager
 */
class Quotes extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return QuotesManager::class;
    }
}