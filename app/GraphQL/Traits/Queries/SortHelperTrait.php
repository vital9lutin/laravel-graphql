<?php

namespace App\GraphQL\Traits\Queries;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Rules\SortParameterRule;
use App\GraphQL\Types\Types;

trait SortHelperTrait
{
    protected function sortArgs(): array
    {
        return [
            'sort' => [
                'type' => Types::listOfString(),
                'description' => 'Sort Argument. Available fields: ' . $this->allowedForSortFieldsToString(),
            ],
        ];
    }

    protected function allowedForSortFieldsToString(): string
    {
        return implode(', ', $this->allowedForSortFields());
    }

    protected function allowedForSortFields(): array
    {
        return [];
    }

    protected function sortRules(): array
    {
        return [
            'sort' => ['nullable', 'array', new SortParameterRule($this->allowedForSortFields())]
        ];
    }
}
