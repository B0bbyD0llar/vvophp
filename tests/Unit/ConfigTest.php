<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Config;

#[CoversClass(Config::class)]
final class ConfigTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $config = new Config();

        self::assertSame('https://webapi.vvo-online.de/tr/pointfinder', $config->getPointFinderAPIURI());
        self::assertSame('https://webapi.vvo-online.de/dm', $config->getDepartureMonitorAPIURI());
        self::assertFalse($config->isProxyEnabled());
        self::assertNull($config->getProxyHost());
    }

    public function testSetPointFinderAPIURI(): void
    {
        $config = new Config();
        $config->setPointFinderAPIURI('https://example.com/pointfinder');

        self::assertSame('https://example.com/pointfinder', $config->getPointFinderAPIURI());
    }

    public function testSetDepartureMonitorAPIURI(): void
    {
        $config = new Config();
        $config->setDepartureMonitorAPIURI('https://example.com/dm');

        self::assertSame('https://example.com/dm', $config->getDepartureMonitorAPIURI());
    }

    public function testProxyConfiguration(): void
    {
        $config = new Config();
        $config->setProxyEnabled(true);
        $config->setProxyHost('http://proxy.local:8080');

        self::assertTrue($config->isProxyEnabled());
        self::assertSame('http://proxy.local:8080', $config->getProxyHost());
    }
}
