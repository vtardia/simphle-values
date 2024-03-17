<?php

declare(strict_types=1);

namespace Simphle\Tests\Value;

use InvalidArgumentException;
use Simphle\Value\EmailAddress;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress UnusedClass, PropertyNotSetInConstructor
 */
class EmailAddressTest extends TestCase
{
    public function testErrorOnInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("'foo@bar' is not a valid email address");
        new EmailAddress('foo@bar');
    }

    public function testValidEmail(): void
    {
        $email = new EmailAddress('fox.mulder@fbi.gov');
        $this->assertEquals('fox.mulder@fbi.gov', $email->value);
        $this->assertEquals('fox.mulder@fbi.gov', "$email");
        $this->assertEquals('fox.mulder', $email->local);
        $this->assertEquals('fbi.gov', $email->domain);
    }
}
