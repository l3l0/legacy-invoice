<?php

$stmt = $connection->prepare('SELECT * FROM users WHERE id = :id');
$stmt->execute(['id' => $_SESSION['loggedInUser']['id']]);
$user = $stmt->fetch();

if ($_GET['page'] === 'user-profile' && $_POST) {
    editProfile();
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1>Edit invoice </h1>
        <ol class="breadcrumb">
            <li><a href="/index.php?page=dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><i class="fa fa-user"></i> User profile</li>
        </ol>
        <?php if (isset($_GET['successMessage'])): ?>
            <div class="alert alert-dismissable alert-success">
                <button class="close" data-dismiss="alert" type="button"></button>
                <?php echo $_GET['successMessage']; ?>
            </div>
        <?php endif ?>
        <form role="form" action="/index.php?page=user-profile" method="POST">
            <div class="col-lg-12">
                <fieldset>
                    <div class="form-group">
                        <label class="control-label"><?php echo $user['email'] ?></label>
                    </div>
                    <div class="form-group <?php if (isset($profileFormErrors['name'])): ?>has-error<?php endif ?>">
                        <?php if (isset($profileFormErrors['name'])): ?>
                            <label class="control-label" for="name"><?php echo $profileFormErrors['name'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="name">Full name (inc. company name)</label>
                        <input class="form-control" placeholder="name" name="name" type="text" id="name"
                               value="<?php if (isset($_POST['name'])) echo htmlspecialchars($_POST['name']); else echo htmlspecialchars($user['name']); ?>" />
                    </div>
                    <div class="form-group <?php if (isset($profileFormErrors['vat'])): ?>has-error<?php endif ?>">
                        <?php if (isset($profileFormErrors['vat'])): ?>
                            <label class="control-label" for="vat"><?php echo $profileFormErrors['vat'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="vat">VAT number</label>
                        <input class="form-control" placeholder="VAT" name="vat" type="text" id="vat"
                               value="<?php if (isset($_POST['vat'])) echo htmlspecialchars($_POST['vat']); else echo htmlspecialchars($user['vat']); ?>" />
                    </div>
                    <div class="form-group <?php if (isset($profileFormErrors['address'])): ?>has-error<?php endif ?>">
                        <?php if (isset($profileFormErrors['address'])): ?>
                            <label class="control-label" for="address"><?php echo $profileFormErrors['address'] ?></label><br/>
                        <?php endif ?>
                        <label class="control-label" for="address">Address</label>
                        <input class="form-control" placeholder="address" name="address" type="text" id="address"
                               value="<?php if (isset($_POST['address'])) echo htmlspecialchars($_POST['address']); else echo htmlspecialchars($user['address']); ?>" />
                    </div>
                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Update" />
                </fieldset>
            </div>
        </form>
    </div>
</div>
