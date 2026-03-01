<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Config;
use VVOphp\Entity\Departure;
use VVOphp\Helper;
use VVOphp\Monitor;
use VVOphp\Request;
use VVOphp\RequestInterface;
use VVOphp\Response\DepartureMonitorResponse;

#[CoversClass(Monitor::class)]
#[CoversClass(DepartureMonitorResponse::class)]
#[CoversClass(Departure::class)]
#[CoversClass(Helper::class)]
final class MonitorTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $request = new Request(new Config());
        $monitor = new Monitor($request);

        self::assertSame(5, $monitor->getLimit());
        self::assertTrue($monitor->isShorttermchanges());
        self::assertFalse($monitor->getIsarrival());
    }

    public function testSetLimitReturnsSelf(): void
    {
        $request = new Request(new Config());
        $monitor = new Monitor($request);

        self::assertInstanceOf(Monitor::class, $monitor->setLimit(10));
        self::assertSame(10, $monitor->getLimit());
    }

    public function testSetLimitIgnoresNull(): void
    {
        $request = new Request(new Config());
        $monitor = new Monitor($request);
        $monitor->setLimit(null);

        self::assertSame(5, $monitor->getLimit());
    }

    public function testSetShorttermchangesReturnsSelf(): void
    {
        $request = new Request(new Config());
        $monitor = new Monitor($request);

        self::assertInstanceOf(Monitor::class, $monitor->setShorttermchanges(false));
        self::assertFalse($monitor->isShorttermchanges());
    }

    public function testSetIsarrival(): void
    {
        $request = new Request(new Config());
        $monitor = new Monitor($request);
        $monitor->setIsarrival(true);

        self::assertTrue($monitor->getIsarrival());
    }

    public function testExecQueryWithMockedRequest(): void
    {
        $apiResponse = json_encode([
            'Status' => ['Code' => 'Ok'],
            'Name' => 'Helmholtzstraße',
            'Place' => 'Dresden',
            'ExpirationTime' => '/Date(1653045480000+0200)/',
            'Departures' => [
                [
                    'Id' => 'dmc:123',
                    'LineName' => '3',
                    'Direction' => 'Coschütz',
                    'Mot' => 'Tram',
                    'Platform' => ['Name' => '1', 'Type' => 'Platform'],
                    'Diva' => ['Number' => '11', 'Network' => 'voe'],
                    'ScheduledTime' => '/Date(1653045300000+0200)/',
                ],
            ],
        ]);

        $request = $this->createMock(RequestInterface::class);
        $request->method('setQueryBody')->willReturnSelf();
        $request->method('StartRequest')->willReturn(true);
        $request->method('getResponseJSON')->willReturn($apiResponse);

        $monitor = new Monitor($request);
        $result = $monitor->execQuery(33000028);

        self::assertInstanceOf(DepartureMonitorResponse::class, $result);
        self::assertSame('Ok', $result->getStatusCode());
        self::assertSame('Helmholtzstraße', $result->getName());
        self::assertSame('Dresden', $result->getPlace());
        self::assertCount(1, $result->getDepartures());
    }

    public function testExecQueryReturnsNullOnFailedRequest(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $request->method('setQueryBody')->willReturnSelf();
        $request->method('StartRequest')->willReturn(false);

        $monitor = new Monitor($request);
        $result = $monitor->execQuery(33000028);

        self::assertNull($result);
    }

    public function testExecQueryWithEmptyDepartures(): void
    {
        $apiResponse = json_encode([
            'Status' => ['Code' => 'Ok'],
            'Name' => 'Helmholtzstraße',
            'Place' => 'Dresden',
        ]);

        $request = $this->createMock(RequestInterface::class);
        $request->method('setQueryBody')->willReturnSelf();
        $request->method('StartRequest')->willReturn(true);
        $request->method('getResponseJSON')->willReturn($apiResponse);

        $monitor = new Monitor($request);
        $result = $monitor->execQuery(33000028);

        self::assertInstanceOf(DepartureMonitorResponse::class, $result);
        self::assertSame([], $result->getDepartures());
    }
}
