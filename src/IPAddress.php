<?php

declare(strict_types=1);

namespace Simphle\Value;

use InvalidArgumentException;

readonly class IPAddress implements \Stringable
{
    use Stringable;

    public const LOCALHOST = '127.0.0.1';

    public function __construct(public string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException("'$value' is not a valid IP address");
        }
    }

    public function isLocalhost(): bool
    {
        return $this->value === self::LOCALHOST;
    }
}
