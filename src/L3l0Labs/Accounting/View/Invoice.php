<?php

declare (strict_types = 1);

namespace L3l0Labs\Accounting\View;

use DateTimeInterface;
use L3l0Labs\Accounting\Invoice\Item;
use L3l0Labs\Accounting\Invoice\Period;
use L3l0Labs\Accounting\Invoice\VatIdNumber;

final class Invoice
{
    private $number;
    private $sellerName;
    private $sellerAddress;
    private $sellerVatNumber;
    private $sellDate;
    private $period;
    private $buyerName;
    private $buyerAddress;
    private $buyerVatNumber;
    private $additionalText;
    private $totalPrice;
    private $items = [];

    public function __construct(
        string $number,
        string $sellerName,
        string $sellerAddress,
        VatIdNumber $sellerVatNumber,
        DateTimeInterface $sellDate,
        Period $period,
        string $buyerName,
        string $buyerAddress,
        VatIdNumber $buyerVatNumber,
        string $additionalText,
        float $totalPrice,
        array $items
    ) {
        $this->number = $number;
        $this->sellerName = $sellerName;
        $this->sellerAddress = $sellerAddress;
        $this->sellerVatNumber = $sellerVatNumber;
        $this->sellDate = $sellDate;
        $this->period = $period;
        $this->buyerName = $buyerName;
        $this->buyerAddress = $buyerAddress;
        $this->buyerVatNumber = $buyerVatNumber;
        $this->additionalText = $additionalText;
        $this->totalPrice = $totalPrice;
        $this->items = $items;
    }

    public function getNumber() : string
    {
        return $this->number;
    }

    public function getSellerName() : string
    {
        return $this->sellerName;
    }

    public function getSellerAddress() : string
    {
        return $this->sellerAddress;
    }

    public function getSellDate() : DateTimeInterface
    {
        return $this->sellDate;
    }

    public function getPeriod() : Period
    {
        return $this->period;
    }

    public function getBuyerName() : string
    {
        return $this->buyerName;
    }

    public function getBuyerAddress() : string
    {
        return $this->buyerAddress;
    }

    public function getBuyerVatNumber() : VatIdNumber
    {
        return $this->buyerVatNumber;
    }

    public function getAdditionalText() : string
    {
        return $this->additionalText;
    }

    public function getTotalPrice() : float
    {
        return $this->totalPrice;
    }

    /**
     * @return Item[]
     */
    public function getItems() : array
    {
        return $this->items;
    }
}