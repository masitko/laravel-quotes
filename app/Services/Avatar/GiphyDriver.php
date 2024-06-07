<?php

namespace App\Services\Avatar;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Interfaces\GetAvatarApiDriver;
use Illuminate\Support\Facades\Config;

class GiphyDriver implements GetAvatarApiDriver
{
  public function getAvatarUrl(): string
  {
    $avatar = Cache::get('avatar:giphy');
    if ($avatar === null) {
      $avatar = $this->getRemoteAvatar();
    }
    return $avatar;
  }

    /** 
    * Refresh the avatar from the remote API.
    * 
    * @param none
    * @return array
    */
    public function refreshAvatar(): string
    {
      Log::debug('Refreshing avatar from Giphy');
      Cache::forget('avatar:giphy');
      return $this->getRemoteAvatar();
    }
  
  
  protected function getRemoteAvatar(): string
  {
    $response = Http::acceptJson()->get('api.giphy.com/v1/gifs/search', [
      'api_key' => Config::get('avatar.giphy_api_key'),
      'q' => 'kayne west',
      'limit' => 10,
      'offset' => rand(0, 50)
    ]);
    $body = $response->json();
    $avatarUrl = $this->selectRandomAvatar($body['data']);
    Cache::forever('avatar:giphy', $avatarUrl);
    return $avatarUrl;
  }

  protected function selectRandomAvatar(array $images): string
  {
    return $images[rand(0, count($images) - 1)]['images']['original']['url'];
  }
}
