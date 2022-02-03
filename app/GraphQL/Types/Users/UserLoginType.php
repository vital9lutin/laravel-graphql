<?php

namespace App\GraphQL\Types\Users;

use App\GraphQL\Types\BaseType;
use App\GraphQL\Types\Types;

class UserLoginType extends BaseType
{
    public const NAME = 'userLoginType';

    public function fields(): array
    {
        return [
            'session' => [
                'type' => Types::notNullString(),
            ],
            'token_type' => [
                'type' => Types::notNullString(),
            ],
            'expires_in' => [
                'type' => Types::notNullInt(),
            ],
            'access_token' => [
                'type' => Types::notNullString(),
            ],
            'refresh_token' => [
                'type' => Types::notNullString(),
            ],
            'is_member' => [
                'type' => Types::nullableBoolean(),
            ],
        ];
    }
}
