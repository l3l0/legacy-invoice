<?php

declare (strict_types = 1);

namespace L3l0Labs\SystemAccess;

use Ramsey\Uuid\Uuid;

final class UserId
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new \InvalidArgumentException(sprintf('%s is not valid uuid', $id));
        }

        $this->id = $id;
    }

    public static function generate() : UserId
    {
        return new UserId((string) Uuid::uuid4());
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}