<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use ReallySimpleJWT\Token;


class CheckJWTToken
{

  private UserProvider $userProvider;

  public function __construct()
  {
    $this->userProvider = Auth::createUserProvider('users');
  }

  /**
   * CHecking if the incoming request has a valid 'Authorization' header.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\JsonResponse
   */
  public function handle(Request $request, Closure $next): Response|JsonResponse
  {
    $token = $request->bearerToken();

    try {
      if ($token && Token::validate($token, Config::get('jwt.secret'))) {
        $payload = Token::getPayload($token);
        if (isset($payload['user_id']))
          Auth::setUser($this->userProvider->retrieveById($payload['user_id']));
        $response =  $next($request);
        return $response;
      }
    } catch (\Exception $e) {
    }
    return response()->json([
      'error' => 'Unauthorized',
    ], 401);
  }
}
