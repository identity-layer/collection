<?php

declare(strict_types=1);

namespace IdentityLayer\Collection;

use Countable;
use IteratorAggregate;
use Traversable;

interface Collection extends Countable, IteratorAggregate
{
    public static function t(): string;
    public function equals(Collection $collection): bool;
    public function map(callable $fn): Collection;
    /** @return mixed */
    public function reduce(callable $fn);
    public function filter(callable $fn): Collection;
    public function getIterator(): Traversable;
}
