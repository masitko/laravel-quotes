<?php

namespace Tests\Unit;

use App\Services\Avatar\GiphyDriver;

use Illuminate\Http\JsonResponse;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GiphyDriverTest extends TestCase
{
  public function test_get_avatar_url_should_try_to_get_the_url_from_cache_first(): void
  {
    $testAvatarUrl = 'some_mocked_url';

    Cache::shouldReceive('get')
      ->once()
      ->with('avatar:giphy')
      ->andReturn($testAvatarUrl);

    $driver = new GiphyDriver();
    $result = $driver->getAvatarUrl();
    $this->assertEquals($testAvatarUrl, $result);
  }

  public function test_refresh_avatar_should_clear_avatar_from_cache_and_call_get_remote_avatar_method(): void
  {
    $testAvatarUrl = 'some_mocked_url';

    Log::shouldReceive('debug')
      ->once()
      ->with('Refreshing avatar from Giphy');
    Cache::shouldReceive('forget')
      ->once()
      ->with('avatar:giphy')
      ->andReturn(true);

    $driverMock = \Mockery::mock(GiphyDriver::class)->shouldAllowMockingProtectedMethods()->makePartial();
    $driverMock->shouldReceive('getRemoteAvatar')
      ->andReturn($testAvatarUrl);

    $result = $driverMock->refreshAvatar();
    $this->assertEquals($testAvatarUrl, $result);
  }

  public function atest_get_remote_avatar_should_call_the_giphy_api_and_cache_the_result(): void
  {
    $testAvatarUrl = 'some_mocked_url';
    $testResponse = [
      'data' => [
        ['images' => ['original' => ['url' => $testAvatarUrl]]]
      ]
    ];

    $mockResponse = \Mockery::mock(JsonResponse::class);
    $mockResponse->shouldReceive('json')
      ->once()
      ->andReturn($testResponse);

    Cache::shouldReceive('forever')
      ->once()
      ->with('avatar:giphy', $testAvatarUrl)
      ->andReturn(true);

    Config::shouldReceive('get')
      ->once()
      ->with('avatar.giphy_api_key')
      ->andReturn('test_giphy_api_key');

    Http::shouldReceive('acceptJson')
      ->once()
      ->andReturnSelf();
    Http::shouldReceive('get')
      ->once()
      ->withSomeOfArgs('api.giphy.com/v1/gifs/search')
      ->andReturn($mockResponse);

    $driver = new GiphyDriver();
    $result = $driver->getRemoteAvatar();
    $this->assertEquals($testAvatarUrl, $result);
  }
}
