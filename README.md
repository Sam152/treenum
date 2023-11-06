Treenum: tree + enum in PHP
===

Treenum is a lightweight library for defining and traversing items in an enum, that have a tree structure.

```
composer require sam152/treenum
```

## Defining a tree

Trees may be defined either by identifying the parents or the children of any given item, whichever is easier for the consumer. 

Example of a tree identified by declaring children of any given item:

```php
enum Pet implements TreeEnum {
    use GetChildrenImplementation;

    case Dog;
    case Retriever;
    case Labrador;
    case Golden;
    case Terrier;
    case Bird;
    case Chicken;
    case Cat;

    public function getChildren(): array {
        return match ($this) {
            static::Dog => [
                static::Retriever,
                static::Terrier,
            ],
            static::Retriever => [
                static::Labrador,
                static::Golden,
            ],
            static::Bird => [
                static::Chicken,
            ],
            default => [],
        };
    }
}
```

And the same tree identified by declaring the parent of any given item:

```php
enum Pet implements TreeEnum {
    use GetParentImplementation;

    case Dog;
    case Retriever;
    case Labrador;
    case Golden;
    case Terrier;
    case Bird;
    case Chicken;
    case Cat;

    public function getParent(): static|null {
        return match($this) {
            static::Labrador, static::Golden => static::Retriever,
            static::Retriever, static::Terrier => static::Dog,
            static::Chicken => static::Bird,
            default => null,
        };
    }
}

```

## Public API

The following methods are defined on `TreeEnum` and can be used to traverse the tree:

```php
public function getAncestors(): array;
public function getDescendants(): array;
public function getChildren(): array;
public function getParent(): static | null;
public function getDepth(): int;
public static function rootCases(): array;
public static function leafCases(): array;
```

### Example usage:

```php
php > var_export(Pet::Dog->getChildren());
array (
  Pet::Retriever,
  Pet::Terrier,
)
```

```php
php > var_export(Pet::rootCases());
array (
  Pet::Dog,
  Pet::Bird,
  Pet::Cat,
)
```

### Additional helpers

```php
php > print \Treenum\Internal\Utility::dumpTree(Pet::class);
.
├── Dog
│   ├── Retriever
│   │   ├── Labrador
│   │   └── Golden
│   └── Terrier
├── Bird
│   └── Chicken
└── Cat
```
