<?php

declare(strict_types=1);

namespace Treenum;

use Treenum\Internal\BaseImplementation;

trait GetParentImplementation {
    use BaseImplementation;

    public function getChildren(): array {
        return array_values(array_filter(static::cases(), fn (TreeEnum $item) => $item->getParent() === $this));
    }
}
