<?php declare(strict_types = 1);

namespace L3l0Labs\SystemAccess\UseCase\RegisterUser;

class Command
{
    private $email;
    private $password;
    private $vatIdNumber;

    public function __construct($email, $password, $vatIdNumber)
    {
        $this->email = $email;
        $this->password = $password;
        $this->vatIdNumber = $vatIdNumber;
    }

    public function email()
    {
        return $this->email;
    }

    public function password()
    {
        return $this->password;
    }

    public function vatIdNumber()
    {
        return $this->vatIdNumber;
    }
}