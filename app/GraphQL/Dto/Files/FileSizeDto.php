<?php

namespace App\GraphQL\Dto\Files;

use App\GraphQL\Dto\BaseDto;

class FileSizeDto extends BaseDto
{
    protected ?int $weight;
    protected ?int $height;

    public static function build(array $args): self
    {
        $static = new static();

        $static->setWeight(empty($args['weight']) ? null : $args['weight']);
        $static->setHeight(empty($args['height']) ? null : $args['height']);

        return $static;
    }

    public function isResizeImage(): bool
    {
        return !($this->getHeight() === null && $this->getWeight() === null);
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): void
    {
        $this->height = $height;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): void
    {
        $this->weight = $weight;
    }
}
