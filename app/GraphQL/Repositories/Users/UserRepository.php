<?php

namespace App\GraphQL\Repositories\Users;


use App\GraphQL\Models\Users\User;
use App\GraphQL\Repositories\BaseRepository;
use App\GraphQL\Services\Files\FileService;
use App\GraphQL\Dto\Users\UserProfileDto;

class UserRepository extends BaseRepository
{
    public function __construct(protected FileService $fileService)
    {
    }

    public function update(UserProfileDto $dto): User
    {
        $user = User::query()->findOrFail($this->authId());

        $user->update(
            array_filter([
                'name' => $dto->getName(),
            ])
        );

        if (!is_null($files = $dto->getFiles())) {
            $this->fileService->uploadFiles($files, $user->id, USer::getMorphName());
        }

        return $user;
    }
}