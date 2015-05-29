<?php

namespace L3l0Labs\Accounting\Invoice;

final class Item
{
    private $name;
    private $quantity;
    private $netPrice;
    private $vatRate;
    private $unit;

    public function __construct($name, $quantity, $netPrice, $vatRate, $unit)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->netPrice = $netPrice;
        $this->vatRate = $vatRate;
        $this->unit = $unit;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function getGrossPrice()
    {
        $totalNetPrice = $this->quantity * $this->netPrice;

        return $totalNetPrice + ($totalNetPrice * ($this->vatRate/100));
    }

    public function getName()
    {
        return $this->name;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getVatRate()
    {
        return $this->vatRate;
    }

    public function getNetPrice()
    {
        return $this->netPrice;
    }
}