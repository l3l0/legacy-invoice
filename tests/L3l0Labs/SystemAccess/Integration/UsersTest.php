<?php

declare (strict_types = 1);

namespace Tests\L3l0Labs\SystemAccess\Integration;

use L3l0Labs\Accounting\Invoice\VatIdNumber;
use L3l0Labs\SystemAccess\Email;
use L3l0Labs\SystemAccess\PasswordHash;
use L3l0Labs\SystemAccess\User;
use L3l0Labs\SystemAccess\UserId;
use Tests\L3l0Labs\DoctrineTestCase;

final class UsersTest extends DoctrineTestCase
{
    public function test_adding_new_user()
    {
        $users = $this->get('l3l0labs.system_access.repository.user');

        $user = new User(
            UserId::generate(),
            new Email('leszek.prabucki@gmail.com'),
            new PasswordHash(password_hash('my-secret-password', PASSWORD_BCRYPT)),
            new VatIdNumber('9562307984')
        );

        $users->add($user);
        $fetchedUser = $users->getByEmail(new Email('leszek.prabucki@gmail.com'));

        self::assertSame($user, $fetchedUser);
    }
}