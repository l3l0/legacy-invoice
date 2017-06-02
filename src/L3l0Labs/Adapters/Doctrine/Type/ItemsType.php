<?php

declare (strict_types = 1);

namespace L3l0Labs\Adapters\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonArrayType;
use L3l0Labs\Accounting\Invoice\Item;

final class ItemsType extends JsonArrayType
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return 'items';
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return Item[]
     */
    public function convertToPhpValue($value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return [];
        }
        $data = json_decode($value, true);
        if (!$data) {
            return [];
        }

        return array_map(function (array $item) {
            return new Item(
                $item['name'],
                $item['quantity'],
                (float) $item['netPrice'],
                $item['vatRate'],
                $item['unit']
            );
        }, $data);
    }
    /**
     * @param Item[]|null $value
     * @param AbstractPlatform $platform
     * @return string
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        }
        $data = [];
        foreach ($value as $item) {
            if (!$item instanceof Item) {
                throw ConversionException::conversionFailed($value, $this->getName());
            }
            $data[] = [
                'name' => $item->getName(),
                'netPrice' => (string) $item->getNetPrice(),
                'quantity' => $item->getQuantity(),
                'unit' => $item->getUnit(),
                'vatRate' => $item->getVatRate()
            ];
        }
        return json_encode($data);
    }

    /**
     * @param AbstractPlatform $platform
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }
}