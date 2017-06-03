<?php

declare (strict_types = 1);

namespace L3l0Labs\Accounting;

use DateTimeInterface;
use L3l0Labs\Accounting\Invoice\Buyer;
use L3l0Labs\Accounting\Invoice\Item;
use L3l0Labs\Accounting\Invoice\Period;
use L3l0Labs\Accounting\Invoice\Seller;

class Invoice
{
    /**
     * @var string
     */
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

    /**
     * @var string
     */
    private $additionalText;
    private $items = [];

    /**
     * @var \DateTime
     */
    private $createdAt;

    public function __construct(
        string $number, Seller $seller, Period $period,
        DateTimeInterface $sellDate, Buyer $buyer
    ) {
        $this->number = $number;
        $this->seller = $seller;
        $this->period = $period;
        $this->sellDate = $sellDate;
        $this->buyer = $buyer;
        $this->createdAt = new \DateTime();
    }

    public function setAdditionalText(string $text) : void
    {
        $this->additionalText = $text;
    }

    public function addItem(Invoice\Item $item) : void
    {
        $this->items[] = $item;
    }
}