<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\NullableType;
use App\GraphQL\Traits\Types\BaseTypeTrait;
use Rebing\GraphQL\Support\EnumType;

class BaseEnumType extends EnumType implements NullableType
{
    use BaseTypeTrait;
}
