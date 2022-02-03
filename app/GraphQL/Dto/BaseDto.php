<?php

namespace App\GraphQL\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class BaseDto extends DataTransferObject
{
    protected ?array $files;

    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function setFiles(?array $files): void
    {
        $this->files = $files;
    }
}
