<?php

declare(strict_types=1);

namespace Tests\Treenum;

use PHPUnit\Framework\TestCase;
use Tests\Treenum\Fixtures\Pet;

class GetChildrenImplementationTest extends TestCase {
    use TestCases;

    protected static function testWith(): string {
        return Pet::class;
    }
}
