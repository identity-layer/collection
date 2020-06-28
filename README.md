# alvnchevolleaux/collection

## Intro
PHP lacks generics and therefore a user-land library such as this can be a useful reusable base implementation 
to provide concepts such as an immutable set. In paradigms such as Functional Programming or Domain Driven Design, 
immutability is an essential component to encapsulate the state of your objects.

## Quickstart
`composer require alvinchevolleaux/collection`
```
<?php

declare(strict_types=1);

use AlvinChevolleaux\Collection\Exception\InvalidTypeException;
use AlvinChevolleaux\Collection\ImmutableSet;

/**
 * Class UserCollection
 * @method static UserCollection fromArray(User[] $user)
 */
class UserCollection extends ImmutableSet
{
    public static function T(): string
    {
        return User::class;
    }

    public static function itemsEqual(object $item1, object $item2): bool
    {
        if (!$item1 instanceof User || !$item2 instanceof User) {
            throw new InvalidTypeException(
                sprintf('Both comparators must be of type %s', User::class)
            );
        }

        return $item1->equals($item2);
    }
}
```
## Examples

#### Initialise Collection
```
$users = UserCollection::fromArray([
    new User('Joe Bloggs'),
    new User('Jane Doe'),
    new User('John Smith'),
]);
```
#### Iterate collection
```
/** @var User $user */
foreach ($users as $user) {
    echo $user->firstname();
}
```
This example shows how we can iterate using a foreach loop over each item in the collection.

#### Comparing sets
```
$set1 = NumberCollection::fromArray([
    new Number(3),
    new Number(1),
    new Number(2),
]);

$set2 = NumberCollection::fromArray([
    new Number(1),
    new Number(2),
    new Number(3),
    new Number(3),
]);

$set1->equals($set2); // true
```
Note that the order items are added makes no difference. Duplicate items will simply be removed from the 
collection automatically and these will not effect any comparison either.

#### Map
Map through the collection to produce a new collection of the same type:
```
$numbers = NumberCollection::fromArray([
    new Number(1),
    new Number(2),
    new Number(3),
]);

$squaredNumbers = $numbers->map(function (Number $number) {
    return new Number($number->pow(2));
});

$numbers; // 1, 4, 9
```
In this example we square a collection of numbers and return the resulting collection. A new collection will be
returned. It works in much the same way the array_map function does except it does not return an array.

#### Reduce
```
$numbers = NumberCollection::fromArray([
    new Number(3),
    new Number(1),
    new Number(2),
]);

$numbersAdded = $numbers->reduce(function ($carry, Number $number) {
    $carry += $number->value();
    return $carry;
}));

$numbersAdded; // 6
```

#### Filter
```
$fruits = FruitCollection::fromArray([
    new Fruit('apple'),
    new Fruit('orange'),
    new Fruit('pear'),
    new Fruit('banana'),
    new Fruit('kiwi'),
    new Fruit('mango'),
    new Fruit('plum'),
]);

$filteredFruit = $fruits->filter(function (ValueObject $fruit) {
    return strlen($fruit->getValue()) <= 4;
});

$filteredFruit; // pear, kiwi, plum
```
In this example we return a new collection filtered using the callback provided. It works much the same as the 
array_filter function built into PHP but returns a new collection of the same type instead of an array.