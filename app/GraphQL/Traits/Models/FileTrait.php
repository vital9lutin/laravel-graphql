<?php


namespace App\GraphQL\Traits\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\GraphQL\Models\Files\File;
use App\GraphQL\Services\Files\FileService;

trait FileTrait
{
    protected static function booted(): void
    {
        static::deleting(function ($model) {
            /** @var Collection $files */
            $files = $model->files;

            /** @var FileService $fileService */
            $fileService = app(FileService::class);

            if ($files->isNotEmpty()) {
                foreach ($files as $file) {
                    $fileService->deleteFile($file);
                }
            }
        });
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'model')->whereNull('parent_id');
    }
}
