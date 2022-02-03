<?php

namespace App\GraphQL\Queries\FileTypes;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Collection;
use App\GraphQL\Models\Files\FileType;
use App\GraphQL\Queries\BaseQuery;
use App\GraphQL\Types\Files\FileTypeType;
use Rebing\GraphQL\Support\SelectFields;

class FileTypesQuery extends BaseQuery
{
    public const NAME = 'fileTypesQuery';

    public function authorize($root, array $args, $ctx, ResolveInfo $info = null, Closure $fields = null): bool
    {
        return $this->withoutAuth();
    }

    public function type(): Type
    {
        return Type::listOf(FileTypeType::type());
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, SelectFields $fields): Collection
    {
        return FileType::query()
            ->select($fields->getSelect() ?? ['id'])
            ->with($fields->getRelations())
            ->get();
    }
}
