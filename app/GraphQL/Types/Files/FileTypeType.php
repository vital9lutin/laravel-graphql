<?php

namespace App\GraphQL\Types\Files;

use App\GraphQL\Models\Files\FileType as ModelFileType;
use App\GraphQL\Types\BaseType;
use App\GraphQL\Types\Types;

class FileTypeType extends BaseType
{
    public const NAME = 'fileTypeType';

    public const MODEL = ModelFileType::class;

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Types::nullableId()
            ],
            'name' => [
                'type' => Types::nullableString(),
            ],
            'key' => [
                'type' => Types::nullableString(),
            ],
        ];
    }
}
