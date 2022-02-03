<?php


namespace App\GraphQL\Fields;


use GraphQL\Type\Definition\Type as GraphQLType;
use App\GraphQL\Types\Types;
use Rebing\GraphQL\Support\Field;

abstract class BasePermissionField extends Field
{
    public const UPDATE = 'update';
    public const DELETE = 'delete';

    protected $attributes = [
        'selectable' => false,
        'description' => 'A list of possible permissions for the current model.',
    ];

    public function type(): GraphQLType
    {
        return Types::listOfString();
    }

    abstract protected function resolve($root, array $args): array;
}
