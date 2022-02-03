<?php

namespace App\GraphQL\Queries\Users;

use App\GraphQL\Messages\Message;
use App\GraphQL\Models\Users\User;
use App\GraphQL\Queries\BaseQuery;
use App\GraphQL\Types\Users\UserType;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Rebing\GraphQL\Support\SelectFields;

class UsersQuery extends BaseQuery
{
    public const NAME = 'usersQuery';

    public function authorize($root, array $args, $ctx, ResolveInfo $info = null, Closure $fields = null): bool
    {
        return $this->withoutAuth();
    }

    public function args(): array
    {
        return array_merge(
            $this->paginationArgs(),
            $this->sortArgs(),
        );
    }

    public function type(): Type
    {
        return $this->paginateType(
            UserType::type()
        );
    }

    public function resolve($root, array $args, $context, ResolveInfo $info, SelectFields $fields): LengthAwarePaginator
    {
        return $this->paginate(
            User::query()
                ->select($fields->getSelect() ?? ['id'])
                ->filter($args)
                ->with($fields->getRelations()),
            $args
        );
    }

    public function validationErrorMessages(array $args = []): array
    {
        return array_merge(
            [
                'group.required' => Message::required(),
                'group.numeric' => Message::numeric(),
                'group.exists' => Message::exists(),
            ],
            parent::validationErrorMessages($args)
        );
    }


    protected function allowedForSortFields(): array
    {
        return User::ALLOWED_SORTING_FIELDS;
    }

    protected function rules(array $args = []): array
    {
        return array_merge(
            $this->paginationRules(),
            $this->sortRules(),
        );
    }
}
