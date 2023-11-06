<?php

declare(strict_types=1);

namespace Tests\Treenum\Fixtures;

use Treenum\GetParentImplementation;
use Treenum\TreeEnum;

enum PetWithParent implements TreeEnum {
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
