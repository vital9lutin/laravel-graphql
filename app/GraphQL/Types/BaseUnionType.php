<?php

namespace App\GraphQL\Types;

use App\GraphQL\Traits\Types\BaseTypeTrait;
use Rebing\GraphQL\Support\UnionType;

abstract class BaseUnionType extends UnionType
{
    use BaseTypeTrait;
}
