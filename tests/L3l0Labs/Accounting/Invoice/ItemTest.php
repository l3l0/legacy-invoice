<?php

namespace Tests\L3l0Labs\Accounting;

use L3l0Labs\Accounting\Invoice\Item;

class ItemTest extends \PhpUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCalculateGrossPrice()
    {
        $item = new Item('Robienie internetów', 2, 2000, 23, 'usługa');
        $this->assertEquals(4920, $item->getGrossPrice());

        $item = new Item('Robienie internetów', 1, 1000, 23, 'godzina');
        $this->assertEquals(1230, $item->getGrossPrice());
    }
}