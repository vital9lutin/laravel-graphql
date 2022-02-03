<?php

namespace App\GraphQL\Traits;

use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\NullableType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

trait BaseAttributesTrait
{
    public static function notNullType(): NonNull|Type
    {
        return Type::nonNull(static::type());
    }

    public static function type(): Type|NullableType
    {
        return GraphQL::type(static::NAME);
    }

    public static function boolean(): Type
    {
        return Type::boolean();
    }

    public function attributes(): array
    {
        $description = static::DESCRIPTION;

        if (defined(static::class . '::PERMISSION') && !empty(static::PERMISSION)) {
            $description .= PHP_EOL . 'Permission required: ' . static::PERMISSION;
        }

        return [
            'name' => static::NAME,
            'description' => $description,
        ];
    }
}
