<?php

declare(strict_types=1);

namespace Tests\Treenum;

use PHPUnit\Framework\TestCase;
use Tests\Treenum\Fixtures\PetWithParent;

class GetParentImplementationTest extends TestCase {
    use TestCases;

    protected static function with(): string {
        return PetWithParent::class;
    }
}
