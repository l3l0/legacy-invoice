<?php

declare (strict_types = 1);
 
namespace L3l0Labs\SystemAccess;

use L3l0Labs\Accounting\Invoice\VatIdNumber;

class User
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var PasswordHash
     */
    private $passwordHash;

    /**
     * @var VatIdNumber
     */
    private $vatIdNumber;

    public function __construct(
        UserId $id,
        Email $email,
        PasswordHash $passwordHash,
        VatIdNumber $vatIdNumber
    ) {
        $this->id = (string) $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->vatIdNumber = $vatIdNumber;
    }

    public function id() : UserId
    {
        return new UserId($this->id);
    }

    public function email() : Email
    {
        return $this->email;
    }

    public function passwordHash() : PasswordHash
    {
        return $this->passwordHash;
    }

    public function vatIdNumber() : VatIdNumber
    {
        return $this->vatIdNumber;
    }
}