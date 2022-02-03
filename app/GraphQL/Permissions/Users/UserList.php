<?php

namespace App\GraphQL\Permissions\Users;

use App\GraphQL\Messages\Message;
use App\GraphQL\Permissions\BasePermission;

class UserList extends BasePermission
{
    public const KEY = 'user.list';

    public function getName(): string
    {
        return Message::get(Message::YOU_DO_NOT_HAVE_LIST);
    }

    public function getPosition(): int
    {
        return 1;
    }
}
