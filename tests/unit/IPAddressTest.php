<?php

declare(strict_types=1);

namespace Simphle\Tests\Value;

use InvalidArgumentException;
use Simphle\Value\IPAddress;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress UnusedClass, PropertyNotSetInConstructor
 */
class IPAddressTest extends TestCase
{
    public function testErrorOnInvalidIP(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("'1.2' is not a valid IP address");
        new IPAddress('1.2');
    }

    public function testValidIPs(): void
    {
        $ip = new IPAddress('1.1.1.1');
        $this->assertEquals('1.1.1.1', $ip->value);
        $ip = new IPAddress('127.0.0.1');
        $this->assertEquals(IPAddress::LOCALHOST, $ip->value);
        $this->assertEquals(IPAddress::LOCALHOST, "$ip");
        $this->assertTrue($ip->isLocalhost());
    }
}
