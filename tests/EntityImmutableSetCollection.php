<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Collection;

use IdentityLayer\Collection\Exception\InvalidTypeException;
use IdentityLayer\Collection\ImmutableSet;

class EntityImmutableSetCollection extends ImmutableSet
{
    public static function t(): string
    {
        return Entity::class;
    }

    public static function itemsEqual(object $item1, object $item2): bool
    {
        if (!$item1 instanceof Entity || !$item2 instanceof Entity) {
            throw new InvalidTypeException(
                sprintf('Both comparators must be of type %s', Entity::class)
            );
        }

        if ($item1->id() === $item2->id()) {
            return true;
        }

        return false;
    }
}
