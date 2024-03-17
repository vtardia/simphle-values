<?php

declare(strict_types=1);

namespace Simphle\Tests\Value;

use InvalidArgumentException;
use Simphle\Value\PhoneNumber;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress UnusedClass, PropertyNotSetInConstructor
 */
class PhoneNumberTest extends TestCase
{
    public function testErrorOnInvalidNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("'09832as' is not a valid phone number");
        new PhoneNumber('09832as');
    }

    public function testValidNumber(): void
    {
        $phone = new PhoneNumber('07432123456');
        $this->assertEquals('07432123456', $phone->value);
        $this->assertEquals('07432123456', "$phone");

        $phone = new PhoneNumber('+447432123456');
        $this->assertEquals('+447432123456', $phone->value);

        $phone = new PhoneNumber('02089451234');
        $this->assertEquals('02089451234', $phone->value);

        $phone = new PhoneNumber('+44.7432.123456');
        $this->assertEquals('+447432123456', $phone->value);
        $this->assertEquals('+447432123456', "$phone");

        $phone = new PhoneNumber('+44-7432-123456');
        $this->assertEquals('+447432123456', $phone->value);

        $phone = new PhoneNumber('07432 123456');
        $this->assertEquals('07432123456', $phone->value);
    }
}
