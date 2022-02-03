<?php

namespace App\GraphQL\Rules\Users;

use App\GraphQL\Messages\AuthMessage;
use App\GraphQL\Messages\Message;
use Illuminate\Contracts\Validation\Rule;

class LoginUserRule implements Rule
{
    private string $message;

    public function __construct(private array $args)
    {
    }

    public function message(): string
    {
        return $this->message ?: Message::get(AuthMessage::FAILED);
    }

    public function passes($attribute, $value): bool
    {
        return true;
    }

}
