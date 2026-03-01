<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Config;
use VVOphp\Entity\Point\Poi;
use VVOphp\Entity\Point\Stop;
use VVOphp\Entity\Point\Street;
use VVOphp\Helper;
use VVOphp\PointFinder;
use VVOphp\Request;
use VVOphp\RequestInterface;
use VVOphp\Response\PointFinderResponse;

#[CoversClass(PointFinder::class)]
#[CoversClass(PointFinderResponse::class)]
#[CoversClass(Stop::class)]
#[CoversClass(Street::class)]
#[CoversClass(Poi::class)]
#[CoversClass(Helper::class)]
final class PointFinderTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $request = new Request(new Config());
        $finder = new PointFinder($request);

        self::assertSame(0, $finder->getLimit());
        self::assertFalse($finder->isStopsOnly());
    }

    public function testSetLimitReturnsSelf(): void
    {
        $request = new Request(new Config());
        $finder = new PointFinder($request);

        self::assertInstanceOf(PointFinder::class, $finder->setLimit(10));
        self::assertSame(10, $finder->getLimit());
    }

    public function testSetLimitIgnoresNull(): void
    {
        $request = new Request(new Config());
        $finder = new PointFinder($request);
        $finder->setLimit(null);

        self::assertSame(0, $finder->getLimit());
    }

    public function testSetStopsOnlyReturnsSelf(): void
    {
        $request = new Request(new Config());
        $finder = new PointFinder($request);

        self::assertInstanceOf(PointFinder::class, $finder->setStopsOnly(true));
        self::assertTrue($finder->isStopsOnly());
    }

    public function testSetQueryReturnsSelf(): void
    {
        $request = new Request(new Config());
        $finder = new PointFinder($request);

        self::assertInstanceOf(PointFinder::class, $finder->setQuery('Helmholtz'));
        self::assertSame('Helmholtz', $finder->getQuery());
    }

    public function testExecQueryWithStopResult(): void
    {
        // Stop format: id||city|name|gk4x|gk4y|...
        $apiResponse = json_encode([
            'PointStatus' => 'List',
            'Status' => ['Code' => 'Ok'],
            'ExpirationTime' => '/Date(1653045480000+0200)/',
            'Points' => [
                '33000028||Dresden|Helmholtzstraße|5657512|4621526|0',
            ],
        ]);

        $request = $this->createMock(RequestInterface::class);
        $request->method('setQueryBody')->willReturnSelf();
        $request->method('StartRequest')->willReturn(true);
        $request->method('getResponseJSON')->willReturn($apiResponse);

        $finder = new PointFinder($request);
        $result = $finder->execQuery('Helmholtz');

        self::assertInstanceOf(PointFinderResponse::class, $result);
        self::assertSame('List', $result->getPointStatus());
        self::assertSame('Ok', $result->getStatusCode());
        self::assertCount(1, $result->getPoints());
        self::assertInstanceOf(Stop::class, $result->getPoints()[0]);
        self::assertSame(33000028, $result->getPoints()[0]->getId());
        self::assertSame('Helmholtzstraße', $result->getPoints()[0]->getName());
    }

    public function testExecQueryWithStreetResult(): void
    {
        // Street format: detailData|a|...
        $apiResponse = json_encode([
            'PointStatus' => 'List',
            'Status' => ['Code' => 'Ok'],
            'Points' => [
                'foo:12345:bar:baz:qux:Prager Straße:Dresden:x:y:z:01069|a|extra',
            ],
        ]);

        $request = $this->createMock(RequestInterface::class);
        $request->method('setQueryBody')->willReturnSelf();
        $request->method('StartRequest')->willReturn(true);
        $request->method('getResponseJSON')->willReturn($apiResponse);

        $finder = new PointFinder($request);
        $result = $finder->execQuery('Prager');

        self::assertCount(1, $result->getPoints());
        self::assertInstanceOf(Street::class, $result->getPoints()[0]);
    }

    public function testExecQueryWithPoiResult(): void
    {
        // POI format: detailData|p|...
        $apiResponse = json_encode([
            'PointStatus' => 'List',
            'Status' => ['Code' => 'Ok'],
            'Points' => [
                'foo:99999:bar:baz:Zwinger:Dresden|p|extra',
            ],
        ]);

        $request = $this->createMock(RequestInterface::class);
        $request->method('setQueryBody')->willReturnSelf();
        $request->method('StartRequest')->willReturn(true);
        $request->method('getResponseJSON')->willReturn($apiResponse);

        $finder = new PointFinder($request);
        $result = $finder->execQuery('Zwinger');

        self::assertCount(1, $result->getPoints());
        self::assertInstanceOf(Poi::class, $result->getPoints()[0]);
    }

    public function testExecQueryReturnsNullOnFailedRequest(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $request->method('setQueryBody')->willReturnSelf();
        $request->method('StartRequest')->willReturn(false);

        $finder = new PointFinder($request);
        $result = $finder->execQuery('test');

        self::assertNull($result);
    }
}
