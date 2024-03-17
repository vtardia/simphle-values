<?php

declare(strict_types=1);

namespace Simphle\Value;

use InvalidArgumentException;

/** @psalm-suppress PropertyNotSetInConstructor */
readonly class PersonName implements \Stringable
{
    use Stringable;

    public string $firstName;
    public string $middleName;
    public string $lastName;
    public string $value;

    public function __construct(
        string $full = '',
        string $first = '',
        string $middle = '',
        string $last = ''
    ) {
        if (!empty($full)) {
            $parts = explode(' ', $full);
            if (count($parts) < 2) {
                throw new InvalidArgumentException("'$full' is not a valid full name");
            }
            $this->value = $full;
            $this->firstName = current($parts);
            $this->lastName = end($parts);
            if (count($parts) > 2) {
                $this->middleName = implode(' ', array_slice($parts, 1, -1));
            } else {
                $this->middleName = '';
            }
        } elseif (!empty($first)) {
            $this->firstName = $first;
            if (!empty($middle) && !empty($last)) {
                $this->value = "$first $middle $last";
                $this->middleName = $middle;
                $this->lastName = $last;
            } elseif (!empty($last)) {
                $this->value = "$first $last";
                $this->lastName = $last;
                $this->middleName = '';
            } else {
                $this->value = $first;
                $this->lastName = '';
                $this->middleName = '';
            }
        } else {
            throw new InvalidArgumentException('No full name or first name given');
        }
    }

    /**
     * %F = Full name including middle names (e.g. John Michael Patrick Osbourne)
     * %fl = First and last name, if exists (e.g. John Osbourne or John)
     * %f = First name
     * %m = Middle name or nothing
     * %l = Last name or nothing
     * %L = Last to uppercase or nothing
     */
    public function format(string $format): string
    {
        switch ($format) {
            case '%F':
                $out = $this->firstName;
                if (!empty($this->middleName)) {
                    $out .= ' ' . $this->middleName;
                }
                if (!empty($this->lastName)) {
                    $out .= ' ' . $this->lastName;
                }
                break;
            case '%fl':
                $out = $this->firstName;
                if (!empty($this->lastName)) {
                    $out .= ' ' . $this->lastName;
                }
                break;
            default:
                $out = strtr($format, [
                    '%f' => $this->firstName,
                    '%m' => $this->middleName,
                    '%l' => $this->lastName,
                    '%L' => strtoupper($this->lastName)
                ]);
                break;
        }
        return trim(str_replace('  ', ' ', $out));
    }
}
