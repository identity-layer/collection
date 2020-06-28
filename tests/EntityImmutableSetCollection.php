<?php

declare(strict_types=1);

namespace AlvinChevolleaux\Tests\Collection;

use AlvinChevolleaux\Collection\Exception\InvalidTypeException;
use AlvinChevolleaux\Collection\ImmutableSet;

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
