<?php

declare(strict_types=1);

namespace VVOphp\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use VVOphp\Config;
use VVOphp\VVOphp;

#[CoversClass(VVOphp::class)]
final class VVOphpTest extends TestCase
{
    public function testConstructorWithoutLogger(): void
    {
        $vvo = new VVOphp(new Config());

        self::assertNull($vvo->getLogger());
    }

    public function testConstructorWithLogger(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $vvo = new VVOphp(new Config(), $logger);

        self::assertSame($logger, $vvo->getLogger());
    }
}
