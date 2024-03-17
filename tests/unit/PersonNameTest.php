<?php

declare(strict_types=1);

namespace Simphle\Tests\Value;

use InvalidArgumentException;
use Simphle\Value\PersonName;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-suppress UnusedClass, PropertyNotSetInConstructor
 */
class PersonNameTest extends TestCase
{
    public function testErrorOnInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("'Joe' is not a valid full name");
        new PersonName('Joe');
    }

    public function testErrorOnInvalidArgumentsCombination(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No full name or first name given');
        new PersonName(last: 'Osbourne');
    }

    public function testValidName(): void
    {
        $user = new PersonName('John Osbourne');
        $this->assertEquals('John Osbourne', $user->value);
        $this->assertEquals('John Osbourne', "$user");
        $this->assertEquals('John', $user->firstName);
        $this->assertEquals('Osbourne', $user->lastName);
        $this->assertEquals('Last name is Osbourne', $user->format('Last name is %l'));
        $this->assertEquals('First name is John', $user->format('First name is %f'));
        $this->assertEquals('John Osbourne', $user->format('%F'));
        $this->assertEquals('John Osbourne', $user->format('%fl'));

        $user = new PersonName(first: 'John', middle: 'Michael', last: 'Osbourne');
        $this->assertEquals('John', $user->firstName);
        $this->assertEquals('Michael', $user->middleName);
        $this->assertEquals('Osbourne', $user->lastName);
        $this->assertEquals('John Michael Osbourne', $user->value);
        $this->assertEquals('John Michael Osbourne', "$user");
        $this->assertEquals('John Michael Osbourne', $user->format('%F'));
        $this->assertEquals('John Osbourne', $user->format('%fl'));
        $this->assertEquals('OSBOURNE, John Michael', $user->format('%L, %f %m'));

        $user = new PersonName(first: 'John');
        $this->assertEquals('John', $user->value);
        $this->assertEquals('John', "$user");
        $this->assertEquals('John', $user->format('%F'));
        $this->assertEquals('John', $user->format('%fl'));
        $this->assertEquals('John', $user->format('%f %m %l'));

        $user = new PersonName(first: 'John', last: 'Osbourne');
        $this->assertEquals('John Osbourne', $user->value);
        $this->assertEquals('John Osbourne', $user->format('%F'));
        $this->assertEquals('John Osbourne', $user->format('%fl'));
        $this->assertEquals('John Osbourne', $user->format('%f %m %l'));

        $user = new PersonName('John Michael Osbourne');
        $this->assertEquals('John', $user->firstName);
        $this->assertEquals('Michael', $user->middleName);
        $this->assertEquals('Osbourne', $user->lastName);
        $this->assertEquals('John Michael Osbourne', $user->value);
        $this->assertEquals('John Michael Osbourne', $user->format('%F'));

        $user = new PersonName('John Michael Patrick Osbourne');
        $this->assertEquals('John', $user->firstName);
        $this->assertEquals('Michael Patrick', $user->middleName);
        $this->assertEquals('Osbourne', $user->lastName);
        $this->assertEquals('John Michael Patrick Osbourne', $user->value);
        $this->assertEquals('John Michael Patrick Osbourne', $user->format('%F'));
    }
}
