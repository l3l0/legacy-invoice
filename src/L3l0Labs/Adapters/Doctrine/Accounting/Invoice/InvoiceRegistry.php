<?php

declare (strict_types = 1);

namespace L3l0Labs\Adapters\Doctrine\Accounting\Invoice;

use Doctrine\Common\Persistence\ObjectManager;
use L3l0Labs\Accounting\Invoice;
use L3l0Labs\Accounting\InvoiceRegistry as InvoiceRegistryInterface;

final class InvoiceRegistry implements InvoiceRegistryInterface
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Adds invoice into registry.
     *
     * That method should not adds same invoice twice
     *
     * @param Invoice $invoice
     * @return void
     */
    public function add(Invoice $invoice) : void
    {
        $this->objectManager->persist($invoice);
        $this->objectManager->flush();
    }
}