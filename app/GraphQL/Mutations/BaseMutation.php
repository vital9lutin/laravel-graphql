<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Inputs\Files\FileInput;
use App\GraphQL\Messages\Message;
use App\GraphQL\Models\Files\FileType;
use App\GraphQL\Traits\Auth\AuthGuardsTrait;
use App\GraphQL\Traits\BaseAttributesTrait;
use Closure;
use GraphQL\Type\Definition\{ResolveInfo, Type};
use Rebing\GraphQL\Support\Mutation;

abstract class BaseMutation extends Mutation
{
    use BaseAttributesTrait;
    use AuthGuardsTrait;

    public const NAME = '';
    public const DESCRIPTION = '';
    public const PERMISSION = '';

    public function authorize(
        mixed $root,
        array $args,
        mixed $ctx,
        ResolveInfo $info = null,
        Closure $fields = null
    ): bool {
        return empty(static::PERMISSION) || $this->can(static::PERMISSION);
    }

    abstract public function type(): Type;

    public function resolve(
        mixed $root,
        array $args,
        mixed $context,
        ResolveInfo $info,
        Closure $fields
    ): mixed {
        return true;
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'files.required' => Message::required(),
            'files.array' => Message::array(),
            'files.min' => Message::min(1),
            'files.*.file' => Message::required(),
            'files.*.max' => Message::max(20480),
            'files.*.is_main' => Message::boolean(),
            'files.*.type_id' => Message::exists(),
        ];
    }

    protected function fileArgs(): array
    {
        return [
            'files' => [
                'name' => 'files',
                'type' => Type::listOf(FileInput::type())
            ],
        ];
    }

    protected function fileRules(): array
    {
        return [
            'files' => ['sometimes', 'required', 'array', 'min:1'],
            'files.*.file' => ['required', 'max:20480'],
            'files.*.is_main' => ['sometimes', 'boolean'],
            'files.*.type_id' => ['exists:' . FileType::TABLE . ',id'],
        ];
    }
}
