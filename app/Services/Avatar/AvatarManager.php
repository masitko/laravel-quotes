<?php

namespace App\Services\Avatar;

use App\Interfaces\GetAvatarApiDriver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Manager;

class AvatarManager extends Manager
{
  public function createGiphyDriver(): GetAvatarApiDriver
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