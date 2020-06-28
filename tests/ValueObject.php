<?php

declare(strict_types=1);

namespace AlvinChevolleaux\Tests\Collection;

class ValueObject
{
    /** @var mixed */
    private $value;

    /**
     * ValueObject constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function equals(ValueObject $item): bool
    {
        return $item->value === $this->value;
    }

    /** @return mixed */
    public function getValue()
    {
        return $this->value;
    }
}
