<?php

namespace App\GraphQL\Mutations\Files;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Models\Files\File;
use App\GraphQL\Mutations\BaseMutation;
use App\GraphQL\Services\Files\FileService;
use App\GraphQL\Types\Types;

class DeleteFileMutation extends BaseMutation
{
    public const NAME = 'deleteFileMutation';

    public function __construct(private FileService $fileService)
    {
    }

    public function type(): Type
    {
        return self::boolean();
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

    public function args(): array
    {
        return [
            'id' => Types::notNullId()
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $fields): ?bool
    {
        return $this->fileService->deleteFile(
            File::where('id', $args['id'])->where('user_id', $this->authId())->firstOrFail()
        );
    }

}