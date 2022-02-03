<?php

namespace App\GraphQL\Types\Files;


use App\GraphQL\Models\Files\File;
use App\GraphQL\Types\BaseType;
use App\GraphQL\Types\Types;

class FileType extends BaseType
{
    public const NAME = 'fileType';

    public const MODEL = File::class;

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Types::nullableId()
            ],
            'type_id' => [
                'type' => Types::nullableId()
            ],
            'name' => [
                'type' => Types::nullableString(),
            ],
            'is_main' => [
                'type' => Types::nullableBoolean(),
            ],
            'origin_name' => [
                'type' => Types::nullableString(),
            ],
            'size' => [
                'type' => Types::nullableFloat(),
            ],
            'mime_type' => [
                'type' => Types::nullableString(),
            ],
            'weight' => [
                'type' => Types::nullableInt(),
            ],
            'height' => [
                'type' => Types::nullableInt(),
            ],
            'type' => [
                'type' => FileTypeType::type(),
                'is_relation' => true,
                'always' => [
                    'type_id',
                ],
            ],
            'sizes' => [
                'type' => Types::listOf(self::type()),
                'is_relation' => true,
                'always' => [
                    'parent_id',
                ],
            ],
            'src' => [
                'type' => Types::nullableString(),
                'selectable' => false,
                'always' => [
                    'name'
                ]
            ],
        ];
    }
}
