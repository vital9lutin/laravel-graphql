<?php

namespace App\GraphQL\Repositories;

use App\GraphQL\Traits\Auth\AuthGuardsTrait;

class BaseRepository
{
    use AuthGuardsTrait;
}
