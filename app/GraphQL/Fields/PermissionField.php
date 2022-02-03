<?php

namespace App\GraphQL\Fields;

use App\GraphQL\Models\ListPermission;
use App\GraphQL\Traits\Auth\AuthGuardsTrait;

class PermissionField extends BasePermissionField
{
    use AuthGuardsTrait;

    protected function resolve($root, array $args): array
    {
        /** @var ListPermission $root */
        $result = [];

        if ($root->canBeUpdated() && $this->can($root->getUpdatePermissionKey())) {
            $result[] = static::UPDATE;
        }

        if ($root->canBeDeleted() && $this->can($root->getDeletePermissionKey())) {
            $result[] = static::DELETE;
        }

        return $result;
    }
}
