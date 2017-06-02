<?php

declare (strict_types = 1);

namespace App\Controller;

use L3l0Labs\Accounting\Invoice\VatIdNumber;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class InvoiceController extends Controller
{
    public function outgoing(Request $request) : Response
    {
        $invoices = $this->get('l3l0labs.accounting.view.invoice')->outgoing(new VatIdNumber((string) $request->get('vatIdNumber')));

        return $this->render('invoice/outgoing.html.twig', ['invoices' => $invoices]);
    }
}