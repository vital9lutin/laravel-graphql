<?php

namespace App\GraphQL\Traits\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

trait BaseInputTrait
{
    public static function type(): Type
    {
        return GraphQL::type(static::NAME);
    }

    public function attributes(): array
    {
        $attributes = [
            'name' => static::NAME,
        ];

        if (defined(static::class . '::MODEL')) {
            $attributes['model'] = static::MODEL;
        }

        if (defined(static::class . '::DESCRIPTION')) {
            $attributes['description'] = static::DESCRIPTION;
        }

        return $attributes;
    }
}
