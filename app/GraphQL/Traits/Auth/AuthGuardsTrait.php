<?php

namespace App\GraphQL\Traits\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use App\GraphQL\Models\Users\User;

trait AuthGuardsTrait
{
    protected string $guard = User::GUARD;

    public function can(string $permission, $arguments = []): bool
    {
        if (!isProd() && config('grants.permissions_disable')) {
            return true;
        }

        $permissions = strpos($permission, '|')
            ? explode('|', $permission)
            : $permission;

        return $this->authCheck()
            && $this->user()->canAny($permissions, $arguments);
    }

    protected function authCheck(string $guard = null): bool
    {
        return $this->getAuthGuard($guard ?? $this->guard)->check();
    }

    protected function getAuthGuard(string $guard = null): Guard
    {
        return Auth::guard($guard ?? $this->guard);
    }

    protected function user(string $guard = null): ?Authenticatable
    {
        return $this->getAuthGuard($guard ?? $this->guard)->user();
    }

    public function authId(string $guard = null): ?int
    {
        return $this->getAuthGuard($guard ?? $this->guard)->id();
    }

    protected function withoutAuth(): bool
    {
        return true;
    }
}
