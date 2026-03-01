<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit\Entity\Mot;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VVOphp\Entity\Mot\AbstractMot;
use VVOphp\Entity\Mot\Cableway;
use VVOphp\Entity\Mot\CityBus;
use VVOphp\Entity\Mot\Ferry;
use VVOphp\Entity\Mot\HailedSharedTaxi;
use VVOphp\Entity\Mot\IntercityBus;
use VVOphp\Entity\Mot\MotInterface;
use VVOphp\Entity\Mot\PlusBus;
use VVOphp\Entity\Mot\SuburbanRailway;
use VVOphp\Entity\Mot\Train;
use VVOphp\Entity\Mot\Tram;
use VVOphp\Entity\Mot\Unknow;

#[CoversClass(AbstractMot::class)]
#[CoversClass(Cableway::class)]
#[CoversClass(CityBus::class)]
#[CoversClass(Ferry::class)]
#[CoversClass(HailedSharedTaxi::class)]
#[CoversClass(IntercityBus::class)]
#[CoversClass(PlusBus::class)]
#[CoversClass(SuburbanRailway::class)]
#[CoversClass(Train::class)]
#[CoversClass(Tram::class)]
#[CoversClass(Unknow::class)]
final class MotTest extends TestCase
{
    /**
     * @return iterable<string, array{0: MotInterface, 1: string}>
     */
    public static function motProvider(): iterable
    {
        yield 'CityBus' => [new CityBus(), 'CityBus'];
        yield 'Tram' => [new Tram(), 'Tram'];
        yield 'IntercityBus' => [new IntercityBus(), 'IntercityBus'];
        yield 'SuburbanRailway' => [new SuburbanRailway(), 'SuburbanRailway'];
        yield 'Train' => [new Train(), 'Train'];
        yield 'PlusBus' => [new PlusBus(), 'PlusBus'];
        yield 'Cableway' => [new Cableway(), 'Cableway'];
        yield 'Ferry' => [new Ferry(), 'Ferry'];
        yield 'HailedSharedTaxi' => [new HailedSharedTaxi(), 'HailedSharedTaxi'];
    }

    #[DataProvider('motProvider')]
    public function testMotHasCorrectName(MotInterface $mot, string $expectedName): void
    {
        self::assertSame($expectedName, $mot->getName());
    }

    #[DataProvider('motProvider')]
    public function testMotImplementsInterface(MotInterface $mot): void
    {
        self::assertInstanceOf(MotInterface::class, $mot);
        self::assertInstanceOf(AbstractMot::class, $mot);
    }

    public function testUnknowMotContainsRawName(): void
    {
        $mot = new Unknow('Spaceship');

        self::assertSame('Unknow: Spaceship', $mot->getName());
    }
}
