<?php

namespace App\Interfaces;

interface GetAvatarApiDriver
{
  /**
   * Get random avatar from the remote API.
   * 
   * @param none
   * @return string
   */
  public function getAvatarUrl(): string;
}