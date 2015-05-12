<?php

if (!isset($_GET['invoice_id'])) {
    die('Page not found');
}

$stmt = $connection->prepare('SELECT * FROM invoices WHERE user_id = :user_id AND id = :id');
$stmt->execute(['user_id' => $_SESSION['loggedInUser']['id'], 'id' => $_GET['invoice_id']]);
$invoice = $stmt->fetch();

$stmt = $connection->prepare('SELECT * FROM invoice_items WHERE invoice_id = :invoice_id');
$stmt->execute(['invoice_id' => $_GET['invoice_id']]);
$items = $stmt->fetchAll();

if ($_GET['page'] === 'invoice-edit' && $_POST) {
    editInvoice($invoice['id']);
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1>Edit invoice </h1>
        <ol class="breadcrumb">
            <li><a href="/index.php?page=dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/index.php?page=invoices"><i class="fa fa-list"></i> Invoices</a></li>
            <li class="active"><i class="fa fa-file-text"></i> Edit invoice</li>
        </ol>
        <?php if (isset($_GET['successMessage'])): ?>
            <div class="alert alert-dismissable alert-success">
                <button class="close" data-dismiss="alert" type="button"></button>
                <?php echo $_GET['successMessage']; ?>
            </div>
        <?php endif ?>
        <a class="btn btn-warning" href="/index.php?page=invoice-delete&invoice_id=<?php echo $invoice['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
        <form role="form" action="/index.php?page=invoice-edit&invoice_id=<?php echo $_GET['invoice_id'] ?>" method="POST">
            <div class="col-lg-6">
                <h2>Seller</h2>
                <fieldset>
                    <div class="form-group <?php if (isset($invoiceFormErrors['seller_name'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['seller_name'])): ?>
                            <label class="control-label" for="seller-name"><?php echo $invoiceFormErrors['seller_name'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="seller-name">Seller name</label>
                        <input class="form-control" placeholder="Seller name" name="seller_name" type="text" id="seller-name"
                               value="<?php if (isset($_POST['seller_name'])) echo htmlspecialchars($_POST['seller_name']); else echo htmlspecialchars($invoice['seller_name']); ?>" />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['seller_address'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['seller_address'])): ?>
                            <label class="control-label" for="seller-address"><?php echo $invoiceFormErrors['seller_address'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="seller-name">Seller address</label>
                        <input class="form-control" placeholder="Seller address" name="seller_address" type="text" id="seller-address"
                            value="<?php if (isset($_POST['seller_address'])) echo htmlspecialchars($_POST['seller_address']); else echo htmlspecialchars($invoice['seller_address']); ?>" />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['seller_vat_number'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['seller_vat_number'])): ?>
                            <label class="control-label" for="seller-vat-number"><?php echo $invoiceFormErrors['seller_vat_number'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="seller-vat-number">Seller vat number</label>
                        <input class="form-control" placeholder="Seller vat number" name="seller_vat_number" type="text" id="seller-vat-number"
                            value="<?php if (isset($_POST['seller_vat_number'])) echo htmlspecialchars($_POST['seller_vat_number']); else echo htmlspecialchars($invoice['seller_vat_number']); ?>" />
                    </div>
                </fieldset>
                <h2>Buyer</h2>
                <fieldset>
                    <div class="form-group <?php if (isset($invoiceFormErrors['buyer_name'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['buyer_name'])): ?>
                            <label class="control-label" for="buyer-name"><?php echo $invoiceFormErrors['buyer_name'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="buyer-name">Buyer name</label>
                        <input class="form-control" placeholder="Buyer name" name="buyer_name" type="text" id="buyer-name"
                            value="<?php if (isset($_POST['buyer_name'])) echo $_POST['buyer_name']; else echo htmlspecialchars($invoice['buyer_name']); ?>" />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['buyer_address'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['buyer_address'])): ?>
                            <label class="control-label" for="buyer-address"><?php echo $invoiceFormErrors['buyer_address'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="buyer-name">Buyer address</label>
                        <input class="form-control" placeholder="Buyer address" name="buyer_address" type="text" id="buyer-address"
                            value="<?php if (isset($_POST['buyer_address'])) echo htmlspecialchars($_POST['buyer_address']); else echo htmlspecialchars($invoice['buyer_address']); ?>" />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['buyer_vat_number'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['buyer_vat_number'])): ?>
                            <label class="control-label" for="buyer-vat-number"><?php echo $invoiceFormErrors['buyer_vat_number'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="buyer-vat-number">Buyer vat number</label>
                        <input class="form-control" placeholder="Buyer vat number" name="buyer_vat_number" type="text" id="buyer-vat-number"
                            value="<?php if (isset($_POST['buyer_vat_number'])) echo htmlspecialchars($_POST['buyer_vat_number']); else echo htmlspecialchars($invoice['buyer_vat_number']); ?>" />
                    </div>
                </fieldset>
            </div>
            <div class="col-lg-6">
                <fieldset>
                    <div class="form-group <?php if (isset($invoiceFormErrors['invoice_number'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['invoice_number'])): ?>
                            <label class="control-label" for="invoice-number"><?php echo $invoiceFormErrors['invoice_number'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="invoice-number">Invoice number</label>
                        <input class="form-control" placeholder="01/<?php echo date('m') ?>/<?php echo date('Y') ?>" name="invoice_number" type="text" id="invoice-number"
                            value="<?php if (isset($_POST['invoice_number'])) echo htmlspecialchars($_POST['invoice_number']); else echo htmlspecialchars($invoice['invoice_number']); ?>" />
                    </div>
                </fieldset>
                <h2>Invoice dates</h2>
                <fieldset>
                    <div class="form-group <?php if (isset($invoiceFormErrors['date_of_invoice'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['date_of_invoice'])): ?>
                            <label class="control-label" for="date-of-invoice"><?php echo $invoiceFormErrors['date_of_invoice'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="date-of-invoice">Date of invoice</label>
                        <input class="form-control date" placeholder="example: <?php echo date('Y-m-d') ?>" name="date_of_invoice" type="date" id="date-of-invoice"
                            value="<?php if (isset($_POST['date_of_invoice'])) echo htmlspecialchars($_POST['date_of_invoice']); else echo date('Y-m-d', strtotime($invoice['date_of_invoice'])); ?>" />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['maturity_date'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['maturity_date'])): ?>
                            <label class="control-label" for="maturity-date"><?php echo $invoiceFormErrors['maturity_date'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="maturity-date">Maturity date</label>
                        <input class="form-control date" placeholder="example: <?php echo date('Y-m-d', strtotime('+7days')) ?>" name="maturity_date" type="date" id="maturity-date"
                            value="<?php if (isset($_POST['maturity_date'])) echo $_POST['maturity_date']; else echo date('Y-m-d', strtotime($invoice['maturity_date'])); ?>" />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['sell_date'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['sell_date'])): ?>
                            <label class="control-label" for="sell-date"><?php echo $invoiceFormErrors['sell_date'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="sell-date">Sell date</label>
                        <input class="form-control date" placeholder="example: <?php echo date('Y-m-d') ?>" name="sell_date" type="date" id="sell-date"
                            value="<?php if (isset($_POST['sell_date'])) echo $_POST['sell_date']; else echo date('Y-m-d', strtotime($invoice['sell_date'])); ?>" />
                    </div>
                    <!-- Change this to a button or input when using this as a form -->
                </fieldset>
                <h2>Additional info</h2>
                <fieldset>
                    <div class="form-group <?php if (isset($invoiceFormErrors['additional_info'])): ?>has-error<?php endif ?>">
                        <textarea class="form-control" name="additional_info"><?php if (isset($_POST['additional_info'])) echo $_POST['additional_info']; else echo $invoice['additional_info']; ?></textarea>
                    </div>
                </fieldset>
            </div>
            <div class="col-lg-12 form_group<?php if (isset($invoiceFormErrors['invoice_item'])): ?> has-error<?php endif ?>">
                <?php if (isset($invoiceFormErrors['invoice_item'])): ?>
                    <label class="control-label" for="invoice-item"><?php echo $invoiceFormErrors['invoice_item'] ?></label><br/>
                <?php endif ?>
                <ul id="invoice-item" class="items">
                    <?php if (count($items) > 0): ?>
                        <?php $i = 1; ?>
                        <?php foreach ($items as $value): ?>
                            <li class="item">
                                <div class="form-group">
                                    <label>Invoice item <?php echo $i ?></label>
                                    <input type="hidden"  name=invoice_item[<?php echo $value['id'] ?>][id]" value="<?php echo $value['id'] ?>" />
                                    <input class="from-control" placeholder="Name" name="invoice_item[<?php echo $value['id'] ?>][name]" type="text" value="<?php if(isset($_POST['invoice_item'][$value['id']]['name'])) echo $_POST['invoice_item'][$value['id']]['name']; else echo $value['name']; ?>" />
                                    <input class="from-control" placeholder="Quantity" name="invoice_item[<?php echo $value['id'] ?>][quantity]" type="text" value="<?php if(isset($_POST['invoice_item'][$value['id']]['quantity'])) echo $_POST['invoice_item'][$value['id']]['quantity']; else echo $value['quantity']; ?>" />
                                    <input class="from-control" placeholder="Unit" name="invoice_item[<?php echo $value['id'] ?>][unit]" type="text" value="<?php if(isset($_POST['invoice_item'][$value['id']]['unit'])) echo $_POST['invoice_item'][$value['id']]['unit']; else echo $value['unit']; ?>" />
                                    <input class="from-control" placeholder="Net price" name="invoice_item[<?php echo $value['id'] ?>][net_price]" type="text" value="<?php if(isset($_POST['invoice_item'][$value['id']]['net_price'])) echo $_POST['invoice_item'][$value['id']]['net_price']; else echo $value['net_price']; ?>" />
                                    <input class="from-control" placeholder="Vat" name="invoice_item[<?php echo $value['id'] ?>][vat]" type="text" value="<?php if(isset($_POST['invoice_item'][$value['id']]['vat'])) echo $_POST['invoice_item'][$value['id']]['vat']; else echo $value['vat']; ?>" />
                                </div>
                            </li>
                            <?php $i++; ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
            <div class="col-lg-12">
                <fieldset>
                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Update" />
                </fieldset>
            </div>
        </form>
    </div>
</div>
