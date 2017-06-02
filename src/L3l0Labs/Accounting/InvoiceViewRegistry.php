<?php

declare (strict_types = 1);

namespace L3l0Labs\Accounting;

use L3l0Labs\Accounting\Invoice\VatIdNumber;

interface InvoiceViewRegistry
{
    /**
     * @param $toVatNumber
     * @return View\Invoice[]
     */
    public function incoming(VatIdNumber $toVatNumber) : array;

    /**
     * @param $fromVatNumber
     * @return View\Invoice[]
     */
    public function outgoing(VatIdNumber $fromVatNumber) : array;

}