<?php

namespace spec\App\Security;

use App\Security\UserProvider;
use L3l0Labs\SystemAccess\Email;
use L3l0Labs\SystemAccess\Exception\UserNotFoundException;
use L3l0Labs\SystemAccess\PasswordHash;
use L3l0Labs\SystemAccess\User;
use PhpSpec\ObjectBehavior;
use L3l0Labs\SystemAccess\Users;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @mixin UserProvider
 */
class UserProviderSpec extends ObjectBehavior
{
    function let(Users $users)
    {
        $this->beConstructedWith($users);
    }

    function its_loadUserByUsername_method_fetch_system_access_user_from_repository_and_convert_it_to_security_user(
        Users $users,
        User $user
    ) {
        $users
            ->get(new Email('leszek.prabucki@gmail.com'))
            ->willReturn($user)
        ;

        $user->email()->willReturn(new Email('leszek.prabucki@gmail.com'));
        $user->passwordHash()->willReturn(new PasswordHash('hash'));

        $securityUser = $this->loadUserByUsername('leszek.prabucki@gmail.com');
        $securityUser->getUsername()->shouldBe('leszek.prabucki@gmail.com');
        $securityUser->getPassword()->shouldBe('hash');
    }

    function its_loadUserByUsername_throws_username_not_found_when_email_is_not_valid()
    {
        $this
            ->shouldThrow(UsernameNotFoundException::class)
            ->duringLoadUserByUsername('invalid');
    }

    function its_loadUserByUsername_throws_username_not_found_when_user_is_not_found(Users $users)
    {
        $users
            ->get(new Email('leszek.prabucki@gmail.com'))
            ->willThrow(
                new UserNotFoundException()
            )
        ;
        $this
            ->shouldThrow(UsernameNotFoundException::class)
            ->duringLoadUserByUsername('leszek.prabucki@gmail.com');
    }

    function its_refreshUser_should_return_passed_user(UserInterface $user)
    {
        $this->refreshUser($user)->shouldBe($user);
    }
}
