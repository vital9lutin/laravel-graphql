<?php

namespace App\GraphQL\Mutations\FileTypes;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use App\GraphQL\Messages\Message;
use App\GraphQL\Models\Files\FileType;
use App\GraphQL\Types\Types;

class FileTypeUpdateMutation extends BaseFileTypeMutation
{
    public const NAME = 'fileTypeUpdateMutation';

    public function args(): array
    {
        return array_merge(
            [
                'id' => Types::notNullId(),
            ],
            parent::args()
        );
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $fields): FileType
    {
        $fileType = FileType::findOrFail($args['id']);

        $fileType->name = $args['name'] ?? $fileType->name;
        $fileType->key = $args['key'] ?? $fileType->key;
        $fileType->save();

        return $fileType;
    }

    public function validationErrorMessages(array $args = []): array
    {
        return array_merge(
            [
                'name.required' => Message::required(),
                'name.numeric' => Message::numeric(),
                'name.exists' => Message::exists(),
            ],
            parent::validationErrorMessages($args)
        );
    }

    protected function rules(array $args = []): array
    {
        return array_merge(
            [
                'id' => ['required', 'numeric', 'exists:' . FileType::TABLE . ',id'],
            ],
            parent::rules($args)
        );
    }
}