<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit\Entity\Point;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Entity\Point\AbstractPoint;
use VVOphp\Entity\Point\Poi;

#[CoversClass(Poi::class)]
#[CoversClass(AbstractPoint::class)]
final class PoiTest extends TestCase
{
    public function testProcessDetailDataParsesCorrectly(): void
    {
        $poi = new Poi();
        // Format: index0:id:2:3:name:city
        $poi->processDetailData('foo:99999:bar:baz:Zwinger:Dresden');

        self::assertSame(99999, $poi->getId());
        self::assertSame('Zwinger', $poi->getName());
        self::assertSame('Dresden', $poi->getCity());
    }

    public function testProcessDetailDataWithoutCity(): void
    {
        $poi = new Poi();
        $poi->processDetailData('foo:99999:bar:baz:Zwinger:');

        self::assertNull($poi->getCity());
    }
}
