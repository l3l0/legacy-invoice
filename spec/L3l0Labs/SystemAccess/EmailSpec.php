<?php

namespace spec\L3l0Labs\SystemAccess;

use L3l0Labs\SystemAccess\Email;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Email
 */
class EmailSpec extends ObjectBehavior
{
    function it_cannot_be_created_when_given_value_is_not_valid_email()
    {
        $this->beConstructedWith('invalidEmail');
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_cannot_be_created_when_given_value_is_empty_email()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_can_be_created()
    {
        $this->beConstructedWith('leszek.prabucki@gmail.com');

        $this->__toString()->shouldBe('leszek.prabucki@gmail.com');
    }

    function it_normalize_emails_uppercase_characters_to_lowecase()
    {
        $this->beConstructedWith('leszek.Prabucki@GMAIL.com');

        $this->__toString()->shouldBe('leszek.prabucki@gmail.com');
    }
}
