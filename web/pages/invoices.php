<?php
    $stmt = $connection->prepare('SELECT id, invoice_number, buyer_name, sell_date, date_of_invoice, total_price FROM invoices WHERE user_id = :user_id');
    $stmt->execute(['user_id' => $_SESSION['loggedInUser']['id']]);

    $invoices = $stmt->fetchAll();
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
                            <td><a href="/index.php?page=invoice-edit&invoice_id=<?php echo $invoice['id'] ?>"><?php echo $invoice['invoice_number'] ?></a></td>
                            <td><?php echo date('Y-m-d', strtotime($invoice['sell_date'])) ?></td>
                            <td><?php echo date('Y-m-d', strtotime($invoice['date_of_invoice'])) ?></td>
                            <td><?php echo $invoice['buyer_name'] ?></td>
                            <td><?php echo $invoice['total_price'] ?> PLN</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <a href="/index.php?page=invoice-add" class="btn btn-default">New invoice</a>
    </div>
</div><!-- /.row -->

