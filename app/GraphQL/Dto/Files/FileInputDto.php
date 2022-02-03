<?php

namespace App\GraphQL\Dto\Files;

use Illuminate\Http\UploadedFile;
use App\GraphQL\Dto\BaseDto;

class FileInputDto extends BaseDto
{
    protected UploadedFile $file;
    protected bool $isMain;
    protected int $typeId;
    protected ?array $sizes;

    public static function build(array $args): self
    {
        $static = new static();

        $static->setFile($args['file']);
        $static->setIsMain((bool)($args['is_main'] ?? false));
        $static->setTypeId($args['type_id'] ?? 0);
        $static->setSizes($args['sizes'] ?? null);

        return $static;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }

    public function getIsMain(): bool
    {
        return $this->isMain;
    }

    public function setIsMain(bool $isMain): void
    {
        $this->isMain = $isMain;
    }

    public function getTypeId(): int
    {
        return $this->typeId;
    }

    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }

    public function isSizes(): bool
    {
        return !empty($this->getSizes());
    }

    public function getSizes(): ?array
    {
        return $this->sizes;
    }

    public function setSizes(?array $sizes): void
    {
        $this->sizes = $sizes;
    }
}
