<?php

namespace L3l0Labs\Accounting\Invoice;

final class VatIdNumber
{
    private $number;

    public function __construct($number)
    {
        $this->number = self::normalizeNumber($number);
    }

    public function __toString()
    {
        return (string) $this->number;
    }

    private static function normalizeNumber($number)
    {
        return preg_replace('/[^0-9]/', '', $number);
    }
}