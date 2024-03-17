<?php

namespace Simphle\Value;

trait Stringable
{
    public function __toString(): string
    {
        return $this->value;
    }
}
