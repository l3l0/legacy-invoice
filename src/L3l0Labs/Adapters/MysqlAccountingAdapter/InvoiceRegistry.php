<?php

namespace L3l0Labs\Adapters\MysqlAccountingAdapter;

use L3l0Labs\Accounting\Invoice;
use L3l0Labs\Accounting\Invoice\VatIdNumber;
use L3l0Labs\Accounting\InvoiceRegistry as InvoiceRegistryInterface;
use L3l0Labs\Accounting\InvoiceViewRegistry;

final class InvoiceRegistry implements InvoiceRegistryInterface, InvoiceViewRegistry
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
     * @return Invoice\View[]
     */
    public function incoming(VatIdNumber $toVatNumber)
    {
        $invoicesResultStmt = $this
            ->pdoHandler
            ->prepare('SELECT invoice.*, item.*, invoice.total_price as invoice_total_price FROM invoices invoice LEFT JOIN invoice_items item ON invoice.id = item.invoice_id WHERE invoice.buyer_vat_number = :vat')
        ;
        $invoicesResultStmt->bindValue('vat', (string) $toVatNumber);
        $invoicesResultStmt->execute();
        $invoicesResults = $invoicesResultStmt->fetchAll();

        return $this->hydrateToInvoiceViews($invoicesResults);
    }

    /**
     * @param $fromVatNumber
     * @return Invoice\View[]
     */
    public function outgoing(VatIdNumber $fromVatNumber)
    {
        $invoicesResultStmt = $this
            ->pdoHandler
            ->prepare('SELECT invoice.*, item.*, invoice.total_price as invoice_total_price FROM invoices invoice LEFT JOIN invoice_items item ON invoice.id = item.invoice_id WHERE invoice.seller_vat_number = :vat')
        ;
        $invoicesResultStmt->bindValue('vat', (string) $fromVatNumber);
        $invoicesResultStmt->execute();
        $invoicesResults = $invoicesResultStmt->fetchAll();

        return $this->hydrateToInvoiceViews($invoicesResults);
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
        $invoiceView = new Invoice\View();
        $invoice->fillOutView($invoiceView);

        $stmt = $this->pdoHandler->prepare('INSERT INTO invoices (invoice_number, date_of_invoice, sell_date, maturity_date, seller_name, seller_address, seller_vat_number, buyer_name, buyer_address, buyer_vat_number, additional_info, total_price) VALUES (:invoice_number, :date_of_invoice, :sell_date, :maturity_date, :seller_name, :seller_address, :seller_vat_number, :buyer_name, :buyer_address, :buyer_vat_number, :additional_info, :total_price)');
        $success = $stmt->execute([
            'invoice_number' => $invoiceView->number,
            'date_of_invoice' => $invoiceView->period->getFrom()->format('Y-m-d'),
            'sell_date' => $invoiceView->sellDate->format('Y-m-d'),
            'maturity_date' => $invoiceView->period->getTo()->format('Y-m-d'),
            'seller_name' => $invoiceView->sellerName,
            'seller_address' => $invoiceView->sellerAddress,
            'seller_vat_number' => (string) $invoiceView->sellerVatNumber,
            'buyer_name' => $invoiceView->buyerName,
            'buyer_address' => $invoiceView->buyerAddress,
            'buyer_vat_number' => (string) $invoiceView->buyerVatNumber,
            'additional_info' => $invoiceView->additionalText,
            'total_price' => $invoiceView->totalPrice
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
        foreach ($invoiceView->items as $item) {
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
     * @return Invoice\View[]
     */
    private function hydrateToInvoiceViews($invoicesResults)
    {
        $invoiceViews = [];
        foreach ($invoicesResults as $invoiceResult) {
            if (!isset($invoiceViews[$invoiceResult['invoice_number']])) {
                $invoiceView = new Invoice\View;
                $invoiceView->number = $invoiceResult['invoice_number'];
                $invoiceView->sellerName = $invoiceResult['seller_name'];
                $invoiceView->sellerAddress = $invoiceResult['seller_address'];
                $invoiceView->sellerVatNumber = new VatIdNumber($invoiceResult['seller_vat_number']);
                $invoiceView->period = new Invoice\Period(
                    new \DateTimeImmutable($invoiceResult['date_of_invoice']),
                    new \DateTimeImmutable($invoiceResult['maturity_date'])
                );
                $invoiceView->sellDate = new \DateTimeImmutable($invoiceResult['sell_date']);
                $invoiceView->buyerName = $invoiceResult['buyer_name'];
                $invoiceView->buyerAddress = $invoiceResult['seller_address'];
                $invoiceView->buyerVatNumber = new VatIdNumber($invoiceResult['buyer_vat_number']);
                $invoiceView->additionalText = $invoiceResult['additional_info'];
                $invoiceView->totalPrice = $invoiceResult['invoice_total_price'];

                $invoiceViews[$invoiceResult['invoice_number']] = $invoiceView;
            }

            $invoiceViews[$invoiceResult['invoice_number']]->items[] = new Invoice\Item(
                $invoiceResult['name'],
                $invoiceResult['quantity'],
                $invoiceResult['net_price'],
                $invoiceResult['vat'],
                $invoiceResult['unit']
            );
        }

        return $invoiceViews;
    }
}