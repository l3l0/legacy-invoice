<?php ob_start(); ?>
<?php require_once 'config.php'; ?>
<?php require_once 'functions.php'; ?>
<?php
if ($_POST) {
    register();
}
?>
<?php require_once 'header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Register</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="/register.php" method="POST">
                        <fieldset>
                            <div class="form-group <?php if (isset($registerErrors['email'])): ?>has-error<?php endif ?>">
                                <?php if (isset($registerErrors['email'])): ?>
                                    <label class="control-label" for="register-email"><?php echo $registerErrors['email'] ?></label>
                                <?php endif ?>
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus id="register-email">
                            </div>
                            <div class="form-group <?php if (isset($registerErrors['password'])): ?>has-error<?php endif ?>">
                                <?php if (isset($registerErrors['password'])): ?>
                                    <label class="control-label" for="register-password"><?php echo $registerErrors['password'] ?></label>
                                <?php endif ?>
                                <input class="form-control" placeholder="Password" name="password" type="password" value="" id="register-password">
                            </div>
                            <div class="form-group <?php if (isset($registerErrors['vat'])): ?>has-error<?php endif ?>">
                                <?php if (isset($registerErrors['vat'])): ?>
                                    <label class="control-label" for="register-vat"><?php echo $registerErrors['vat'] ?></label>
                                <?php endif ?>
                                <input class="form-control" placeholder="Vat Number" name="vat" type="text" value="" id="register-vat">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Register" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
<?php ob_end_flush(); ?>
