<?php

declare(strict_types=1);

namespace AlvinChevolleaux\Collection;

use Countable;
use IteratorAggregate;

/**
 * @template-extends IteratorAggregate<T>
 */
interface Collection extends Countable, IteratorAggregate
{
    public static function T(): string;
    public function equals(Collection $collection): bool;
    public function map(callable $fn): Collection;
    public function reduce(callable $fn);
    public function filter(callable $fn): Collection;
}