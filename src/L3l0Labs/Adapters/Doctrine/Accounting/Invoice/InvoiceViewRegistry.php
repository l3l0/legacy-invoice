<?php

declare (strict_types = 1);

namespace L3l0Labs\Adapters\Doctrine\Accounting\Invoice;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use L3l0Labs\Accounting\Invoice\Item;
use L3l0Labs\Accounting\Invoice\Period;
use L3l0Labs\Accounting\Invoice\VatIdNumber;
use L3l0Labs\Accounting\InvoiceViewRegistry as InvoiceViewRegistryInterface;
use L3l0Labs\Accounting\View;

final class InvoiceViewRegistry implements InvoiceViewRegistryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $toVatNumber
     * @return View\Invoice[]
     */
    public function incoming(VatIdNumber $toVatNumber) : array
    {
        $results = $this
            ->connection
            ->fetchAll(
                'SELECT * FROM invoices WHERE buyer_vat_number_number = :vat',
                ['vat' => (string) $toVatNumber]
            );

        return $this->hydrateInvoices($results);
    }

    /**
     * @param $fromVatNumber
     * @return View\Invoice[]
     */
    public function outgoing(VatIdNumber $fromVatNumber) : array
    {
        $results = $this
            ->connection
            ->fetchAll(
                'SELECT * FROM invoices WHERE seller_vat_number_number = :vat',
                ['vat' => (string) $fromVatNumber]
            );

        return $this->hydrateInvoices($results);
    }

    /**
     * @param array $results
     * @return array
     */
    protected function hydrateInvoices(array $results) : array
    {
        return array_map(
            function (array $result) {
                $items = array_map(
                    function (array $item) {
                        return new Item(
                            $item['name'],
                            $item['quantity'],
                            (float) $item['netPrice'],
                            $item['vatRate'],
                            $item['unit']
                        );
                    },
                    json_decode($result['items'], true)
                );
                $grossPrices = array_map(
                    function (Item $item) {
                        return $item->getGrossPrice();
                    },
                    $items
                );

                return new View\Invoice(
                    $result['number'],
                    $result['seller_name'],
                    $result['seller_address'],
                    new VatIdNumber($result['seller_vat_number_number']),
                    new DateTimeImmutable($result['sell_date']),
                    new Period(new \DateTimeImmutable($result['period_from']),
                        new \DateTimeImmutable($result['period_from'])),
                    $result['buyer_name'],
                    $result['buyer_address'],
                    new VatIdNumber($result['buyer_vat_number_number']),
                    $result['additional_text'] ?? '',
                    array_sum($grossPrices),
                    $items
                );
            },
            $results
        );
    }
}