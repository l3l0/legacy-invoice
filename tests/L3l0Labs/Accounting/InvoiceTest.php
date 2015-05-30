<?php

namespace Tests\L3l0Labs\Accounting;

use L3l0Labs\Accounting\Invoice;

class InvoiceTest extends \PhpUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canBeIssued()
    {
        $invoice = new Invoice(
            $number = '2015/01/01',
            new Invoice\Seller(
                'Cocoders Sp. z o.o',
                'ul. Jęczmienna 19, 87-200 Toruń',
                new Invoice\VatIdNumber('9562307984')
            ),
            new Invoice\Period(
                new \DateTime('2015-01-01'),
                new \DateTime('2015-01-07')
            ),
            $sellDate = new \DateTime('2015-01-01'),
            new Invoice\Buyer(
                'Leszek Prabucki "l3l0 labs"',
                'ul. Królewskie Wzgórze 21/9, 80-283 Gdańsk',
                new Invoice\VatIdNumber('9562307984')
            )
        );
        $invoice->setAdditionalText('test');

        $item = new Invoice\Item(
            'Wytwarzanie aplikacji internetowych',
            $quantity = 1,
            $unitNetPrice = 3000,
            $vatRate = 23,
            'dzień'
        );
        $invoice->addItem($item);

        $invoiceView = new Invoice\View();
        $invoice->fillOutView($invoiceView);
        $this->assertEquals('2015/01/01', $invoiceView->number);
        $this->assertEquals('Cocoders Sp. z o.o', $invoiceView->sellerName);
        $this->assertEquals('ul. Jęczmienna 19, 87-200 Toruń', $invoiceView->sellerAddress);
        $this->assertEquals('Leszek Prabucki "l3l0 labs"', $invoiceView->buyerName);
        $this->assertEquals('ul. Królewskie Wzgórze 21/9, 80-283 Gdańsk', $invoiceView->buyerAddress);
    }
}