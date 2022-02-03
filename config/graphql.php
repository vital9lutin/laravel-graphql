<?php

declare(strict_types=1);

use App\GraphQL\Inputs\Files\FileInput;
use App\GraphQL\Inputs\Files\FileSizeInput;
use App\GraphQL\Middlewares\LocalizationMiddleware;
use App\GraphQL\Mutations\Files\DeleteFileMutation;
use App\GraphQL\Mutations\FileTypes\FileTypeCreateMutation;
use App\GraphQL\Mutations\FileTypes\FileTypeUpdateMutation;
use App\GraphQL\Mutations\Users\UserLoginMutation;
use App\GraphQL\Mutations\Users\UserLogoutMutation;
use App\GraphQL\Mutations\Users\UserTokenRefreshMutation;
use App\GraphQL\Queries\FileTypes\FileTypesQuery;
use App\GraphQL\Queries\Translations\BasicTranslationQuery;
use App\GraphQL\Queries\Users\UsersQuery;
use App\GraphQL\Types\Files\FileType;
use App\GraphQL\Types\Files\FileTypeType;
use App\GraphQL\Types\Translations\TranslationType;
use App\GraphQL\Types\Users\UserLoginType;
use App\GraphQL\Types\Users\UserType;
use Fruitcake\Cors\HandleCors;
use Rebing\GraphQL\GraphQLController;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\PaginationType;
use Rebing\GraphQL\Support\SimplePaginationType;
use Rebing\GraphQL\Support\UploadType;

return [
    'prefix' => 'graphql/',
    'routes' => '{graphql_schema?}',
    'controllers' => GraphQLController::class . '@query',
    'middleware' => [
        HandleCors::class,
        LocalizationMiddleware::class,
    ],
    'route_group_attributes' => [],
    'default_schema' => 'default',
    'batching' => [
        'enable' => true,
    ],
    'schemas' => [
        'default' => [
            'query' => [
                BasicTranslationQuery::class,
                FileTypesQuery::class,

                UsersQuery::class,
            ],
            'mutation' => array(
                FileTypeCreateMutation::class,
                FileTypeUpdateMutation::class,

                DeleteFileMutation::class,

                UserLoginMutation::class,
                UserLogoutMutation::class,

                UserTokenRefreshMutation::class,
            ),
            'middleware' => [],
            'method' => ['post'],
        ],
    ],
    'types' => [
        TranslationType::class,
        UploadType::class,

        FileType::class,
        FileTypeType::class,
        FileInput::class,
        FileSizeInput::class,

        UserLoginType::class,
        UserType::class,
    ],
    'lazyload_types' => false,
    'error_formatter' => [GraphQL::class, 'formatError'],
    'errors_handler' => [GraphQL::class, 'handleErrors'],
    'params_key' => 'variables',
    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],
    'pagination_type' => PaginationType::class,
    'simple_pagination_type' => SimplePaginationType::class,
    'graphiql' => [
        'prefix' => '/graphiql',
        'controller' => GraphQLController::class . '@graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql',
        'display' => env('ENABLE_GRAPHIQL', true),
    ],
    'defaultFieldResolver' => null,
    'headers' => [],
    'json_encoding_options' => 0,
    'apq' => [
        'enable' => env('GRAPHQL_APQ_ENABLE', false),
        'cache_driver' => env('GRAPHQL_APQ_CACHE_DRIVER', config('cache.default')),
        'cache_prefix' => config('cache.prefix') . ':graphql.apq',
        'cache_ttl' => 300,
    ],
];
