<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Collection;

class Entity
{
    /** @var string */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
