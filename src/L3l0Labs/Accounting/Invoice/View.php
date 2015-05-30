<?php

namespace L3l0Labs\Accounting\Invoice;

class View
{
    public $number;
    public $sellerName;
    public $sellerAddress;
    /**
     * @var VatIdNumber
     */
    public $sellerVatNumber;
    /**
     * @var \DateTimeInterface
     */
    public $sellDate;
    /**
     * @var Period
     */
    public $period;
    public $buyerName;
    public $buyerAddress;
    /**
     * @var VatIdNumber
     */
    public $buyerVatNumber;
    public $additionalText;
    public $totalPrice;
    /**
     * @var Item[]
     */
    public $items = [];
}