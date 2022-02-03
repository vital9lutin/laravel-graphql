<?php

namespace App\GraphQL\Models\Files;

use App\GraphQL\Models\BaseModel;
use App\GraphQL\Services\Files\FileService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property int $id
 * @property int $model_id
 * @property string $model_type
 * @property string $origin_name
 * @property bool $is_main
 * @property Collection $sizes
 */
class File extends BaseModel
{
    public const TABLE = 'files';

    protected $table = self::TABLE;

    protected $fillable = [
        'model_id',
        'model_type',
        'name',
        'origin_name',
        'size',
        'mime_type',
        'user_id',
        'type_id',
        'is_main',
        'parent_id',
        'weight',
        'height',
    ];

    protected $appends = ['src'];

    public static function getMorphName(): string
    {
        return self::TABLE;
    }

    public function getSrcAttribute(): ?string
    {
        return FileService::getUrl($this->name);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(FileType::class, 'type_id');
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }
}
