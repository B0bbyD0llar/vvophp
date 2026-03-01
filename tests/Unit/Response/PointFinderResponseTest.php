<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Entity\Point\Stop;
use VVOphp\Response\AbstractResponse;
use VVOphp\Response\PointFinderResponse;
use VVOphp\Response\ResponseInterface;

#[CoversClass(PointFinderResponse::class)]
#[CoversClass(AbstractResponse::class)]
final class PointFinderResponseTest extends TestCase
{
    public function testImplementsInterface(): void
    {
        $response = new PointFinderResponse();

        self::assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testGettersAndSetters(): void
    {
        $response = new PointFinderResponse();
        $response->setPointStatus('List');
        $response->setStatusCode('Ok');

        self::assertSame('List', $response->getPointStatus());
        self::assertSame('Ok', $response->getStatusCode());
    }

    public function testPointsIsNullByDefault(): void
    {
        $response = new PointFinderResponse();

        self::assertNull($response->getPoints());
    }

    public function testAddPoint(): void
    {
        $response = new PointFinderResponse();
        $stop = new Stop();
        $stop->setId(33000028);
        $stop->setName('Helmholtzstraße');

        $response->addPoint($stop);

        self::assertCount(1, $response->getPoints());
        self::assertSame($stop, $response->getPoints()[0]);
    }

    public function testAddPointIgnoresNull(): void
    {
        $response = new PointFinderResponse();
        $response->addPoint(null);

        self::assertNull($response->getPoints());
    }
}
