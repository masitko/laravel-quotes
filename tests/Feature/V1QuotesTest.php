<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class V1QuotesTest extends TestCase
{
  public function test_v1_request_without_token_returns_401(): void
  {
    $response = $this->get(route("v1.quotes.index"));
    $response->assertStatus(401);
  }

  public function test_v1_request_with_wrong_token_returns_401(): void
  {
    $response = $this->withHeaders([
      'Authorization' => 'wrong_token'
    ])->get(route("v1.quotes.index"));    
    $response->assertStatus(401);
  }

  public function test_v1_request_with_correct_token_returns_200_with_quotes(): void
  {
    $response = $this->withHeaders([
      'Authorization' => env('AUTHORIZATION_TOKEN')
    ])->get(route("v1.quotes.index"));
    $response->assertStatus(200);
    $response->assertJsonStructure(['quotes']);
    $response->assertJsonCount(config('quotes.amount'), 'quotes');
  }

  public function test_v1_refresh_should_allow_only_put_requests(): void
  {
    $response = $this->withHeaders([
      'Authorization' => env('AUTHORIZATION_TOKEN')
    ])->get(route("v1.quotes.refresh"));
    $response->assertStatus(405);
  }

  /**
   * There is a very small chance that this test will fail if the quotes are the same after refresh.
   */
  public function test_v1_refresh_should_refresh_quotes(): void
  {
    $response = $this->withHeaders([
      'Authorization' => env('AUTHORIZATION_TOKEN')
    ])->get(route("v1.quotes.index"));
    $refreshedResponse = $this->withHeaders([
      'Authorization' => env('AUTHORIZATION_TOKEN')
    ])->put(route("v1.quotes.refresh"));
    $this->assertNotEquals($response->json('quotes'), $refreshedResponse->json('quotes'));
  }
}
