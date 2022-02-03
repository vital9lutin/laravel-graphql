<?php

declare(strict_types=1);

return [
    'route' => [
        'uri' => '/graphql-playground',
        'name' => 'graphql-playground',
    ],
    'endpoint' => '/graphql/',
    'enabled' => env('GRAPHQL_PLAYGROUND_ENABLED', true),
];
