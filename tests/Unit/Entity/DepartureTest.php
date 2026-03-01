<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Entity\Departure;
use VVOphp\Entity\Diva;
use VVOphp\Entity\Mot\CityBus;
use VVOphp\Entity\Mot\Tram;
use VVOphp\Entity\Mot\Unknow;
use VVOphp\Entity\Platform;
use VVOphp\Helper;

#[CoversClass(Departure::class)]
#[CoversClass(Helper::class)]
final class DepartureTest extends TestCase
{
    public function testGetFromJSONWithFullData(): void
    {
        $json = (object) [
            'Id' => 'dmc:123',
            'LineName' => '3',
            'Direction' => 'Coschütz',
            'Mot' => 'Tram',
            'Platform' => (object) [
                'Name' => '1',
                'Type' => 'Platform',
            ],
            'Diva' => (object) [
                'Number' => '11',
                'Network' => 'voe',
            ],
            'State' => 'InTime',
            'RouteChanges' => ['change1'],
            'RealTime' => '/Date(1653045480000+0200)/',
            'ScheduledTime' => '/Date(1653045300000+0200)/',
        ];

        $departure = new Departure();
        $departure->getFromJSON($json);

        self::assertSame(123, $departure->getId());
        self::assertSame('3', $departure->getLineName());
        self::assertSame('Coschütz', $departure->getDirection());
        self::assertInstanceOf(Tram::class, $departure->getMot());
        self::assertSame('1', $departure->getPlatform()->getName());
        self::assertSame('Platform', $departure->getPlatform()->getType());
        self::assertSame(11, $departure->getDiva()->getNummer());
        self::assertSame('voe', $departure->getDiva()->getNetwork());
        self::assertSame('InTime', $departure->getState());
        self::assertSame(['change1'], $departure->getRouteChanges());
        self::assertInstanceOf(\DateTimeInterface::class, $departure->getRealTime());
        self::assertInstanceOf(\DateTimeInterface::class, $departure->getScheduledTime());
    }

    public function testGetFromJSONWithMinimalData(): void
    {
        $json = (object) [
            'Id' => 'dmc:456',
            'LineName' => '62',
            'Direction' => 'Löbtau',
            'Mot' => 'CityBus',
            'Platform' => null,
            'Diva' => null,
            'ScheduledTime' => '/Date(1653045300000+0200)/',
        ];

        $departure = new Departure();
        $departure->getFromJSON($json);

        self::assertSame(456, $departure->getId());
        self::assertSame('62', $departure->getLineName());
        self::assertInstanceOf(CityBus::class, $departure->getMot());
        self::assertNull($departure->getPlatform());
        self::assertNull($departure->getDiva());
        self::assertNull($departure->getState());
        self::assertNull($departure->getRealTime());
        self::assertNull($departure->getRouteChanges());
    }

    public function testGetFromJSONWithUnknownMot(): void
    {
        $json = (object) [
            'Id' => 'dmc:789',
            'LineName' => 'X1',
            'Direction' => 'Somewhere',
            'Mot' => 'Helicopter',
            'Platform' => null,
            'Diva' => null,
            'ScheduledTime' => '/Date(1653045300000+0200)/',
        ];

        $departure = new Departure();
        $departure->getFromJSON($json);

        self::assertInstanceOf(Unknow::class, $departure->getMot());
        self::assertSame('Unknow: Helicopter', $departure->getMot()->getName());
    }

    public function testGetDelayOutputsNothingWhenNotDelayed(): void
    {
        $departure = new Departure();
        $departure->setState('InTime');

        $this->expectOutputString('');
        $departure->getDelay();
    }

    public function testGetDelayOutputsMinutesWhenDelayed(): void
    {
        $departure = new Departure();
        $departure->setState('Delayed');
        $departure->setScheduledTime(new \DateTime('2022-05-20 14:00:00'));
        $departure->setRealTime(new \DateTime('2022-05-20 14:03:00'));

        $this->expectOutputString('+3 m');
        $departure->getDelay();
    }

    public function testSettersReturnCorrectTypes(): void
    {
        $departure = new Departure();

        self::assertInstanceOf(Departure::class, $departure->setMot(new Tram()));
        self::assertInstanceOf(Departure::class, $departure->setRealTime(new \DateTime()));
        self::assertInstanceOf(Departure::class, $departure->setScheduledTime(new \DateTime()));
    }
}
