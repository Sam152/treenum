<?php

declare(strict_types=1);

namespace Treenum;

interface TreeEnum extends \UnitEnum {
    /**
     * @return static[]
     */
    public function getAncestors(): array;

    /**
     * @return static[]
     */
    public function getDescendants(): array;

    /**
     * @return static[]
     */
    public function getChildren(): array;

    public function getParent(): static | null;

    public function getDepth(): int;

    /**
     * The root cases are those at a depth of 1, which may or may not have children.
     *
     * @return static[]
     */
    public static function rootCases(): array;

    /**
     * Leaf cases are the deepest items in each branch of the tree, those without any children.
     *
     * @return static[]
     */
    public static function leafCases(): array;
}
