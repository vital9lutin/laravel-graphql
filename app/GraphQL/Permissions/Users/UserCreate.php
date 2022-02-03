<?php

namespace App\GraphQL\Permissions\Users;


use App\GraphQL\Messages\Message;
use App\GraphQL\Permissions\BasePermission;

class UserCreate extends BasePermission
{
    public const KEY = 'user.create';

    public function getName(): string
    {
        return Message::get(Message::YOU_DO_NOT_HAVE_CREATE);
    }

    public function getPosition(): int
    {
        return 2;
    }
}
