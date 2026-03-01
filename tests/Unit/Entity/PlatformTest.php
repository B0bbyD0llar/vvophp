<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Entity\Platform;

#[CoversClass(Platform::class)]
final class PlatformTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $platform = new Platform();

        self::assertNull($platform->getName());
        self::assertNull($platform->getType());
    }

    public function testGettersAndSetters(): void
    {
        $platform = new Platform();
        $platform->setName('1');
        $platform->setType('Platform');

        self::assertSame('1', $platform->getName());
        self::assertSame('Platform', $platform->getType());
    }
}
