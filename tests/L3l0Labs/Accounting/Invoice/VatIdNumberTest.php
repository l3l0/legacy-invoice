<?php

namespace Tests\L3l0Labs\Accounting;

use L3l0Labs\Accounting\Invoice\VatIdNumber;

class VatIdNumberTest extends \PhpUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNormalizeDifferentVatNumbers()
    {
        $vat = new VatIdNumber(' 725-18-01-126');
        $this->assertEquals('7251801126', (string) $vat);

        $vat = new VatIdNumber('725-18-01-126');
        $this->assertEquals('7251801126', (string) $vat);

        $vat = new VatIdNumber('725 180 1126');
        $this->assertEquals('7251801126', (string) $vat);
    }
}