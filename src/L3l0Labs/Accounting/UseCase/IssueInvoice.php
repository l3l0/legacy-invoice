<?php

namespace L3l0Labs\Accounting\UseCase;

use L3l0Labs\Accounting\Invoice;
use L3l0Labs\Accounting\InvoiceRegistry;

class IssueInvoice
{
    private $invoiceRegistry;

    public function __construct(InvoiceRegistry $invoiceRegistry)
    {
        $this->invoiceRegistry = $invoiceRegistry;
    }

    public function execute(IssueInvoice\Command $command)
    {
        $invoice = new Invoice(
            $command->invoiceNumber,
            new Invoice\Seller(
                $command->sellerName,
                $command->sellerAddress,
                new Invoice\VatIdNumber($command->sellerVatNumber)
            ),
            new Invoice\Period(
                new \DateTimeImmutable($command->dateOfInvoice),
                new \DateTimeImmutable($command->maturityDate)
            ),
            new \DateTimeImmutable($command->sellDate),
            new Invoice\Buyer(
                $command->buyerName,
                $command->buyerAddress,
                new Invoice\VatIdNumber($command->buyerVatNumber)
            )
        );
        if ($command->additionalInfo) {
            $invoice->setAdditionalText($command->additionalInfo);
        }
        foreach ($command->items as $item) {
            $invoice->addItem(new Invoice\Item(
                $item['name'],
                $item['quantity'],
                $item['net_price'],
                $item['vat'],
                $item['unit']
            ));
        }

        $this->invoiceRegistry->add($invoice);
    }
}