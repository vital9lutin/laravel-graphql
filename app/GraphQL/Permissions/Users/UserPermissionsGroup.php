<?php

namespace App\GraphQL\Permissions\Users;

use App\GraphQL\Messages\Message;
use App\GraphQL\Permissions\BasePermissionGroup;

class UserPermissionsGroup extends BasePermissionGroup
{
    public const KEY = 'user';

    public function getName(): string
    {
        return Message::get(Message::YOU_HAVE_NO_RIGHTS);
    }

    public function getPosition(): int
    {
        return 30;
    }
}
