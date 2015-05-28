<?php

namespace L3l0Labs\Accounting\Invoice;

final class VatIdNumber
{
    private $number;

    public function __construct($number)
    {
        $this->number = $number;
    }

    public function __toString()
    {
        return (string) $this->number;
    }
}