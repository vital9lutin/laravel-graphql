<?php

namespace App\GraphQL\Queries\Translations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Messages\Message;
use App\GraphQL\Queries\BaseQuery;
use App\GraphQL\Types\Translations\TranslationType;
use App\GraphQL\Types\Types;
use Rebing\GraphQL\Support\SelectFields;

class BasicTranslationQuery extends BaseQuery
{
    public const NAME = 'basicTranslationQuery';

    public function authorize($root, array $args, $ctx, ResolveInfo $info = null, Closure $fields = null): bool
    {
        return $this->withoutAuth();
    }

    public function type(): Type
    {
        return Types::listOf(TranslationType::type());
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, SelectFields $fields): array
    {
        return Message::getKeyValueConstants();
    }
}
