<?php

namespace App\Http\Controllers;

use App\Interfaces\GetAvatarApiDriver;

class AvatarController extends Controller
{
  /**
   * Display the avatar.
   */
  public function index(GetAvatarApiDriver $avatarDriver)
  {
    return response()->json(['avatarUrl' => $avatarDriver->getAvatarUrl()]);
  }
}
