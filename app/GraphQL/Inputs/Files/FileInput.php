<?php

namespace App\GraphQL\Inputs\Files;


use App\GraphQL\Inputs\BaseInput;
use App\GraphQL\Models\Files\File;
use App\GraphQL\Types\Types;

class FileInput extends BaseInput
{
    public const NAME = 'fileInput';

    public const MODEL = File::class;

    public function fields(): array
    {
        return [
            'file' => [
                'type' => Types::file()
            ],
            'is_main' => [
                'type' => Types::notNullBoolean(),
            ],
            'type_id' => [
                'type' => Types::notNullId(),
            ],
            'sizes' => [
                'type' => Types::listOf(FileSizeInput::type()),
            ],
        ];
    }
}
