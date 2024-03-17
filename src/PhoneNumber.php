<?php

/**
 * A simple and naive value object representing a phone number
 *
 * Accepts phone number in both international format,
 * starting with a plus sign, a country code and a national number,
 * and a loose format like 07654123456.
 *
 * Separators like dots and spaces can be used on input and
 * will be removed.
 */

declare(strict_types=1);

namespace Simphle\Value;

use InvalidArgumentException;

readonly class PhoneNumber implements \Stringable
{
    use Stringable;

    public string $value;

    public function __construct(string $value)
    {
        $cleanValue = str_replace([' ', '-', '.'], '', $value);
        /** @psalm-suppress RiskyTruthyFalsyComparison */
        if (
            !filter_var($cleanValue, FILTER_VALIDATE_REGEXP, [
                'options' => ['regexp' => '/^\+?(?:[0-9]?){6,14}[0-9]$/']
            ])
        ) {
            throw new InvalidArgumentException("'$value' is not a valid phone number");
        }
        $this->value = $cleanValue;
    }
}
