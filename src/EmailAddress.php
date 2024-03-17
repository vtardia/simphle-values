<?php

declare(strict_types=1);

namespace Simphle\Value;

use InvalidArgumentException;

readonly class EmailAddress implements \Stringable
{
    use Stringable;

    public string $local;
    public string $domain;

    public function __construct(public string $value)
    {
        /** @link https://en.wikipedia.org/wiki/Email_address */
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("'$value' is not a valid email address");
        }
        $parts = explode('@', $value);
        [$this->local, $this->domain] = $parts;
    }
}
