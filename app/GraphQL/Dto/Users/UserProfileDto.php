<?php

namespace App\GraphQL\Dto\Users;

use App\GraphQL\Dto\BaseDto;

class UserProfileDto extends BaseDto
{
    protected ?string $name;

    public static function build(array $args): self
    {
        $static = new static();

        $static->setName($args['name'] ?? null);
        $static->setFiles($args['files'] ?? null);

        return $static;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
