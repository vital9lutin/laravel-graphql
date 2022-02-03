<?php

namespace App\GraphQL\Models\Users;

use App\GraphQL\Filters\Users\UserFilter;
use App\GraphQL\Models\Comments\Comment;
use App\GraphQL\Models\Features\FeatureSetting;
use App\GraphQL\Models\Groups\Group;
use App\GraphQL\Models\Likes\Like;
use App\GraphQL\Models\Posts\Post;
use App\GraphQL\Models\Subscriptions\Subscription;
use App\GraphQL\Traits\Filter\FilterableTrait;
use App\GraphQL\Traits\Models\FileTrait;
use Database\Factories\GraphQL\Models\Users\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User.
 *
 * @property int id
 * @property string name
 * @property string settings
 * @property bool status
 *
 * @method static static|Builder query()
 * @method self create(array $attributes = [])
 * @method Collection|static[] get()
 *
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use HasRoles;
    use FilterableTrait;
    use FileTrait;

    public const GUARD = 'graph';
    public const STATUS_ACTIVE = 1;
    public const ALLOWED_SORTING_FIELDS = ['id', 'name'];
    public const TABLE = 'users';
    protected $table = self::TABLE;
    protected $fillable = ['id', 'name', 'status'];

    public static function getMorphName(): string
    {
        return self::TABLE;
    }

    public function modelFilter(): string
    {
        return UserFilter::class;
    }
}
