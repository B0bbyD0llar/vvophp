<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use VVOphp\Helper;

#[CoversClass(Helper::class)]
final class HelperTest extends TestCase
{
    public function testGetDateFromJSONWithDefaultTimezone(): void
    {
        $result = Helper::getDateFromJSON('/Date(1653045480000+0200)/');

        self::assertInstanceOf(\DateTimeInterface::class, $result);
        self::assertSame('Europe/Berlin', $result->getTimezone()->getName());
    }

    public function testGetDateFromJSONWithPassedTimezone(): void
    {
        $result = Helper::getDateFromJSON('/Date(1653045480000+0200)/', false);

        self::assertInstanceOf(\DateTimeInterface::class, $result);
        self::assertSame('+02:00', $result->getTimezone()->getName());
    }

    public function testGetDateFromJSONReturnsCorrectDate(): void
    {
        // 1653045480000ms = 1653045480s = 2022-05-20 12:18:00 UTC
        $result = Helper::getDateFromJSON('/Date(1653045480000+0200)/');

        self::assertSame('2022', $result->format('Y'));
        self::assertSame('05', $result->format('m'));
        self::assertSame('20', $result->format('d'));
    }

    public function testGetDateFromJSONWithNonMatchingTimestampReturnsFallback(): void
    {
        // Use a string that matches the regex pattern but produces an invalid timestamp
        $result = Helper::getDateFromJSON('/Date(0000+0200)/');

        self::assertInstanceOf(\DateTimeInterface::class, $result);
    }
}
