<?php

declare(strict_types=1);

namespace AlvinChevolleaux\Collection;

interface Collection extends \Countable
{
    public static function fromArray(array $data): Collection;
    public static function T(): string;
    public function equals(Collection $collection): bool;
    public function map(callable $fn): Collection;
    public function reduce(callable $fn);
    public function filter(callable $fn): Collection;
}