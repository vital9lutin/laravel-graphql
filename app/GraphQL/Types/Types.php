<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class Types
{
    public static function notNullInt(): Type
    {
        return Type::nonNull(Type::int());
    }

    public static function notNullFloat(): Type
    {
        return Type::nonNull(Type::float());
    }

    public static function notNullId(): Type
    {
        return Type::nonNull(Type::id());
    }

    public static function notNullBoolean(): Type
    {
        return Type::nonNull(Type::boolean());
    }

    public static function notNullString(): Type
    {
        return Type::nonNull(Type::string());
    }

    public static function notNullListOf(Type $type): Type
    {
        return Type::nonNull(Type::listOf($type));
    }

    public static function notNullListOfInt(): Type
    {
        return Type::nonNull(self::listOfInt());
    }

    public static function listOfInt(): ListOfType
    {
        return Type::listOf(
            Type::int()
        );
    }

    public static function listOfId(): Type
    {
        return Type::listOf(
            Type::id()
        );
    }

    public static function notNullListOfString(): Type
    {
        return Type::nonNull(static::listOfString());
    }

    public static function listOfString(): ListOfType
    {
        return Type::listOf(
            Type::string()
        );
    }

    public static function nullableInt(): Type
    {
        return Type::int();
    }

    public static function nullableBoolean(): Type
    {
        return Type::boolean();
    }

    public static function nullableFloat(): Type
    {
        return Type::float();
    }

    public static function nullableString(): Type
    {
        return Type::string();
    }

    public static function nullableId(): Type
    {
        return Type::id();
    }

    public static function files(): Type
    {
        return self::listOf(self::file());
    }

    public static function listOf(Type $type): ListOfType
    {
        return Type::listOf($type);
    }

    public static function file(): Type
    {
        return GraphQL::type('Upload');
    }
}
