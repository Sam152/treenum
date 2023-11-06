<?php

declare(strict_types=1);

namespace Treenum;

use Treenum\Internal\BaseImplementation;
use Treenum\Internal\Utility;

trait GetChildrenImplementation {
    use BaseImplementation;

    public function getParent(): static | null {
        return Utility::find(static::cases(), fn (TreeEnum $item) => \in_array($this, $item->getChildren(), true));
    }
}
