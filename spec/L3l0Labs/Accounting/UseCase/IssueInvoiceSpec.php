<?php

namespace spec\L3l0Labs\Accounting\UseCase;

use L3l0Labs\Accounting\Invoice;
use L3l0Labs\Accounting\InvoiceRegistry;
use L3l0Labs\Accounting\UseCase\IssueInvoice;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin IssueInvoice
 */
class IssueInvoiceSpec extends ObjectBehavior
{
    function let(InvoiceRegistry $invoiceRegistry)
    {
        $this->beConstructedWith($invoiceRegistry);
    }

    function it_issue_new_invoice_and_add_this_invoice_to_registry(InvoiceRegistry $invoiceRegistry)
    {
        $invoiceRegistry->add(Argument::type(Invoice::class))->shouldBeCalled();

        $this
            ->execute(new IssueInvoice\Command(
                '2015/01/01',
                'Cocoders Sp. z o.o',
                'ul. Jęczmienna 19, 87-200 Toruń',
                '9562307984',
                '2015-01-01',
                '2015-01-31',
                '2015-01-01',
                'Leszek Prabucki "l3l0 labs"',
                'ul. Królewskie Wzgórze 21/9, 80-283 Gdańsk',
                '5932455641',
                [
                    [
                        'name' => 'Software Developing',
                        'net_price' => 4000,
                        'quantity' => 1,
                        'vat' => 23,
                        'unit' => 'service'
                    ],
                    [
                        'name' => 'Software Developing 2',
                        'net_price' => 2000,
                        'quantity' => 1,
                        'vat' => 23,
                        'unit' => 'service'
                    ]
                ]
            ))
        ;
    }
}
