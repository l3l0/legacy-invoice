<?php

namespace L3l0Labs\Accounting;

use DateTimeInterface;
use L3l0Labs\Accounting\Invoice\Buyer;
use L3l0Labs\Accounting\Invoice\Item;
use L3l0Labs\Accounting\Invoice\Period;
use L3l0Labs\Accounting\Invoice\Seller;

class Invoice
{
    private $number;
    /**
     * @var Seller
     */
    private $seller;
    /**
     * @var Period
     */
    private $period;
    /**
     * @var DateTimeInterface
     */
    private $sellDate;
    /**
     * @var Buyer
     */
    private $buyer;
    private $additionalText;
    private $items = [];

    public function __construct(
        $number, Seller $seller, Period $period,
        DateTimeInterface $sellDate, Buyer $buyer
    )
    {
        $this->number = $number;
        $this->seller = $seller;
        $this->period = $period;
        $this->sellDate = $sellDate;
        $this->buyer = $buyer;
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return Seller
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * @return Buyer
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    public function setAdditionalText($additionalText)
    {
        $this->additionalText = $additionalText;
    }
}