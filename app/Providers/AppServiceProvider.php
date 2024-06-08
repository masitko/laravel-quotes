<?php

namespace App\Providers;

use App\Interfaces\GetAvatarApiDriver;
use App\Interfaces\GetQuotesApiDriver;
use App\Services\Avatar\AvatarManager;
use App\Services\Quotes\QuotesManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->singleton(
      abstract: GetAvatarApiDriver::class,
      concrete: fn (Application $app) => (new AvatarManager($app))->driver()
    );
    $this->app->singleton(
      abstract: GetQuotesApiDriver::class,
      concrete: fn (Application $app) => (new QuotesManager($app))->driver()
    );
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    //
  }
}
