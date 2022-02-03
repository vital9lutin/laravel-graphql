<?php

namespace App\GraphQL\Services\Auth;

class UserPassportService extends AuthPassportService
{
    public function getClientId(): int
    {
        return $this->client['id'];
    }

    public function getClientSecret(): string
    {
        return $this->client['secret'];
    }

}
