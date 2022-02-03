<?php

namespace App\GraphQL\Services\Auth;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Laravel\Passport\RefreshToken;
use Throwable;

abstract class AuthPassportService
{
    protected Model|Builder $client;

    public function __construct(protected PassportService $passportService)
    {
        $this->client = $this->getOauthClientUser();
    }

    private function getOauthClientUser(): Model|Builder
    {
        $client = null;

        if (empty($client)) {
            throw new Exception('There is no client "oauth_clients" in the database');
        }

        return $client;
    }

    public function auth(string $login, string $password): array
    {
        return $this->passportService->auth(
            $login,
            $password,
            $this->getClientId(),
            $this->getClientSecret()
        );
    }

    abstract public function getClientId(): int;

    abstract public function getClientSecret(): string;

    public function authBySess(): array
    {
        $user = null;

        return $this->passportService->auth(
            $user->Login,
            $this->getClientSecret(),
            $this->getClientId(),
            $this->getClientSecret()
        );
    }

    public function refreshToken(string $refreshToken): array
    {
        return $this->passportService->refreshToken(
            $refreshToken,
            $this->getClientId(),
            $this->getClientSecret()
        );
    }

    public function logout($authenticatable): bool
    {
        try {
            $token = $authenticatable->token();

            RefreshToken::query()
                ->where('access_token_id', $token->id)
                ->delete();

            return $token->delete();
        } catch (Throwable $e) {
            return false;
        }
    }
}
