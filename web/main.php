
<div id="wrapper">

<!-- Sidebar -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Invoice</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <?php foreach ($pages as $page => $pageInfo): ?>
                <?php if($pageInfo['menu']): ?>
                    <li class="<?php if ($_GET['page'] == $page): ?>active<?php endif ?>">
                        <a href="/index.php?page=<?php echo $page ?>"><i class="fa <?php echo $pageInfo['icon'] ?>"></i> <?php echo $pageInfo['name']; ?></a>
                    </li>
                <?php endif ?>
            <?php endforeach ?>
        </ul>

        <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['loggedInUser']['email'] ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="/index.php?page=user-profile"><i class="fa fa-user"></i> Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="/logout.php"><i class="fa fa-power-off"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">
    <?php if (in_array($_GET['page'], array_keys($pages)) && file_exists('pages/'.$_GET['page'].'.php')): ?>
        <?php require_once 'pages/'.$_GET['page'].'.php'; ?>
    <?php endif ?>
</div><!-- /#page-wrapper -->

</div><!-- /#wrapper -->
