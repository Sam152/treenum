<?php

declare(strict_types=1);

namespace Treenum\Internal;

use Treenum\TreeEnum;

final class Utility {
    /**
     * @template T
     *
     * @param array<T> $array
     *
     * @return T|null
     */
    public static function find(array $array, callable $search): mixed {
        foreach ($array as $key => $value) {
            if ($search($value, $key)) {
                return $value;
            }
        }
        return null;
    }

    /**
     * Allow arrow functions to recurse in a single expression, by passing the fn as the first argument.
     */
    public static function recurse(callable $arrowFn, ...$args) {
        return $arrowFn($arrowFn, ...$args);
    }

    /**
     * @param class-string<\Treenum\TreeEnum> $enum
     */
    public static function dumpTree(string $enum): string {
        return self::recurse(function (callable $printTree, array $nodes, $prefix = '') {
            return (empty($prefix) ? ".\n" : '') . array_reduce($nodes, function (string $tree, TreeEnum $node) use ($nodes, $prefix, $printTree) {
                $isLast = ($node === end($nodes));
                $tree .= sprintf(
                    "%s%s %s\n",
                    $prefix,
                    $isLast ? '└──' : '├──',
                    $node->name,
                );
                $tree .= $printTree($printTree, $node->getChildren(), $isLast ? $prefix . '    ' : $prefix . '│   ');
                return $tree;
            }, '');
        }, $enum::rootCases());
    }
}
