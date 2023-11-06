<?php

declare(strict_types=1);

namespace Tests\Treenum;

use PHPUnit\Framework\Attributes\DataProvider;
use Treenum\TreeEnum;

trait TestCases {

    /**
     * @return class-string<TreeEnum>
     */
    protected abstract static function testWith(): string;

    public function test_root_cases(): void {
        $this->assertSame([
            static::testWith()::Dog,
            static::testWith()::Bird,
            static::testWith()::Cat,
        ], static::testWith()::rootCases());
    }

    public function test_leaf_cases(): void {
        $this->assertSame([
            static::testWith()::Labrador,
            static::testWith()::Golden,
            static::testWith()::Terrier,
            static::testWith()::Chicken,
            static::testWith()::Cat,
        ], static::testWith()::leafCases());
    }

    public static function getParentTestCases(): array {
        return [
            [static::testWith()::Retriever, static::testWith()::Dog],
            [static::testWith()::Labrador, static::testWith()::Retriever],
            [static::testWith()::Golden, static::testWith()::Retriever],
            [static::testWith()::Terrier, static::testWith()::Dog],
            [static::testWith()::Chicken, static::testWith()::Bird],
            [static::testWith()::Dog, null],
            [static::testWith()::Bird, null],
            [static::testWith()::Cat, null],
        ];
    }

    #[DataProvider('getParentTestCases')]
    public function test_get_parent(TreeEnum $item, TreeEnum|null $parent) {
        $this->assertSame($item->getParent(), $parent);
    }

    public static function getChildrenTestCases(): array {
        return [
            [static::testWith()::Dog, [static::testWith()::Retriever, static::testWith()::Terrier]],
            [static::testWith()::Retriever, [static::testWith()::Labrador, static::testWith()::Golden]],
            [static::testWith()::Labrador, []],
            [static::testWith()::Golden, []],
            [static::testWith()::Terrier, []],
            [static::testWith()::Bird, [static::testWith()::Chicken]],
            [static::testWith()::Chicken, []],
            [static::testWith()::Cat, []],
        ];
    }

    #[DataProvider('getChildrenTestCases')]
    public function test_get_children(TreeEnum $item, array $children): void {
        $this->assertSame($item->getChildren(), $children);
    }

    public static function getDepthTestCases(): array {
        return [
            [static::testWith()::Dog, 1],
            [static::testWith()::Retriever, 2],
            [static::testWith()::Labrador, 3],
            [static::testWith()::Golden, 3],
            [static::testWith()::Terrier, 2],
            [static::testWith()::Bird, 1],
            [static::testWith()::Chicken, 2],
            [static::testWith()::Cat, 1],
        ];
    }

    #[DataProvider('getDepthTestCases')]
    public function test_get_depth(TreeEnum $item, int $depth): void {
        $this->assertSame($depth, $item->getDepth());
    }

    public static function getAncestorsTestCases(): array {
        return [
            [static::testWith()::Dog, []],
            [static::testWith()::Retriever, [static::testWith()::Dog]],
            [static::testWith()::Labrador, [static::testWith()::Retriever, static::testWith()::Dog]],
            [static::testWith()::Golden, [static::testWith()::Retriever, static::testWith()::Dog]],
            [static::testWith()::Terrier, [static::testWith()::Dog]],
            [static::testWith()::Bird, []],
            [static::testWith()::Chicken, [static::testWith()::Bird]],
            [static::testWith()::Cat, []],
        ];
    }

    #[DataProvider('getAncestorsTestCases')]
    public function test_get_ancestors(TreeEnum $item, array $ancestors): void {
        $this->assertSame($ancestors, $item->getAncestors());
    }

    public static function getDescendantsTestCases(): array {
        return [
            [static::testWith()::Dog, [static::testWith()::Retriever, static::testWith()::Terrier, static::testWith()::Labrador, static::testWith()::Golden]],
            [static::testWith()::Retriever, [static::testWith()::Labrador, static::testWith()::Golden]],
            [static::testWith()::Labrador, []],
            [static::testWith()::Golden, []],
            [static::testWith()::Terrier, []],
            [static::testWith()::Bird, [static::testWith()::Chicken]],
            [static::testWith()::Chicken, []],
            [static::testWith()::Cat, []],
        ];
    }

    #[DataProvider('getDescendantsTestCases')]
    public function test_get_descendants(TreeEnum $item, array $ancestors): void {
        $this->assertSame($ancestors, $item->getDescendants());
    }
}
