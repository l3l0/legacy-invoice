<?php

declare (strict_types = 1);
 
namespace L3l0Labs\SystemAccess\UseCase;

use L3l0Labs\Accounting\Invoice\VatIdNumber;
use L3l0Labs\SystemAccess\Email;
use L3l0Labs\SystemAccess\PasswordHash;
use L3l0Labs\SystemAccess\UseCase\RegisterUser\Command;
use L3l0Labs\SystemAccess\User;
use L3l0Labs\SystemAccess\UserId;
use L3l0Labs\SystemAccess\Users;

final class RegisterUser
{
    /**
     * @var Users
     */
    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function execute(Command $command)
    {
        if (!$this->users->find(new Email($command->email()))) {
            $user = new User(
                UserId::generate(),
                new Email($command->email()),
                new PasswordHash(password_hash($command->password(), PASSWORD_BCRYPT)),
                new VatIdNumber($command->vatIdNumber())
            );

            $this->users->add($user);
        }
    }
}