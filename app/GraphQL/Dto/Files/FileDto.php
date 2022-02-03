<?php

namespace App\GraphQL\Dto\Files;

use App\GraphQL\Dto\BaseDto;

class FileDto extends BaseDto
{
    protected int $modelId;
    protected string $modelType;
    protected string $name;
    protected ?string $originName;
    protected ?float $size;
    protected ?string $mimeType;
    protected int $typeId;
    protected bool $isMain;
    protected ?int $parentId;
    protected int $weight;
    protected int $height;

    public static function build(array $args): self
    {
        $static = new static();

        $static->setModelId($args['model_id']);
        $static->setModelType($args['model_type']);
        $static->setName($args['name']);
        $static->setOriginName($args['origin_name']);
        $static->setSize($args['size']);
        $static->setMimeType($args['mime_type']);
        $static->setTypeId($args['type_id'] ?? 0);
        $static->setIsMain((float)($args['is_main'] ?? false));
        $static->setParentId($args['parent_id'] ?? null);
        $static->setHeight((int)($args['height'] ?? 0));
        $static->setWeight((int)($args['weight'] ?? 0));

        return $static;
    }

    public function getModelId(): int
    {
        return $this->modelId;
    }

    public function setModelId(int $modelId): void
    {
        $this->modelId = $modelId;
    }

    public function getModelType(): string
    {
        return $this->modelType;
    }

    public function setModelType(string $modelType): void
    {
        $this->modelType = $modelType;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getOriginName(): ?string
    {
        return $this->originName;
    }

    public function setOriginName(?string $originName): void
    {
        $this->originName = $originName;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(?float $size): void
    {
        $this->size = $size;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function getTypeId(): int
    {
        return $this->typeId;
    }

    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }

    public function getIsMain(): bool
    {
        return $this->isMain;
    }

    public function setIsMain(bool $isMain): void
    {
        $this->isMain = $isMain;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): void
    {
        $this->parentId = $parentId;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }
}
