<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class CheckAuthenticationToken
{
    /**
     * CHecking if the incoming request has a valid 'Authorization' header.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        if( $request->header('Authorization') !== env('AUTHORIZATION_TOKEN') ) {
          return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}