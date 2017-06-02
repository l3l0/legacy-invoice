<?php

declare (strict_types = 1);

namespace L3l0Labs\Accounting\UseCase\IssueInvoice;

final class Command
{
    public $invoiceNumber;
    public $sellerName;
    public $sellerAddress;
    public $sellerVatNumber;
    public $dateOfInvoice;
    public $maturityDate;
    public $sellDate;
    public $buyerName;
    public $buyerAddress;
    public $buyerVatNumber;
    public $additionalInfo;
    public $items;

    public function __construct(
        string $invoiceNumber,
        string $sellerName,
        string $sellerAddress,
        string $sellerVatNumber,
        string $dateOfInvoice,
        string $maturityDate,
        string $sellDate,
        string $buyerName,
        string $buyerAddress,
        string $buyerVatNumber,
        $items = []
    ) {

        $this->invoiceNumber = $invoiceNumber;
        $this->sellerName = $sellerName;
        $this->sellerAddress = $sellerAddress;
        $this->sellerVatNumber = $sellerVatNumber;
        $this->sellDate = $sellDate;
        $this->buyerName = $buyerName;
        $this->buyerAddress = $buyerAddress;
        $this->buyerVatNumber = $buyerVatNumber;
        $this->items = $items;
        $this->dateOfInvoice = $dateOfInvoice;
        $this->maturityDate = $maturityDate;
    }
}