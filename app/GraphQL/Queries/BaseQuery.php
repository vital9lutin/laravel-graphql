<?php

namespace App\GraphQL\Queries;

use App\GraphQL\Messages\Message;
use App\GraphQL\Traits\Auth\AuthGuardsTrait;
use App\GraphQL\Traits\BaseAttributesTrait;
use App\GraphQL\Traits\Queries\{PaginateHelperTrait, SortHelperTrait};
use Closure;
use GraphQL\Type\Definition\{ResolveInfo, Type};
use Rebing\GraphQL\Support\{Query, SelectFields};

abstract class BaseQuery extends Query
{
    use BaseAttributesTrait;
    use AuthGuardsTrait;
    use PaginateHelperTrait;
    use SortHelperTrait;

    public const NAME = '';
    public const DESCRIPTION = '';
    public const PERMISSION = '';

    public function authorize(
        mixed $root,
        array $args,
        mixed $ctx,
        ResolveInfo $info = null,
        Closure $fields = null
    ): bool {
        return empty(static::PERMISSION) || $this->can(static::PERMISSION);
    }

    abstract public function type(): Type;

    public function resolve(
        mixed $root,
        array $args,
        mixed $context,
        ResolveInfo $info,
        SelectFields $fields
    ): mixed {
        return true;
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'per_page.integer' => Message::integer(),
            'page.integer' => Message::integer(),
            'sort.array' => Message::array(),
        ];
    }
}
