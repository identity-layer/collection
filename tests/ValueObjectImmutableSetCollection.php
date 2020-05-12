<?php

declare(strict_types=1);

namespace AlvinChevolleaux\Tests\Collection;

use AlvinChevolleaux\Collection\Exception\InvalidTypeException;
use AlvinChevolleaux\Collection\ImmutableSet;

/**
 * Class ValueObjectImmutableSetCollection
 * @package AlvinChevolleaux\Tests\Collection
 * @method static ValueObjectImmutableSetCollection fromArray(ValueObject[] $item)
 */
class ValueObjectImmutableSetCollection extends ImmutableSet
{
    public static function T(): string
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