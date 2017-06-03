<?php

declare (strict_types = 1);
 
namespace L3l0Labs\SystemAccess;

use InvalidArgumentException;

final class PasswordHash
{
    /**
     * @var string
     */
    private $hash;

    public function __construct(string $hash)
    {
        if (!$hash) {
            throw new InvalidArgumentException('Password hash cannot be empty');
        }
        $this->hash = $hash;
    }

    public function __toString() : string
    {
        return $this->hash;
    }
}