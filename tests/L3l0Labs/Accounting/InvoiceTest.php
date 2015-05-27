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
        $invoice = new Invoice();
        $invoice->setNumber('2015/01/01');
        $invoice->setSellerName('Cocoders Sp. z o.o');
        $invoice->setSellerAddress('ul. Jęczmienna 19, 87-200 Toruń');
        $invoice->setSellerVatNumber('9562307984');
        $invoice->setIssueDate(new \DateTime('2015-01-01'));
        $invoice->setMaturityDate(new \DateTime('2015-01-07'));
        $invoice->setSellDate(new \DateTime('2015-01-01'));
        $invoice->setBuyerName('Leszek Prabucki "l3l0 labs"');
        $invoice->setBuyerAddress('ul. Królewskie Wzgórze 21/9, 80-283 Gdańsk');
        $invoice->setBuyerVatNumber('9562307984');
        $invoice->setAdditionalInfo('test');

        $item = new Item();
        $item->setName('Wytwarzanie aplikacji internetowych');
        $item->setQuantity(1);
        $item->setUnitNetPrice(3000);
        $item->setVatRate(0.23);

        $invoice->setItems([$item]);

        $this->assertEquals('2015/01/01', $invoice->getNumber());
        $this->assertEquals('Cocoders Sp. z o.o', $invoice->getSellerName());
        $this->assertEquals('ul. Jęczmienna 19, 87-200 Toruń', $invoice->getSellerAddress());
    }
}