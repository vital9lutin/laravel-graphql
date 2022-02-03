<?php

namespace App\GraphQL\Types\Translations;

use App\GraphQL\Types\BaseType;
use App\GraphQL\Types\Types;

class TranslationType extends BaseType
{
    public const NAME = 'translationType';

    public function fields(): array
    {
        return [
            'key' => [
                'type' => Types::notNullString()
            ],
            'value' => [
                'type' => Types::notNullString()
            ],
        ];
    }
}
