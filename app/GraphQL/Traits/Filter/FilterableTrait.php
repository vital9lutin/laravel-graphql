<?php

namespace App\GraphQL\Traits\Filter;

use EloquentFilter\Filterable;
use Illuminate\Database\Query\Builder;

/**
 * @method static self|Builder filter(array $attributes, string $filterClass = null)
 */
trait FilterableTrait
{
    use Filterable;
}
