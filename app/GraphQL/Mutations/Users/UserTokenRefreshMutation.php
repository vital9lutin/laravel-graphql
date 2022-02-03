<?php

namespace App\GraphQL\Mutations\Users;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Messages\Message;
use App\GraphQL\Mutations\BaseMutation;
use App\GraphQL\Services\Auth\UserPassportService;
use App\GraphQL\Types\Users\UserLoginType;

class UserTokenRefreshMutation extends BaseMutation
{
    public const NAME = 'userTokenRefreshMutation';

    public function __construct(
        protected UserPassportService $passportService
    ) {
    }

    public function type(): Type
    {
        return UserLoginType::type();
    }

    public function args(): array
    {
        return [
            'refresh_token' => Type::nonNull(Type::string()),
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $fields): array
    {
        return $this->passportService->refreshToken($args['refresh_token']);
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'refresh_token.required' => Message::required(),
            'refresh_token.string' => Message::string(),
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'refresh_token' => ['required', 'string'],
        ];
    }
}
