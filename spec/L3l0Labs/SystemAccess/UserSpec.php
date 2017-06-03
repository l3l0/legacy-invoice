<?php
namespace spec\L3l0Labs\SystemAccess;

use L3l0Labs\Accounting\Invoice\VatIdNumber;
use L3l0Labs\SystemAccess\User;
use L3l0Labs\SystemAccess\Email;
use L3l0Labs\SystemAccess\PasswordHash;
use L3l0Labs\SystemAccess\UserId;
use PhpSpec\ObjectBehavior;

/**
 * @mixin User
 */
class UserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            UserId::generate(),
            new Email('leszek.prabucki@gmail.com'),
            new PasswordHash('passwordHash'),
            new VatIdNumber('9562307984')
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    function it_allows_to_get_email()
    {
        $this->email()->shouldBeLike(new Email('leszek.prabucki@gmail.com'));
    }

    function it_allows_to_get_hash()
    {
        $this->passwordHash()->shouldBeLike(new PasswordHash('passwordHash'));
    }

    function it_allows_to_get_vat_id_number()
    {
        $this->vatIdNumber()->shouldBeLike(new VatIdNumber('9562307984'));
    }
}
