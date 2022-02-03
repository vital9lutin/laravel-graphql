<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use App\GraphQL\Models\Users\User;

/**
 * Class GraphQLProvider
 * @package App\Providers
 */
class GraphQLProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerMorphMap();
    }

    protected function registerMorphMap(): void
    {
        Relation::morphMap(
            [
                User::getMorphName() => User::class,
            ]
        );
    }
}
