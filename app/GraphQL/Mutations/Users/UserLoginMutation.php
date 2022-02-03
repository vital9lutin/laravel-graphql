<?php

namespace App\GraphQL\Mutations\Users;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Messages\AuthMessage;
use App\GraphQL\Messages\Message;
use App\GraphQL\Mutations\BaseMutation;
use App\GraphQL\Rules\Users\LoginUserRule;
use App\GraphQL\Services\Auth\UserPassportService;
use App\GraphQL\Types\Types;
use App\GraphQL\Types\Users\UserLoginType;

class UserLoginMutation extends BaseMutation
{
    public const NAME = 'userLoginMutation';

    public function __construct(protected UserPassportService $passportService) {
    }

    public function type(): Type
    {
        return UserLoginType::type();
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

    public function getAuthorizationMessage(): string
    {
        return Message::get(AuthMessage::USER_IS_ALREADY_REGISTERED);
    }

    public function args(): array
    {
        return [
            'login' => Types::notNullString(),
            'password' => Types::notNullString(),
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $fields): array
    {
        return [];
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'login.required' => Message::required(),
            'password.required' => Message::required(),
            'password.string' => Message::string(),
            'password.min' => Message::min(3),
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'login' => ['required'],
            'password' => ['required', 'string', 'min:3', new LoginUserRule($args)],
        ];
    }
}
