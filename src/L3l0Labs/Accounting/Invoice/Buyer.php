<?php

namespace L3l0Labs\Accounting\Invoice;

final class Buyer
{
    private $name;
    private $address;
    private $vatNumber;

    public function __construct($name, $address, $vatNumber)
    {
        $this->name = $name;
        $this->address = $address;
        $this->vatNumber = $vatNumber;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getVatNumber()
    {
        return $this->vatNumber;
    }
}