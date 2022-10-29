<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Collection;

use IdentityLayer\Collection\Exception\InvalidTypeException;
use IdentityLayer\Collection\ImmutableSet;

/**
 * Class ValueObjectImmutableSetCollection
 * @package IdentityLayer\Tests\Collection
 * @method static ValueObjectImmutableSetCollection fromArray(ValueObject[] $item)
 */
class ValueObjectImmutableSetCollection extends ImmutableSet
{
    public static function t(): string
    {
        return ValueObject::class;
    }

    public static function itemsEqual(object $item1, object $item2): bool
    {
        if (!$item1 instanceof ValueObject || !$item2 instanceof ValueObject) {
            throw new InvalidTypeException(
                sprintf('Both comparators must be of type %s', ValueObject::class)
            );
        }

        return $item1->equals($item2);
    }
}
