<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Entity\Diva;

#[CoversClass(Diva::class)]
final class DivaTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $diva = new Diva();
        $diva->setNummer(11);
        $diva->setNetwork('voe');

        self::assertSame(11, $diva->getNummer());
        self::assertSame('voe', $diva->getNetwork());
    }

    public function testNullValues(): void
    {
        $diva = new Diva();
        $diva->setNummer(null);
        $diva->setNetwork(null);

        self::assertNull($diva->getNummer());
        self::assertNull($diva->getNetwork());
    }
}
