<?php

declare(strict_types=1);

namespace MyCare\Auth\Infrastructure;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MyCare\Shared\Infrastructure\User\Eloquent\User;

final class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @throws AuthenticationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        // @phpstan-ignore-next-line
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        if (!Auth::validate($credentials)) {
            throw new AuthenticationException('Your credentials are invalid, please verify your email and password.');
        }

        /**
         * @var User $user
         */
        $user = User::where('email', '=', $credentials['email'])->first();
        if (!$user->getDomain()->isVerified()) {
            throw new Exception('You must verify your email address before to continuing.');
        }

        Auth::attempt($credentials);
        $request->session()->regenerate();

        return response()->json(null, 200);
    }
}
