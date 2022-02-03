<?php

namespace App\GraphQL\Permissions\Users;

use App\GraphQL\Messages\ErrorMessage;
use App\GraphQL\Messages\Message;
use App\GraphQL\Permissions\BasePermission;

class UserDelete extends BasePermission
{
    public const KEY = 'user.delete';

    public function getName(): string
    {
        return Message::get(ErrorMessage::YOU_DO_NOT_HAVE_DELETE);
    }

    public function getPosition(): int
    {
        return 4;
    }
}
