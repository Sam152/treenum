<?php

declare(strict_types=1);

namespace Tests\Treenum;

use PHPUnit\Framework\Attributes\DataProvider;
use Treenum\TreeEnum;

trait TestCases {

    /**
     * @return class-string<TreeEnum>
     */
    protected abstract static function with(): string;

    public function test_root_cases(): void {
        $this->assertSame([
            static::with()::Dog,
            static::with()::Bird,
            static::with()::Cat,
        ], static::with()::rootCases());
    }

    public function test_leaf_cases(): void {
        $this->assertSame([
            static::with()::Labrador,
            static::with()::Golden,
            static::with()::Terrier,
            static::with()::Chicken,
            static::with()::Cat,
        ], static::with()::leafCases());
    }

    public static function getParentTestCases(): array {
        return [
            [static::with()::Retriever, static::with()::Dog],
            [static::with()::Labrador, static::with()::Retriever],
            [static::with()::Golden, static::with()::Retriever],
            [static::with()::Terrier, static::with()::Dog],
            [static::with()::Chicken, static::with()::Bird],
            [static::with()::Dog, null],
            [static::with()::Bird, null],
            [static::with()::Cat, null],
        ];
    }

    #[DataProvider('getParentTestCases')]
    public function test_get_parent(TreeEnum $item, TreeEnum|null $parent) {
        $this->assertSame($item->getParent(), $parent);
    }

    public static function getChildrenTestCases(): array {
        return [
            [static::with()::Dog, [static::with()::Retriever, static::with()::Terrier]],
            [static::with()::Retriever, [static::with()::Labrador, static::with()::Golden]],
            [static::with()::Labrador, []],
            [static::with()::Golden, []],
            [static::with()::Terrier, []],
            [static::with()::Bird, [static::with()::Chicken]],
            [static::with()::Chicken, []],
            [static::with()::Cat, []],
        ];
    }

    #[DataProvider('getChildrenTestCases')]
    public function test_get_children(TreeEnum $item, array $children): void {
        $this->assertSame($item->getChildren(), $children);
    }

    public static function getDepthTestCases(): array {
        return [
            [static::with()::Dog, 1],
            [static::with()::Retriever, 2],
            [static::with()::Labrador, 3],
            [static::with()::Golden, 3],
            [static::with()::Terrier, 2],
            [static::with()::Bird, 1],
            [static::with()::Chicken, 2],
            [static::with()::Cat, 1],
        ];
    }

    #[DataProvider('getDepthTestCases')]
    public function test_get_depth(TreeEnum $item, int $depth): void {
        $this->assertSame($depth, $item->getDepth());
    }

    public static function getAncestorsTestCases(): array {
        return [
            [static::with()::Dog, []],
            [static::with()::Retriever, [static::with()::Dog]],
            [static::with()::Labrador, [static::with()::Retriever, static::with()::Dog]],
            [static::with()::Golden, [static::with()::Retriever, static::with()::Dog]],
            [static::with()::Terrier, [static::with()::Dog]],
            [static::with()::Bird, []],
            [static::with()::Chicken, [static::with()::Bird]],
            [static::with()::Cat, []],
        ];
    }

    #[DataProvider('getAncestorsTestCases')]
    public function test_get_ancestors(TreeEnum $item, array $ancestors): void {
        $this->assertSame($ancestors, $item->getAncestors());
    }

    public static function getDescendantsTestCases(): array {
        return [
            [static::with()::Dog, [static::with()::Retriever, static::with()::Terrier, static::with()::Labrador, static::with()::Golden]],
            [static::with()::Retriever, [static::with()::Labrador, static::with()::Golden]],
            [static::with()::Labrador, []],
            [static::with()::Golden, []],
            [static::with()::Terrier, []],
            [static::with()::Bird, [static::with()::Chicken]],
            [static::with()::Chicken, []],
            [static::with()::Cat, []],
        ];
    }

    #[DataProvider('getDescendantsTestCases')]
    public function test_get_descendants(TreeEnum $item, array $ancestors): void {
        $this->assertSame($ancestors, $item->getDescendants());
    }
}
