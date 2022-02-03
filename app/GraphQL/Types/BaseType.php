<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\NullableType;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;
use App\GraphQL\Models\Files\File;
use App\GraphQL\Services\Files\FileService;
use App\GraphQL\Traits\Auth\AuthGuardsTrait;
use App\GraphQL\Traits\Types\BaseTypeTrait;
use App\GraphQL\Types\Files\FileType;
use Rebing\GraphQL\Support\Type;

abstract class BaseType extends Type implements NullableType
{
    use BaseTypeTrait;
    use AuthGuardsTrait;

    public function fields(): array
    {
        return [
            'files' => [
                'type' => Types::listOf(FileType::type()),
                'is_relation' => true,
                'always' => [
                    'type_id',
                ],
                'args' => [
                    'types' => [
                        'type' => Types::listOfInt(),
                    ],
                    'main' => [
                        'type' => Types::nullableBoolean(),
                    ],
                ],
                'query' => static function (array $args, MorphMany $query): MorphMany {
                    if (!empty($args['types'])) {
                        $query->whereIn(DB::raw(File::TABLE . '.type_id'), $args['types']);
                    }

                    if (isset($args['main'])) {
                        $query->where(DB::raw(File::TABLE . '.is_main'), (bool)$args['main']);
                    }

                    return $query;
                }
            ],
            'defaultFileLink' => [
                'type' => Types::nullableString(),
                'selectable' => false,
                'resolve' => function () {
                    return FileService::getUrl();
                }
            ]
        ];
    }
}
