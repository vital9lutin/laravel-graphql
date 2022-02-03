<?php

namespace App\GraphQL\Models\Files;

use App\GraphQL\Models\BaseModel;

/**
 * @property string $name
 * @property string $key
 */
class FileType extends BaseModel
{
    public const TABLE = 'file_types';

    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'key',
    ];

    public static function getMorphName(): string
    {
        return self::TABLE;
    }
}
