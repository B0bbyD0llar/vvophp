<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Entity\Departure;
use VVOphp\Response\AbstractResponse;
use VVOphp\Response\DepartureMonitorResponse;
use VVOphp\Response\ResponseInterface;

#[CoversClass(DepartureMonitorResponse::class)]
#[CoversClass(AbstractResponse::class)]
final class DepartureMonitorResponseTest extends TestCase
{
    public function testImplementsInterface(): void
    {
        $response = new DepartureMonitorResponse();

        self::assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testGettersAndSetters(): void
    {
        $response = new DepartureMonitorResponse();
        $response->setName('Helmholtzstraße');
        $response->setPlace('Dresden');
        $response->setStatusCode('Ok');
        $time = new \DateTime();
        $response->setTime($time);
        $expiration = new \DateTime('+1 hour');
        $response->setExpirationTime($expiration);

        self::assertSame('Helmholtzstraße', $response->getName());
        self::assertSame('Dresden', $response->getPlace());
        self::assertSame('Ok', $response->getStatusCode());
        self::assertSame($time, $response->getTime());
        self::assertSame($expiration, $response->getExpirationTime());
    }

    public function testDeparturesManagement(): void
    {
        $response = new DepartureMonitorResponse();

        self::assertNull($response->getDepartures());

        $departure = new Departure();
        $response->addDeparture($departure);

        self::assertCount(1, $response->getDepartures());
        self::assertSame($departure, $response->getDepartures()[0]);
    }

    public function testSetDepartures(): void
    {
        $response = new DepartureMonitorResponse();
        $response->setDepartures([]);

        self::assertSame([], $response->getDepartures());

        $response->setDepartures(null);

        self::assertNull($response->getDepartures());
    }
}
