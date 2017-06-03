<?php

namespace spec\L3l0Labs\SystemAccess;

use L3l0Labs\SystemAccess\PasswordHash;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PasswordHashSpec extends ObjectBehavior
{
    function it_cannot_be_empty()
    {
        $this->beConstructedWith('');

        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_can_be_created()
    {
        $hash = password_hash('password', PASSWORD_BCRYPT);

        $this->beConstructedWith($hash);
        $this->__toString()->shouldBe($hash);
    }
}
