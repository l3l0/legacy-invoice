<?php

namespace spec\L3l0Labs\Accounting\Invoice;

use L3l0Labs\Accounting\Invoice\VatIdNumber;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VatIdNumberSpec extends ObjectBehavior
{
    function it_normalize_given_number()
    {
        $this->beConstructedWith('956 230-7984');

        $this->__toString()->shouldBe('9562307984');
    }
}
