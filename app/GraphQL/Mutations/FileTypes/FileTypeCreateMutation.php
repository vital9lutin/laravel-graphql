<?php

namespace App\GraphQL\Mutations\FileTypes;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use App\GraphQL\Models\Files\FileType;

class FileTypeCreateMutation extends BaseFileTypeMutation
{
    public const NAME = 'fileTypeCreateMutation';

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $fields): FileType
    {
        return FileType::create([
            'name' => $args['name'],
            'key' => $args['key'],
        ]);
    }
}