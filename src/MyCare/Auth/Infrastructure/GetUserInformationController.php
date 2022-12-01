<?php

declare(strict_types=1);

namespace MyCare\Auth\Infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class GetUserInformationController extends Controller
{
    public function __invoke(Request $request)
    {
        return $request->user()->getDomain()->toShow();
    }
}
