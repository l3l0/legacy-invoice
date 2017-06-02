<?php

declare (strict_types = 1);

namespace L3l0Labs\Accounting\Invoice;

final class Item
{
    private $name;
    private $quantity;
    private $netPrice;
    private $vatRate;
    private $unit;

    public function __construct(string $name, int $quantity, float $netPrice, int $vatRate, string $unit)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->netPrice = $netPrice;
        $this->vatRate = $vatRate;
        $this->unit = $unit;
    }

    public function getUnit() : string
    {
        return $this->unit;
    }

    public function getGrossPrice() : float
    {
        $totalNetPrice = $this->quantity * $this->netPrice;

        return $totalNetPrice + ($totalNetPrice * ($this->vatRate/100));
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getQuantity() : int
    {
        return $this->quantity;
    }

    public function getVatRate() : int
    {
        return $this->vatRate;
    }

    public function getNetPrice() : float
    {
        return $this->netPrice;
    }
}