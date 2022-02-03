<?php

namespace App\GraphQL\Filters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\GraphQL\Traits\Filter\SortFilterTrait;

class BaseFilter extends ModelFilter
{
    use SortFilterTrait;

    protected function builderLike(string $column, string $string): void
    {
        $this->where(function (Builder $builder) use ($column, $string) {
            foreach (explode(' ', trim($string)) as $val) {
                $builder->whereRaw('UPPER(' . $column . ') LIKE "%' . Str::lower($val) . '%"');
            }
        });
    }
}
