<?php

declare(strict_types=1);

namespace Tests\Treenum\Fixtures;

use Treenum\GetChildrenImplementation;
use Treenum\TreeEnum;

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
