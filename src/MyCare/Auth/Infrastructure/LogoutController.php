<?php

declare(strict_types=1);

namespace MyCare\Auth\Infrastructure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class LogoutController
{
    public function __invoke(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response(null, 201);
    }
}
