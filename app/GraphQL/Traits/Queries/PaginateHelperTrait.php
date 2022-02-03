<?php

namespace App\GraphQL\Traits\Queries;

use GraphQL\Type\Definition\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Rebing\GraphQL\Support\Facades\GraphQL;

trait PaginateHelperTrait
{
    protected int $defaultPaginationPerPage = 15;

    protected function paginationArgs(): array
    {
        return [
            'per_page' => Type::int(),
            'page' => Type::int(),
        ];
    }

    protected function paginationRules(): array
    {
        return [
            'per_page' => ['nullable', 'integer'],
            'page' => ['nullable', 'integer'],
        ];
    }

    protected function paginate(Builder $builder, array $args): LengthAwarePaginator
    {
        return $builder->paginate(...$this->getPaginationParameters($args));
    }

    protected function getPaginationParameters(array $args): array
    {
        return [
            $this->getPerPage($args),
            ['*'],
            'page',
            $this->getPage($args)
        ];
    }

    protected function getPerPage(array $args, int $default = null): int
    {
        if (is_null($default)) {
            $default = $this->defaultPaginationPerPage;
        }

        return $args['per_page'] ?? $default;
    }

    protected function getPage(array $args): int
    {
        return $args['page'] ?? 1;
    }

    protected function paginateType(Type $type): Type
    {
        return GraphQL::paginate($type);
    }
}
