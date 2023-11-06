<?php

declare(strict_types=1);

namespace Treenum\Internal;

use Treenum\TreeEnum;

/**
 * @internal
 */
trait BaseImplementation {
    public function getDepth(): int {
        return Utility::recurse(
            fn (callable $fn, TreeEnum $item, $depth = 1) => $item->getParent() ? $fn($fn, $item->getParent(), $depth + 1) : $depth,
            $this
        );
    }

    public static function rootCases(): array {
        return array_values(array_filter(static::cases(), fn (TreeEnum $item) => null === $item->getParent()));
    }

    public static function leafCases(): array {
        return array_values(array_filter(static::cases(), fn (TreeEnum $item) => empty($item->getChildren())));
    }

    public function getAncestors(): array {
        return Utility::recurse(
            fn (callable $fn, TreeEnum $item, $parents = []) => $item->getParent() ? $fn($fn, $item->getParent(), array_merge($parents, [$item->getParent()])) : $parents,
            $this
        );
    }

    public function getDescendants(): array {
        return array_merge($this->getChildren(), ...array_map(fn (TreeEnum $item) => $item->getDescendants(), $this->getChildren()));
    }
}
