<?php

declare (strict_types = 1);

namespace Tests\L3l0Labs\Accounting\Integration\UseCase;

use L3l0Labs\Accounting\Invoice\VatIdNumber;
use L3l0Labs\Accounting\UseCase\IssueInvoice;
use L3l0Labs\Accounting\View\Invoice;
use Tests\L3l0Labs\DoctrineTestCase;

final class IssueInvoiceTest extends DoctrineTestCase
{
    public function test_that_issue_invoice_correctly()
    {
        $this
            ->get('l3l0labs.accounting.use_case.issue_invoice')
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

        /**
         * @var Invoice[] $invoices
         */
        $invoices = $this
            ->get('l3l0labs.accounting.view.invoice')
            ->incoming(new VatIdNumber('5932455641'));

        $invoice = reset($invoices);
        self::assertCount(1, $invoices);
        self::assertEquals('2015/01/01', $invoice->getNumber());
        self::assertEquals('Cocoders Sp. z o.o', $invoice->getSellerName());
        self::assertEquals('ul. Jęczmienna 19, 87-200 Toruń', $invoice->getSellerAddress());
        self::assertCount(2, $invoice->getItems());

        $invoices = $this
            ->get('l3l0labs.accounting.view.invoice')
            ->outgoing(new VatIdNumber('9562307984'));

        self::assertCount(1, $invoices);
        $invoice = reset($invoices);
        self::assertCount(1, $invoices);
        self::assertEquals('2015/01/01', $invoice->getNumber());
        self::assertEquals('Cocoders Sp. z o.o', $invoice->getSellerName());
        self::assertEquals('ul. Jęczmienna 19, 87-200 Toruń', $invoice->getSellerAddress());
        self::assertCount(2, $invoice->getItems());
    }
}