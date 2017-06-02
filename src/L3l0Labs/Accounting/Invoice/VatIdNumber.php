<?php

declare (strict_types = 1);

namespace L3l0Labs\Accounting\Invoice;

final class VatIdNumber
{
    private $number;

    public function __construct(string $number)
    {
        $this->number = self::normalizeNumber($number);
    }

    public function __toString() : string
    {
        return (string) $this->number;
    }

    private static function normalizeNumber(string $number) : string
    {
        return preg_replace('/[^0-9]/', '', $number);
    }
}