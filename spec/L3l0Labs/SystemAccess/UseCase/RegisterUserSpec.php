<?php declare(strict_types = 1);

namespace spec\L3l0Labs\SystemAccess\UseCase;

use L3l0Labs\SystemAccess\Exception\UserNotFoundException;
use L3l0Labs\SystemAccess\UseCase\RegisterUser;
use L3l0Labs\SystemAccess\UseCase\RegisterUser\Command;
use L3l0Labs\SystemAccess\Email;
use L3l0Labs\SystemAccess\User;
use L3l0Labs\SystemAccess\UserId;
use L3l0Labs\SystemAccess\Users;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegisterUserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beAnInstanceOf(RegisterUser::class);
    }

    function let(Users $users)
    {
        $this->beConstructedWith($users);
    }

    function it_register_new_user(Users $users)
    {
        $users->getByEmail(new Email('tomasz.strzelecki@wp.pl'))->willThrow(new UserNotFoundException());

        $users->add(Argument::type(User::class))->shouldBeCalled();

        $command = new Command(
            'tomasz.strzelecki@wp.pl',
            'password',
            '9562307984'
        );

        $this->execute($command);
    }

    function it_disallow_to_register_when_email_exist(Users $users, User $user)
    {
        $users->getByEmail(new Email('tomasz.strzelecki@wp.pl'))->willReturn($user);

        $users->add(Argument::type(User::class))->shouldNotBeCalled();

        $command = new Command(
            'tomasz.strzelecki@wp.pl',
            'password',
            '9562307984'
        );

        $this->execute($command);
    }
}
