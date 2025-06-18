<?php

declare(strict_types=1);

namespace Laravel\Dusk\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * @internal
 */
final readonly class UserController
{
    /**
     * Retrieve the authenticated user identifier and class name.
     *
     * @return array{id?: int|string, className?: string}
     */
    public function user(?string $guard = null): array
    {
        $user = Auth::guard($guard)->user();

        if ($user === null) {
            return [];
        }

        $id = $user->getAuthIdentifier();

        assert(is_string($id));

        return ['id' => $id, 'className' => get_class($user)];
    }

    /**
     * Login using the given user ID / email.
     */
    public function login(string $userId, ?string $guard = null): Response
    {
        $guard = $guard ?: config('auth.defaults.guard');

        $provider = Auth::guard($guard)->getProvider();

        $user = Str::contains($userId, '@')
            ? $provider->retrieveByCredentials(['email' => $userId])
            : $provider->retrieveById($userId);

        Auth::guard($guard)->login($user);

        return response(status: 204);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(?string $guard = null): Response
    {
        $guard = $guard ?: config('auth.defaults.guard');

        Auth::guard($guard)->logout();

        Session::forget('password_hash_'.$guard);

        return response(status: 204);
    }
}
