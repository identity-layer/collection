<?php

declare(strict_types=1);

namespace AlvinChevolleaux\Tests\Collection;

class Entity
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}