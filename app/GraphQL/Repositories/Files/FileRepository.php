<?php

namespace App\GraphQL\Repositories\Files;

use Illuminate\Database\Eloquent\Builder;
use App\GraphQL\Dto\Files\FileDto;
use App\GraphQL\Models\Files\File;
use App\GraphQL\Repositories\BaseRepository;

class FileRepository extends BaseRepository
{
    public function create(FileDto $dto): File|Builder
    {
        return File::create([
            'model_id' => $dto->getModelId(),
            'model_type' => $dto->getModelType(),
            'name' => $dto->getName(),
            'origin_name' => $dto->getOriginName(),
            'size' => $dto->getSize(),
            'mime_type' => $dto->getMimeType(),
            'user_id' => $this->authId(),
            'type_id' => $dto->getTypeId(),
            'is_main' => $dto->getIsMain(),
            'parent_id' => $dto->getParentId(),
            'weight' => $dto->getWeight(),
            'height' => $dto->getHeight(),
        ]);
    }

    public function resetIsMain(FileDto $dto): void
    {
        File::query()
            ->where('model_id', $dto->getModelId())
            ->where('model_type', $dto->getModelType())
            ->where('user_id', $this->authId())
            ->where('type_id', $dto->getTypeId())
            ->update([
                'is_main' => false,
            ]);
    }

    public function delete(File $file): bool
    {
        return $file->delete();
    }
}
