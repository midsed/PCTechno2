<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $logs = Log::query()
            ->with(['user:user_id,username,full_name,role'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('action', 'like', "%{$q}%")
                      ->orWhereHas('user', function ($uq) use ($q) {
                          $uq->where('username', 'like', "%{$q}%")
                             ->orWhere('full_name', 'like', "%{$q}%")
                             ->orWhere('email', 'like', "%{$q}%");
                      });
            })
            ->orderByDesc('DateTime')
            ->paginate(10)
            ->withQueryString();

        return view('logs.index', compact('logs', 'q'));
    }
}
