<?php

namespace L3l0Labs\Accounting;

use L3l0Labs\Accounting\Invoice\VatIdNumber;

interface InvoiceRegistry
{
    /**
     * @param $toVatNumber
     * @return Invoice[]
     */
    public function incoming(VatIdNumber $toVatNumber);

    /**
     * @param $fromVatNumber
     * @return Invoice[]
     */
    public function outgoing(VatIdNumber $fromVatNumber);

    /**
     * Adds invoice into registry.
     *
     * That method should not adds same invoice twice
     *
     * @param Invoice $invoice
     * @return null
     */
    public function add(Invoice $invoice);
}