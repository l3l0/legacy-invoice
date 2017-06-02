<?php

declare (strict_types = 1);

namespace L3l0Labs\Accounting\Invoice;

final class Buyer
{
    private $name;
    private $address;
    private $vatNumber;

    public function __construct(string $name, string $address, VatIdNumber $vatNumber)
    {
        $this->name = $name;
        $this->address = $address;
        $this->vatNumber = $vatNumber;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getAddress() : string
    {
        return $this->address;
    }

    public function getVatNumber() : VatIdNumber
    {
        return $this->vatNumber;
    }
}