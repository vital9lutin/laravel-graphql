<?php

namespace App\GraphQL\Mutations\Users;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutations\BaseMutation;
use App\GraphQL\Services\Auth\UserPassportService;

class UserLogoutMutation extends BaseMutation
{
    public const NAME = 'userLogoutMutation';

    public function __construct(
        protected UserPassportService $passportService
    ) {
    }

    public function authorize(
        $root,
        array $args,
        $ctx,
        ResolveInfo $info = null,
        Closure $fields = null
    ): bool {
        return !$this->authCheck();
    }

    public function type(): Type
    {
        return Type::boolean();
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): bool
    {
        return $this->passportService->logout(
            $this->getAuthGuard()->user()
        );
    }
}
