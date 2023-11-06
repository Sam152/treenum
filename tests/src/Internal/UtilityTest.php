<?php

declare(strict_types=1);

namespace Tests\Treenum\Internal;

use PHPUnit\Framework\TestCase;
use Tests\Treenum\Fixtures\Pet;
use Treenum\Internal\Utility;

class UtilityTest extends TestCase {
    public function test_print_tree() {
        $this->assertSame(
            <<<TREE
.
├── Dog
│   ├── Retriever
│   │   ├── Labrador
│   │   └── Golden
│   └── Terrier
├── Bird
│   └── Chicken
└── Cat

TREE
            ,
            Utility::dumpTree(Pet::class)
        );
    }
}
