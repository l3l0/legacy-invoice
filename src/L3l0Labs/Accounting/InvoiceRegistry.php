<?php

declare (strict_types = 1);

namespace L3l0Labs\Accounting;

interface InvoiceRegistry
{
    /**
     * Adds invoice into registry.
     *
     * That method should not adds same invoice twice
     *
     * @param Invoice $invoice
     * @return void
     */
    public function add(Invoice $invoice) : void;
}