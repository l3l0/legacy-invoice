<?php

namespace L3l0Labs\Accounting\Invoice;

final class Item
{
    private $name;
    private $quantity;
    private $netPrice;
    private $vatRate;

    public function __construct($name, $quantity, $netPrice, $vatRate)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->netPrice = $netPrice;
        $this->vatRate = $vatRate;
    }
}