<?php

declare(strict_types=1);

namespace Laravel\Dusk\Http\Controllers;

use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;
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

        return ['id' => $id, 'className' => $user::class];
    }

    /**
     * Login using the given user ID / email.
     */
    public function login(string $userId, ?string $guard = null): Response
    {
        $guard = is_string($guard) ? $guard : config('auth.defaults.guard');

        assert(is_string($guard));

        $guard = Auth::guard($guard);

        /** @var SessionGuard $guard */
        $provider = $guard->getProvider();

        $user = Str::contains($userId, '@')
            ? $provider->retrieveByCredentials(['email' => $userId])
            : $provider->retrieveById($userId);

        assert($user instanceof Authenticatable);

        $guard->login($user);

        $response = response(status: 204);

        assert($response instanceof Response);

        return $response;
    }

    /**
     * Log the user out of the application.
     */
    public function logout(?string $guard = null): Response
    {
        $guardAsString = is_string($guard) ? $guard : config('auth.defaults.guard');

        assert(is_string($guardAsString));

        /** @var SessionGuard $guard */
        $guard = Auth::guard($guardAsString);

        $guard->logout();

        Session::forget('password_hash_'.$guardAsString);

        $response = response(status: 204);

        assert($response instanceof Response);

        return $response;
    }
}
