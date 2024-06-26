<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

use ReallySimpleJWT\Token;


class AuthController extends Controller
{
  public function register(Request $request): JsonResponse
  {
    $validated = $request->validate([
      "name" => 'required|string|max:40',
      "email" => 'required|email|unique:users|max:40',
      "password" => 'required|string|max:40',
    ]);

    $user = User::create([
      "name" => $validated["name"],
      "email" => $validated["email"],
      "password" => Hash::make($validated["password"]),
    ]);

    return response()->json([
      'user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
      ],
      'saved' => $user,
    ]);
  }

  public function login(Request $request): JsonResponse
  {
    $credentials = $request->validate([
      "email" => ["required", "email"],
      "password" => ["required", "string"],
    ]);
    if (Auth::attempt($credentials)) {
      return response()->json([
        'mesage' => 'User logged in succesfully',
        'token' => $this->getToken(Auth::user()),
      ], 200);
    };
    return response()->json(['error' => 'Wrong credentials, sorry'], 401);
  }

  public function logout()
  {
    // logout logic
  }

  protected function getToken(User|null $user)
  {
    $payload = [
      'iat' => time(),
      'exp' => time() + Config::get('jwt.expiration'),
      'iss' => 'localhost',
      'user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
      ],
    ];
    return Token::customPayload($payload, Config::get('jwt.secret'));
  }
}
