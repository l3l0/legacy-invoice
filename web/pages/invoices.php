<?php

use L3l0Labs\Accounting\Invoice\VatIdNumber;

global $invoiceRegistry;

$invoices = $invoiceRegistry->outgoing(new VatIdNumber($_SESSION['loggedInUser']['vat']));
?>

<div class="row">
    <div class="col-lg-12">
        <h1>Invoice List</h1>
        <ol class="breadcrumb">
            <li><a href="/index.php?page=dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><i class="fa fa-list"></i> Invoice</li>
        </ol>

        <?php if (isset($_GET['successMessage'])): ?>
        <div class="alert alert-dismissable alert-success">
            <button class="close" data-dismiss="alert" type="button"></button>
            <?php echo $_GET['successMessage']; ?>
        </div>
        <?php endif ?>
        <?php if (isset($_GET['errorMessage'])): ?>
            <div class="alert alert-dismissable alert-danger">
                <button class="close" data-dismiss="alert" type="button"></button>
                <?php echo $_GET['errorMessage']; ?>
            </div>
        <?php endif ?>
        <a href="/index.php?page=invoice-add" class="btn btn-default">New invoice</a><br/><br/>
        <div class="table-responsive">
            <table class="table table-bordered table-hover tablesorter">
                <thead>
                <tr>
                    <th>Invoice number <i class="fa fa-sort"></i></th>
                    <th>Sell Date <i class="fa fa-sort"></i></th>
                    <th>Creation Date<i class="fa fa-sort"></i></th>
                    <th>Buyer <i class="fa fa-sort"></i></th>
                    <th>Total price <i class="fa fa-sort"></i></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                        <tr>
                            <td><?php echo $invoice->number ?></a></td>
                            <td><?php echo $invoice->sellDate->format('Y-m-d') ?></td>
                            <td><?php echo $invoice->period->getFrom()->format('Y-m-d') ?></td>
                            <td><?php echo $invoice->buyerName ?></td>
                            <td><?php echo $invoice->totalPrice ?> PLN</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <a href="/index.php?page=invoice-add" class="btn btn-default">New invoice</a>
    </div>
</div><!-- /.row -->

