<?php

declare(strict_types=1);

namespace AlvinChevolleaux\Tests\Collection;

use AlvinChevolleaux\Collection\Exception\InvalidTypeException;
use PHPUnit\Framework\TestCase;

class ImmutableSetTest extends TestCase
{
    public function testValidTypesInstantiation()
    {
        $entityCollection = EntityImmutableSetCollection::fromArray([
            new Entity('apple'),
            new Entity('orange'),
            new Entity('pear'),
            new Entity('blackberry'),
        ]);

        $this->assertCount(4, $entityCollection);
    }

    public function testExceptionThrownOnDisallowedType()
    {
        $this->expectException(InvalidTypeException::class);

        ValueObjectImmutableSetCollection::fromArray([
            new ValueObject('test1'),
            new ValueObject('test2'),
            new ValueObject('test3'),
            new Entity('test4'),
        ]);
    }

    public function testSetHasNoDuplicatesUsingCustomEqualityChecks()
    {
        $valueObjectCollection = ValueObjectImmutableSetCollection::fromArray([
            new ValueObject('test1'),
            new ValueObject('test2'),
            new ValueObject('test3'),
            new ValueObject('test2'),
        ]);

        $this->assertCount(3, $valueObjectCollection);

        $entityCollection = EntityImmutableSetCollection::fromArray([
            new Entity('1'),
            new Entity('2'),
            new Entity('3'),
            new Entity('2'),
            new Entity('3'),
            new Entity('4'),
        ]);

        $this->assertCount(4, $entityCollection);
    }

    public function testSetEquality()
    {
        $valueObjectCollection1 = ValueObjectImmutableSetCollection::fromArray([
            new ValueObject(3),
            new ValueObject(1),
            new ValueObject(2),
        ]);

        $valueObjectCollection2 = ValueObjectImmutableSetCollection::fromArray([
            new ValueObject(1),
            new ValueObject(2),
            new ValueObject(3),
        ]);

        $valueObjectCollection3 = ValueObjectImmutableSetCollection::fromArray([
            new ValueObject(1),
            new ValueObject(2),
            new ValueObject('c'),
        ]);

        $this->assertTrue($valueObjectCollection1->equals($valueObjectCollection2));
        $this->assertFalse($valueObjectCollection1->equals($valueObjectCollection3));
    }

    public function testWithAdditionalItemAndImmutability()
    {
        $valueObjectCollection = ValueObjectImmutableSetCollection::fromArray([
            new ValueObject('3'),
            new ValueObject('1'),
            new ValueObject('2'),
        ]);

        $newValueObject = $valueObjectCollection->with(new ValueObject('4'));

        $this->assertCount(4, $newValueObject);
        $this->assertCount(3, $valueObjectCollection);
        $this->assertNotEquals($valueObjectCollection, $newValueObject);
    }

    public function testWithoutAdditionalItemAndImmutability()
    {
        $valueObjectCollection = ValueObjectImmutableSetCollection::fromArray([
            new ValueObject('3'),
            new ValueObject('1'),
            new ValueObject('2'),
        ]);

        $newValueObject = $valueObjectCollection->without(new ValueObject('3'));

        $this->assertCount(2, $newValueObject);
        $this->assertCount(3, $valueObjectCollection);
        $this->assertNotEquals($valueObjectCollection, $newValueObject);
    }

    public function testIteration()
    {
        $entityCollection = EntityImmutableSetCollection::fromArray([
            new Entity('1'),
            new Entity('2'),
            new Entity('3')
        ]);

        $count = 0;
        /** @var Uuser $entity */
        foreach ($entityCollection as $entity) {
            $this->assertInstanceOf(Entity::class, $entity);
            $count++;
        }

        $this->assertCount($count, $entityCollection);
    }

    public function testMap()
    {
        $valueObjectCollection1 = ValueObjectImmutableSetCollection::fromArray([
            new ValueObject(1),
            new ValueObject(2),
            new ValueObject(3),
            new ValueObject(4),
            new ValueObject(5),
        ]);

        $valueObjectCollection2 = ValueObjectImmutableSetCollection::fromArray([
            new ValueObject(1),
            new ValueObject(4),
            new ValueObject(9),
            new ValueObject(16),
            new ValueObject(25),
        ]);

        $squaredCollection = $valueObjectCollection1->map(function (ValueObject $valueObject) {
            return new ValueObject($valueObject->getValue() * $valueObject->getValue());
        });

        $this->assertEquals($valueObjectCollection2, $squaredCollection);
    }

    public function testReduce()
    {
        $valueObjectCollection1 = ValueObjectImmutableSetCollection::fromArray([
            new ValueObject(1),
            new ValueObject(5),
            new ValueObject(4),
        ]);

        $this->assertEquals(10, $valueObjectCollection1->reduce(function ($carry, ValueObject $item) {
            $carry += $item->getValue();
            return $carry;
        }));
    }

    public function testFilter()
    {
        $fruits = ValueObjectImmutableSetCollection::fromArray([
            new ValueObject('apple'),
            new ValueObject('orange'),
            new ValueObject('pear'),
            new ValueObject('banana'),
            new ValueObject('kiwi'),
            new ValueObject('mango'),
            new ValueObject('plum'),
        ]);

        $filteredFruit = $fruits->filter(function (ValueObject $fruit) {
            return strlen($fruit->getValue()) <= 4;
        });

        $this->assertCount(3, $filteredFruit);
    }
}