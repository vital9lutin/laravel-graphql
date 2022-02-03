<?php

namespace App\GraphQL\Permissions;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\Permission\Contracts\Permission;

interface PermissionGroup extends Arrayable
{

    public function getKey(): string;

    public function getName(): string;

    /**
     * @return Permission[]
     */
    public function getPermissions(): array;

    public function getPosition(): int;
}
