<?php

namespace App\GraphQL\Filters\Users;

use App\GraphQL\Filters\BaseFilter;
use App\GraphQL\Models\Users\User;
use App\GraphQL\Traits\Filter\SortFilterTrait;

class UserFilter extends BaseFilter
{
    use SortFilterTrait;

    protected function allowedOrders(): array
    {
        return User::ALLOWED_SORTING_FIELDS;
    }
}
