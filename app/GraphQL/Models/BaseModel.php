<?php

namespace App\GraphQL\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\LazyCollection;
use Kirschbaum\PowerJoins\PowerJoins;
use App\GraphQL\Models\Users\User;
use App\GraphQL\Traits\Filter\FilterableTrait;

/**
 * @method static |Builder select(...$attrs)
 * @method static static|Builder query()
 * @method static static|Builder inRandomOrder()
 * @method static static|Builder create(array $attributes = [])
 *
 * @method null|static|Model first(array $attrs = [])
 * @method static Model|static findOrFail($id = null)
 * @method static null|static find($id = null)
 * @method static Model|static firstOrFail($columns = ['*'])
 * @method static Collection|static[] get(array $columns = [])
 * @method static LazyCollection|static[] cursor()
 *
 * @method static orderBy(string $column, string $direction = 'asc')
 *
 * @method static Builder|static where($column, $operator = null, $value = null)
 *
 * @mixin Eloquent
 */
abstract class BaseModel extends Model
{
    use HasFactory;
    use FilterableTrait;
    use PowerJoins;

    abstract public static function getMorphName(): string;

    public function getLang(): string
    {
        return app()->getLocale();
    }

    public function authId(): ?int
    {
        return Auth::guard(User::GUARD)->id();
    }
}
