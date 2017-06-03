<?php

declare (strict_types = 1);
 
namespace L3l0Labs\SystemAccess;

use InvalidArgumentException;

final class Email
{
    /**
     * @var string
     */
    private $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('%s is not valid email', $email));
        }

        $this->email = strtolower($email);
    }

    public function __toString() : string
    {
        return $this->email;
    }
}