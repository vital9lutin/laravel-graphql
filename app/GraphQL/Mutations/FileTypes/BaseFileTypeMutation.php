<?php

namespace App\GraphQL\Mutations\FileTypes;

use App\GraphQL\Messages\Message;
use App\GraphQL\Models\Files\FileType;
use App\GraphQL\Mutations\BaseMutation;
use App\GraphQL\Types\Files\FileTypeType;
use App\GraphQL\Types\Types;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

abstract class BaseFileTypeMutation extends BaseMutation
{

    public function args(): array
    {
        return [
            'name' => Types::notNullString(),
            'key' => Types::notNullString(),
        ];
    }

    public function type(): Type
    {
        return FileTypeType::type();
    }

    public function authorize(
        $root,
        array $args,
        $ctx,
        ResolveInfo $info = null,
        Closure $fields = null
    ): bool {
        return $this->authCheck();
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'name.required' => Message::required(),
            'name.string' => Message::string(),
            'name.min' => Message::min(2),
            'name.unique' => Message::unique(),
            'key.required' => Message::required(),
            'key.string' => Message::string(),
            'key.min' => Message::min(2),
            'key.unique' => Message::unique(),
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'unique:' . FileType::TABLE],
            'key' => ['required', 'string', 'min:2', 'unique:' . FileType::TABLE],
        ];
    }
}