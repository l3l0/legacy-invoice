<?php

namespace L3l0Labs\Accounting;

use L3l0Labs\Accounting\Invoice\VatIdNumber;

interface InvoiceViewRegistry
{
    /**
     * @param $toVatNumber
     * @return Invoice\View[]
     */
    public function incoming(VatIdNumber $toVatNumber);

    /**
     * @param $fromVatNumber
     * @return Invoice\View[]
     */
    public function outgoing(VatIdNumber $fromVatNumber);

}