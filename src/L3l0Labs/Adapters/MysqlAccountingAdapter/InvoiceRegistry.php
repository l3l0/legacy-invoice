<?php

namespace L3l0Labs\Adapters\MysqlAccountingAdapter;

use L3l0Labs\Accounting\Invoice;
use L3l0Labs\Accounting\Invoice\VatIdNumber;
use L3l0Labs\Accounting\InvoiceRegistry as InvoiceRegistryInterface;

final class InvoiceRegistry implements InvoiceRegistryInterface
{
    /**
     * @var \PDO
     */
    private $pdoHandler;

    public function __construct(\PDO $pdoHandler)
    {
        $this->pdoHandler = $pdoHandler;
    }

    /**
     * @param $toVatNumber
     * @return Invoice[]
     */
    public function incoming(VatIdNumber $toVatNumber)
    {
        $invoicesResultStmt = $this
            ->pdoHandler
            ->prepare('SELECT invoice.*, item.* FROM invoices invoice LEFT JOIN invoice_items item ON invoice.id = item.invoice_id WHERE invoice.buyer_vat_number = :vat')
        ;
        $invoicesResultStmt->bindValue('vat', (string) $toVatNumber);
        $invoicesResultStmt->execute();
        $invoicesResults = $invoicesResultStmt->fetchAll();

        return $this->hydrateToInvoices($invoicesResults);
    }

    /**
     * @param $fromVatNumber
     * @return Invoice[]
     */
    public function outgoing(VatIdNumber $fromVatNumber)
    {
        $invoicesResultStmt = $this
            ->pdoHandler
            ->prepare('SELECT invoice.*, item.* FROM invoices invoice LEFT JOIN invoice_items item ON invoice.id = item.invoice_id WHERE invoice.seller_vat_number = :vat')
        ;
        $invoicesResultStmt->bindValue('vat', (string) $fromVatNumber);
        $invoicesResultStmt->execute();
        $invoicesResults = $invoicesResultStmt->fetchAll();

        return $this->hydrateToInvoices($invoicesResults);
    }

    /**
     * Adds invoice into registry.
     *
     * That method should not adds same invoice twice
     *
     * @param Invoice $invoice
     * @return null
     */
    public function add(Invoice $invoice)
    {

        if ($this->shouldBeUpdated($invoice)) {
            $this->pdoHandler->beginTransaction();
            $this->update($invoice);
            $this->pdoHandler->commit();
            return;
        }
        $this->pdoHandler->beginTransaction();
        $this->insert($invoice);
        $this->pdoHandler->commit();
    }

    private function update(Invoice $invoice)
    {
        throw new \LogicException('Not implemented yet');
    }

    private function insert(Invoice $invoice)
    {
        $stmt = $this->pdoHandler->prepare('INSERT INTO invoices (invoice_number, date_of_invoice, sell_date, maturity_date, seller_name, seller_address, seller_vat_number, buyer_name, buyer_address, buyer_vat_number, additional_info, total_price) VALUES (:invoice_number, :date_of_invoice, :sell_date, :maturity_date, :seller_name, :seller_address, :seller_vat_number, :buyer_name, :buyer_address, :buyer_vat_number, :additional_info, :total_price)');
        $success = $stmt->execute([
            'invoice_number' => $invoice->getNumber(),
            'date_of_invoice' => $invoice->getPeriod()->getFrom()->format('Y-m-d'),
            'sell_date' => $invoice->getSellDate()->format('Y-m-d'),
            'maturity_date' => $invoice->getPeriod()->getTo()->format('Y-m-d'),
            'seller_name' => $invoice->getSeller()->getName(),
            'seller_address' => $invoice->getSeller()->getAddress(),
            'seller_vat_number' => (string) $invoice->getSeller()->getVatNumber(),
            'buyer_name' => $invoice->getBuyer()->getName(),
            'buyer_address' => $invoice->getBuyer()->getAddress(),
            'buyer_vat_number' => (string) $invoice->getBuyer()->getVatNumber(),
            'additional_info' => $invoice->getAdditionalText(),
            'total_price' => $invoice->getTotalPrice()
        ]);
        if (!$success) {
            throw new \RuntimeException(
                sprintf(
                    'Cannot insert invoice %s (mysql adapter) errno: %s',
                    $invoice->getNumber(),
                    $this->pdoHandler->errorCode()
                )
            );
        }

        $invoiceId = $this->lastInvoiceId();
        foreach ($invoice->getItems() as $item) {
            $stmt = $this->pdoHandler->prepare(
                "INSERT INTO invoice_items (invoice_id, name, quantity, unit, net_price, vat, total_price) VALUES (:invoice_id, :name, :quantity, :unit, :net_price, :vat, :total_price)"
            );
            $success = $stmt->execute([
                'invoice_id' => $invoiceId,
                'name' => $item->getName(),
                'quantity' => $item->getQuantity(),
                'unit' => $item->getUnit(),
                'net_price' => $item->getNetPrice(),
                'vat' => $item->getVatRate(),
                'total_price' => $item->getGrossPrice()
            ]);
            if (!$success) {
                throw new \RuntimeException(
                    sprintf(
                        'Cannot insert invoice item to invoice %s into (mysql adapter). errno %s invoice id %s',
                        $invoice->getNumber(),
                        $invoiceId
                    )
                );
            }
        }
    }

    /**
     * @param Invoice $invoice
     * @return boolean
     */
    private function shouldBeUpdated(Invoice $invoice)
    {
        $invoiceIsForUpdateStmt = $this
            ->pdoHandler
            ->prepare('SELECT id FROM invoices WHERE invoice_number = :invoiceNumber AND seller_vat_number = :sellerVatNumber')
        ;
        $invoiceIsForUpdateStmt->bindValue('invoiceNumber', (string) $invoice->getNumber());
        $invoiceIsForUpdateStmt->bindValue('sellerVarNumber', (string) $invoice->getSeller()->getVatNumber());

        return (boolean) $invoiceIsForUpdateStmt->fetchColumn();
    }

    private function lastInvoiceId()
    {
        return $this->pdoHandler->lastInsertId();
    }

    /**
     * @param $invoicesResults
     * @return Invoice[]
     */
    private function hydrateToInvoices($invoicesResults)
    {
        $invoices = [];
        foreach ($invoicesResults as $invoiceResult) {
            if (!isset($invoices[$invoiceResult['invoice_number']])) {
                $invoices[$invoiceResult['invoice_number']] = new Invoice(
                    $invoiceResult['invoice_number'],
                    new Invoice\Seller(
                        $invoiceResult['seller_name'],
                        $invoiceResult['seller_address'],
                        new VatIdNumber($invoiceResult['seller_vat_number'])
                    ),
                    new Invoice\Period(
                        new \DateTimeImmutable($invoiceResult['date_of_invoice']),
                        new \DateTimeImmutable($invoiceResult['maturity_date'])
                    ),
                    new \DateTimeImmutable($invoiceResult['sell_date']),
                    new Invoice\Buyer(
                        $invoiceResult['seller_name'],
                        $invoiceResult['seller_address'],
                        new VatIdNumber($invoiceResult['seller_vat_number'])
                    )
                );
                $invoices[$invoiceResult['invoice_number']]->setAdditionalText($invoiceResult['additional_info']);
            }

            $invoices[$invoiceResult['invoice_number']]->addItem(new Invoice\Item(
                $invoiceResult['name'],
                $invoiceResult['quantity'],
                $invoiceResult['net_price'],
                $invoiceResult['vat'],
                $invoiceResult['unit']
            ));
        }

        return $invoices;
    }
}