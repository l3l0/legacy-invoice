<?php

$stmt = $connection->prepare('SELECT * FROM users WHERE id = :id');
$stmt->execute(['id' => $_SESSION['loggedInUser']['id']]);
$user = $stmt->fetch();

if ($_GET['page'] === 'invoice-add' && $_POST) {
    createInvoice();
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1>Create new invoice</h1>
        <ol class="breadcrumb">
            <li><a href="/index.php?page=dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/index.php?page=invoices"><i class="fa fa-list"></i> Invoices</a></li>
            <li class="active"><i class="fa fa-file-text"></i> Create new invoice</li>
        </ol>
        <form role="form" action="/index.php?page=invoice-add" method="POST">
            <div class="col-lg-6">
                <h2>Seller</h2>
                <fieldset>
                    <div class="form-group <?php if (isset($invoiceFormErrors['seller_name'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['seller_name'])): ?>
                            <label class="control-label" for="seller-name"><?php echo $invoiceFormErrors['seller_name'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="seller-name">Seller name</label>
                        <input class="form-control" placeholder="Seller name" name="seller_name" type="text" id="seller-name"
                               value="<?php if (isset($_POST['seller_name'])) echo $_POST['seller_name']; else echo $user['name']; ?>" />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['seller_address'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['seller_address'])): ?>
                            <label class="control-label" for="seller-address"><?php echo $invoiceFormErrors['seller_address'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="seller-name">Seller address</label>
                        <input class="form-control" placeholder="Seller address" name="seller_address" type="text" id="seller-address"
                            value="<?php if (isset($_POST['seller_address'])) echo $_POST['seller_address']; else echo $user['address']; ?>" />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['seller_vat_number'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['seller_vat_number'])): ?>
                            <label class="control-label" for="seller-vat-number"><?php echo $invoiceFormErrors['seller_vat_number'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="seller-vat-number">Seller vat number</label>
                        <input class="form-control" placeholder="Seller vat number" name="seller_vat_number" type="text" id="seller-vat-number"
                            value="<?php if (isset($_POST['seller_vat_number'])) echo $_POST['seller_vat_number']; else echo $user['vat']; ?>" />
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
                               <?php if (isset($_POST['buyer_name'])):?>value="<?php echo $_POST['buyer_name'] ?>"<?php endif ?> />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['buyer_address'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['buyer_address'])): ?>
                            <label class="control-label" for="buyer-address"><?php echo $invoiceFormErrors['buyer_address'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="buyer-name">Buyer address</label>
                        <input class="form-control" placeholder="Buyer address" name="buyer_address" type="text" id="buyer-address"
                               <?php if (isset($_POST['buyer_address'])):?>value="<?php echo $_POST['buyer_address'] ?>"<?php endif ?> />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['buyer_vat_number'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['buyer_vat_number'])): ?>
                            <label class="control-label" for="buyer-vat-number"><?php echo $invoiceFormErrors['buyer_vat_number'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="buyer-var-number">Buyer vat number</label>
                        <input class="form-control" placeholder="Buyer vat number" name="buyer_vat_number" type="text" id="buyer-vat-number"
                                <?php if (isset($_POST['buyer_vat_number'])):?>value="<?php echo $_POST['buyer_vat_number'] ?>"<?php endif ?> />
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
                        <input class="form-control" placeholder="01/<?php echo date('m') ?>/<?php echo date('Y') ?>" name="invoice_number" type="text" autofocus id="invoice-number"
                               <?php if (isset($_POST['invoice_number'])):?>value="<?php echo $_POST['invoice_number'] ?>"<?php endif ?> />
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
                            <?php if (isset($_POST['date_of_invoice'])):?>value="<?php echo $_POST['date_of_invoice'] ?>"<?php endif ?> />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['maturity_date'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['maturity_date'])): ?>
                            <label class="control-label" for="maturity-date"><?php echo $invoiceFormErrors['maturity_date'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="maturity-date">Maturity date</label>
                        <input class="form-control date" placeholder="example: <?php echo date('Y-m-d', strtotime('+7days')) ?>" name="maturity_date" type="date" id="maturity-date"
                               <?php if (isset($_POST['maturity_date'])):?>value="<?php echo $_POST['maturity_date'] ?>"<?php endif ?> />
                    </div>
                    <div class="form-group <?php if (isset($invoiceFormErrors['sell_date'])): ?>has-error<?php endif ?>">
                        <?php if (isset($invoiceFormErrors['sell_date'])): ?>
                            <label class="control-label" for="sell-date"><?php echo $invoiceFormErrors['sell_date'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="sell-date">Sell date</label>
                        <input class="form-control date" placeholder="example: <?php echo date('Y-m-d') ?>" name="sell_date" type="date" id="sell-date"
                               <?php if (isset($_POST['sell_date'])):?>value="<?php echo $_POST['sell_date'] ?>"<?php endif ?> />
                    </div>
                    <!-- Change this to a button or input when using this as a form -->
                </fieldset>
                <h2>Additional info</h2>
                <fieldset>
                    <div class="form-group <?php if (isset($invoiceFormErrors['additional_info'])): ?>has-error<?php endif ?>">
                        <textarea class="form-control" name="additional_info"><?php if (isset($_POST['additional_info'])):?><?php echo $_POST['additional_info'] ?><?php endif ?></textarea>
                    </div>
                </fieldset>
            </div>
            <div class="col-lg-12 form_group<?php if (isset($invoiceFormErrors['invoice_item'])): ?> has-error<?php endif ?>">
                <?php if (isset($invoiceFormErrors['invoice_item'])): ?>
                    <label class="control-label" for="invoice-item"><?php echo $invoiceFormErrors['invoice_item'] ?></label><br/>
                <?php endif ?>
                <ul id="invoice-item" class="items" data-prototype="&lt;div class=&quot;form-group&quot;&gt;&lt;label&gt;Invoice item __name__ &lt;/label&gt;
                &lt;input class&quot;form-control&quot; placeholder=&quot;Name&quot; name=&quot;invoice_item[__name__][name]&quot; type=&quot;text&quot; /&gt;
                &lt;input class&quot;form-control&quot; placeholder=&quot;Quantity&quot; name=&quot;invoice_item[__name__][quantity]&quot; type=&quot;text&quot; /&gt;
                &lt;input class&quot;form-control&quot; placeholder=&quot;Unit&quot; name=&quot;invoice_item[__name__][unit]&quot; type=&quot;text&quot; /&gt;
                &lt;input class&quot;form-control&quot; placeholder=&quot;Net price&quot; name=&quot;invoice_item[__name__][net_price]&quot; type=&quot;text&quot; /&gt;
                &lt;input class&quot;form-control&quot; placeholder=&quot;Vat&quot; name=&quot;invoice_item[__name__][vat]&quot; type=&quot;text&quot; /&gt;
                &lt;/div&gt;">
                    <?php if (isset($_POST['invoice_item']) && count($_POST['invoice_item']) > 0): ?>
                        <?php foreach ($_POST['invoice_item'] as $key => $value): ?>
                            <li class="item">
                                <div class="form-group">
                                    <label>Invoice <?php echo $key ?></label>
                                    <input class="from-control" placeholder="Name" name="invoice_item[<?php echo $key ?>][name]" type="text" value="<?php echo $value['name'] ?>" />
                                    <input class="from-control" placeholder="Quantity" name="invoice_item[<?php echo $key ?>][quantity]" type="text" value="<?php echo $value['quantity'] ?>" />
                                    <input class="from-control" placeholder="Unit" name="invoice_item[<?php echo $key ?>][unit]" type="text" value="<?php echo $value['unit'] ?>" />
                                    <input class="from-control" placeholder="Net price" name="invoice_item[<?php echo $key ?>][net_price]" type="text" value="<?php echo $value['net_price'] ?>" />
                                    <input class="from-control" placeholder="Vat" name="invoice_item[<?php echo $key ?>][vat]" type="text" value="<?php echo $value['vat'] ?>" />
                                </div>
                            </li>
                        <?php endforeach ?>
                    <?php endif ?>
                </ul>
            </div>
            <div class="col-lg-12">
                <fieldset>
                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Create" />
                </fieldset>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function addTagForm($collectionHolder, $newLinkLi) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index + 1);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('<li class="item"></li>').append(newForm);
        $newLinkLi.before($newFormLi);
    }

    var $collectionHolder;

    // setup an "add a tag" link
    var $addTagLink = $('<a href="#" class="add_tag_link">Add a invoice item</a>');
    var $newLinkLi = $('<li></li>').append($addTagLink);

    jQuery(document).ready(function() {
        // Get the ul that holds the collection of tags
        $collectionHolder = $('ul.items');

        // add the "add a tag" anchor and li to the tags ul
        $collectionHolder.append($newLinkLi);

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $collectionHolder.data('index', $collectionHolder.find('li.item').length);

        $addTagLink.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // add a new tag form (see next code block)
            addTagForm($collectionHolder, $newLinkLi);
        });
    });

</script>
