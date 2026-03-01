<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit\Entity\Point;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Entity\Point\AbstractPoint;
use VVOphp\Entity\Point\PointInterface;
use VVOphp\Entity\Point\Stop;

#[CoversClass(Stop::class)]
#[CoversClass(AbstractPoint::class)]
final class StopTest extends TestCase
{
    public function testImplementsInterface(): void
    {
        $stop = new Stop();

        self::assertInstanceOf(PointInterface::class, $stop);
    }

    public function testGettersAndSetters(): void
    {
        $stop = new Stop();
        $stop->setId(33000028);
        $stop->setName('Helmholtzstraße');
        $stop->setCity('Dresden');
        $stop->setGK4X(5657512);
        $stop->setGK4Y(4621526);
        $stop->setRawData(['raw']);

        self::assertSame(33000028, $stop->getId());
        self::assertSame('Helmholtzstraße', $stop->getName());
        self::assertSame('Dresden', $stop->getCity());
        self::assertSame(5657512, $stop->getGK4X());
        self::assertSame(4621526, $stop->getGK4Y());
        self::assertSame(['raw'], $stop->getRawData());
    }

    public function testCityCanBeNull(): void
    {
        $stop = new Stop();
        $stop->setCity(null);

        self::assertNull($stop->getCity());
    }
}
