<?php

namespace App\GraphQL\Inputs\Files;


use App\GraphQL\Inputs\BaseInput;
use App\GraphQL\Models\Users\User;
use App\GraphQL\Types\Types;

class FileSizeInput extends BaseInput
{
    public const NAME = 'fileSizeInput';

    public const MODEL = User::class;

    public function fields(): array
    {
        return [
            'height' => [
                'type' => Types::notNullInt()
            ],
            'weight' => [
                'type' => Types::notNullInt()
            ],
        ];
    }
}
