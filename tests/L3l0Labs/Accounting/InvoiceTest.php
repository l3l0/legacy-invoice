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
                '9562307984'
            ),
            new Invoice\Period(
                new \DateTime('2015-01-01'),
                new \DateTime('2015-01-07')
            ),
            $sellDate = new \DateTime('2015-01-01'),
            new Invoice\Buyer(
                'Leszek Prabucki "l3l0 labs"',
                'ul. Królewskie Wzgórze 21/9, 80-283 Gdańsk',
                '9562307984'
            )
        );
        $invoice->setAdditionalText('test');

        $item = new Invoice\Item(
            'Wytwarzanie aplikacji internetowych',
            $quantity = 1,
            $unitNetPrice = 3000,
            $vatRate = 0.23
        );
        $invoice->addItem($item);

        $this->assertEquals('2015/01/01', $invoice->getNumber());
        $this->assertEquals('Cocoders Sp. z o.o', $invoice->getSeller()->getName());
        $this->assertEquals('ul. Jęczmienna 19, 87-200 Toruń', $invoice->getSeller()->getAddress());
        $this->assertEquals('Leszek Prabucki "l3l0 labs"', $invoice->getBuyer()->getName());
        $this->assertEquals('ul. Królewskie Wzgórze 21/9, 80-283 Gdańsk', $invoice->getBuyer()->getAddress());
    }
}