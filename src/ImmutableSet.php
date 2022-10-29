<?php

declare(strict_types=1);

namespace IdentityLayer\Collection;

use IdentityLayer\Collection\Exception\InvalidArgumentException;
use IdentityLayer\Collection\Exception\InvalidTypeException;
use ArrayIterator;

/**
 * Class ImmutableSet
 * @package IdentityLayer\Collection
 *
 * The immutable set does not enforce any restrictions on the items it contains. It will make a shallow clone of
 * all items but these may contain references to other objects. You should use immutable objects only within this
 * collection to ensure full immutability.
 */
abstract class ImmutableSet implements Collection
{
    /** @var array */
    private $items;

    final private function __construct(array $items)
    {
        $this->items = [];

        foreach ($items as $x) {
            $this->typeOrException($x);
            foreach ($this->items as $y) {
                if (static::itemsEqual($x, $y)) {
                    continue 2;
                }
            }

            $this->items[] = clone $x;
        }
    }

    abstract public static function t(): string;
    abstract public static function itemsEqual(object $item1, object $item2): bool;

    final public static function fromArray(array $data): ImmutableSet
    {
        return new static($data);
    }

    final public function toArray(): array
    {
        return $this->items;
    }

    final public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function equals(Collection $collection): bool
    {
        if (!is_a($collection, static::class)) {
            return false;
        }

        /** @var ImmutableSet $collection */

        if (count($this->items) !== count($collection->items)) {
            return false;
        }

        foreach ($this->items as $item) {
            if (!$collection->contains($item)) {
                return false;
            }
        }

        return true;
    }

    final public function with(object $item): ImmutableSet
    {
        return new static(array_merge($this->items, [$item]));
    }

    final public function without(object $item): ImmutableSet
    {
        $this->typeOrException($item);

        if (!$this->contains($item)) {
            throw new InvalidArgumentException('Collection does not contain element');
        }

        $itemsCopy = $this->items;

        foreach ($itemsCopy as $index => $existingItem) {
            if (static::itemsEqual($item, $existingItem)) {
                unset($itemsCopy[$index]);
            }
        }

        return new static($itemsCopy);
    }

    final public function contains(object $item): bool
    {
        foreach ($this->items as $existingItem) {
            if (static::itemsEqual($item, $existingItem)) {
                return true;
            }
        }

        return false;
    }

    final public function count(): int
    {
        return count($this->items);
    }

    final public function map(callable $fn): Collection
    {
        return static::fromArray(array_map($fn, $this->items));
    }

    /**
     * @param mixed $initial
     * @return mixed
     */
    final public function reduce(callable $fn, $initial = null)
    {
        return array_reduce($this->items, $fn, $initial);
    }

    final public function filter(callable $fn): Collection
    {
        return static::fromArray(array_filter($this->items, $fn));
    }

    private function typeOrException(object $item): void
    {
        if (!is_a($item, static::T())) {
            throw new InvalidTypeException(
                sprintf(
                    'object of type %s cannot be added to collection of type %s',
                    get_class($item),
                    static::T()
                )
            );
        }
    }
}
