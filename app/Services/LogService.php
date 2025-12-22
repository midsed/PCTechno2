<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogService
{
  public static function add(string $action): void
  {
    $u = Auth::user();
    if (!$u) return;

    Log::create([
      'user_id' => $u->user_id,
      'action' => $action,
      'DateTime' => now(),
    ]);
  }
}
