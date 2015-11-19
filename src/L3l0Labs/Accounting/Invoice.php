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

    public function setAdditionalText($text)
    {
        $this->additionalText = $text;
    }

    public function addItem(Invoice\Item $item)
    {
        $this->items[] = $item;
    }

    public function fillOutView(Invoice\View $view)
    {
        $view->number = $this->number;
        $view->buyerName = $this->buyer->getName();
        $view->buyerAddress = $this->buyer->getAddress();
        $view->buyerVatNumber = $this->buyer->getVatNumber();
        $view->sellDate = $this->sellDate;
        $view->sellerName = $this->seller->getName();
        $view->sellerAddress = $this->seller->getAddress();
        $view->sellerVatNumber = $this->seller->getVatNumber();
        $view->period = $this->period;
        $view->totalPrice = $this->getTotalPrice();
        $view->items = $this->items;
        $view->additionalText = $this->additionalText;
    }

    private function getTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += $item->getGrossPrice();
        }

        return $totalPrice;
    }
}