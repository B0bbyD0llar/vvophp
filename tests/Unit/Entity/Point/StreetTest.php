<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit\Entity\Point;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Entity\Point\AbstractPoint;
use VVOphp\Entity\Point\Street;

#[CoversClass(Street::class)]
#[CoversClass(AbstractPoint::class)]
final class StreetTest extends TestCase
{
    public function testProcessDetailDataParsesCorrectly(): void
    {
        $street = new Street();
        // Format: index0:id:2:3:4:name:city:7:8:9:plz
        $street->processDetailData('foo:12345:bar:baz:qux:Prager Straße:Dresden:x:y:z:01069');

        self::assertSame(12345, $street->getId());
        self::assertSame('Prager Straße', $street->getName());
        self::assertSame('Dresden', $street->getCity());
        self::assertSame('01069', $street->getPlz());
    }

    public function testProcessDetailDataWithoutPlz(): void
    {
        $street = new Street();
        $street->processDetailData('foo:12345:bar:baz:qux:Prager Straße:Dresden:x:y:z:');

        self::assertNull($street->getPlz());
    }

    public function testProcessDetailDataWithoutCity(): void
    {
        $street = new Street();
        $street->processDetailData('foo:12345:bar:baz:qux:Prager Straße::x:y:z:01069');

        self::assertNull($street->getCity());
    }

    public function testSetPlzReturnsSelf(): void
    {
        $street = new Street();

        self::assertInstanceOf(Street::class, $street->setPlz('01069'));
    }
}
