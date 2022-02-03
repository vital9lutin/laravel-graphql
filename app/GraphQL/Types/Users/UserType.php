<?php

namespace App\GraphQL\Types\Users;


use App\GraphQL\Models\Users\User;
use App\GraphQL\Types\BaseType;
use App\GraphQL\Types\Types;

class UserType extends BaseType
{
    public const NAME = 'userType';

    public const MODEL = User::class;

    public function fields(): array
    {
        return parent::fields() + [
                'id' => [
                    'type' => Types::nullableInt()
                ],
                'name' => [
                    'type' => Types::nullableString(),
                ],
            ];
    }
}
