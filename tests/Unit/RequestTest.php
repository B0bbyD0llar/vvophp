<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Config;
use VVOphp\Request;

#[CoversClass(Request::class)]
final class RequestTest extends TestCase
{
    public function testSetQueryURIReturnsSelf(): void
    {
        $request = new Request(new Config());

        self::assertInstanceOf(Request::class, $request->setQueryURI('https://example.com'));
    }

    public function testSetQueryBodyReturnsSelf(): void
    {
        $request = new Request(new Config());

        self::assertInstanceOf(Request::class, $request->setQueryBody(['key' => 'value']));
    }

    public function testGetQueryBodyReturnsJson(): void
    {
        $request = new Request(new Config());
        $request->setQueryBody(['query' => 'Helmholtzstraße', 'limit' => 5]);

        self::assertSame('{"query":"Helmholtzstra\u00dfe","limit":5}', $request->getQueryBody());
    }

    public function testSetResponseJSON(): void
    {
        $request = new Request(new Config());
        $request->setResponseJSON('{"status":"ok"}');

        self::assertSame('{"status":"ok"}', $request->getResponseJSON());
    }

    public function testSetResponseStatusCode(): void
    {
        $request = new Request(new Config());
        $request->setResponseStatusCode(200);

        self::assertSame(200, $request->getResponseStatusCode());
    }

    public function testStartRequestThrowsWithoutURI(): void
    {
        $request = new Request(new Config());
        $request->setQueryBody(['test' => 'data']);

        $this->expectException(\Error::class);
        $request->StartRequest();
    }

    public function testStartRequestThrowsWithoutBody(): void
    {
        $request = new Request(new Config());
        $request->setQueryURI('https://example.com');

        $this->expectException(\Error::class);
        $request->StartRequest();
    }
}
