<?php

namespace App\Services\Avatar;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Manager;

class AvatarManager extends Manager
{
  public function createGiphyDriver(): GiphyDriver
  {
    return new GiphyDriver();
  }

  /**
   * Get the default driver, trying config first.
   *
   * @return string
   */
  public function getDefaultDriver(): string
  {
    return Config::get('avatar.default_driver', 'giphy');
  }
}