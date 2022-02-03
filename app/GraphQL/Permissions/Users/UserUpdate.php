<?php

namespace App\GraphQL\Permissions\Users;

use App\GraphQL\Messages\Message;
use App\GraphQL\Permissions\BasePermission;

class UserUpdate extends BasePermission
{
    public const KEY = 'user.update';

    public function getName(): string
    {
        return Message::get(Message::YOU_DO_NOT_HAVE_UPDATE);
    }

    public function getPosition(): int
    {
        return 3;
    }
}
