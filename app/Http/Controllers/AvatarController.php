<?php

namespace App\Http\Controllers;

use App\Services\Avatar\AvatarManager;

class AvatarController extends Controller
{
  /**
   * Display the avatar.
   */
  public function index(AvatarManager $avatarManager)
  {
    return response()->json(['avatarUrl' => $avatarManager->getAvatarUrl()]);
  }
}
