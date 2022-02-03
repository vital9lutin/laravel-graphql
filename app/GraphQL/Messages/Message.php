<?php

namespace App\GraphQL\Messages;

use ReflectionClass;

class Message
{
    public static function getKeyValueConstants(): array
    {
        return collect(static::getConstants())->map(static function (string $value, string $key) {
            return [
                'key' => $key,
                'value' => Message::get($value),
            ];
        })->toArray();
    }

    public static function getConstants(): array
    {
        return (new ReflectionClass(new static()))->getConstants();
    }

    public static function get(string $key): string
    {
        return $key;
    }

    public static function getLocale(): string
    {
        return app()->getLocale();
    }
}