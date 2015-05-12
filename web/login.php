<?php session_start(); ?>

<?php require_once 'config.php'; ?>
<?php require_once 'functions.php'; ?>

<?php if ($_POST): ?>
    <?php login(); ?>
<?php endif ?>

<?php require_once 'header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php if (isset($_GET['successRegister'])): ?>You just registered successfully <?php endif ?>Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="/login.php" method="POST">
                        <fieldset>
                            <div class="form-group <?php if (isset($loginErrors['email'])): ?>has-error<?php endif ?>">
                                <?php if (isset($loginErrors['email'])): ?>
                                    <label class="control-label" for="login-email"><?php echo $loginErrors['email'] ?></label>
                                <?php endif ?>
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus id="login-email">
                            </div>
                            <div class="form-group <?php if (isset($loginErrors['password'])): ?>has-error<?php endif ?>">
                                <?php if (isset($loginErrors['password'])): ?>
                                    <label class="control-label" for="login-email"><?php echo $loginErrors['password'] ?></label>
                                <?php endif ?>
                                <input class="form-control" placeholder="Password" name="password" type="password" value="" id="login-password">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Login" />

                            <p>You don't have account? Please <a href="/register.php">register account</a>.</p>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
