<?php

namespace Tests\L3l0Labs\Accounting;

use L3l0Labs\Accounting\Invoice;
use L3l0Labs\Accounting\Invoice\Item;

class InvoiceTest extends \PhpUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canBeIssued()
    {
        $invoice = new Invoice(
            $number = '2015/01/01',
            $sellerName = 'Cocoders Sp. z o.o',
            $sellerAddress = 'ul. Jęczmienna 19, 87-200 Toruń',
            $sellerVatNumber = '9562307984',
            $issueDate = new \DateTime('2015-01-01'),
            $maturityDate = new \DateTime('2015-01-07'),
            $sellDate = new \DateTime('2015-01-01'),
            $buyerName = 'Leszek Prabucki "l3l0 labs"',
            $buyerAddress = 'ul. Królewskie Wzgórze 21/9, 80-283 Gdańsk',
            $buyerVatNumber = '9562307984'
        );
        $invoice->setAdditionalText('test');

        $item = new Item(
            'Wytwarzanie aplikacji internetowych',
            $quantity = 1,
            $unitNetPrice = 3000,
            $vatRate = 0.23
        );

        $invoice->setItems([$item]);

        $this->assertEquals('2015/01/01', $invoice->getNumber());
        $this->assertEquals('Cocoders Sp. z o.o', $invoice->getSellerName());
        $this->assertEquals('ul. Jęczmienna 19, 87-200 Toruń', $invoice->getSellerAddress());
    }
}