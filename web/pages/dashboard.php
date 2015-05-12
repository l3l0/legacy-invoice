<div class="row">
    <div class="col-lg-12">
        <h1>Dashboard <small>Statistics Overview</small></h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
        </ol>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Welcome to Invoice by <a class="alert-link" href="http://cocoders.com">cocoders</a>! Legacy application to rewrite. Written in old plain PHP ;)
        </div>
    </div>
</div><!-- /.row -->

<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">456</p>
                        <p class="announcement-text">New Mentions!</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <div class="col-xs-6">
                            View Mentions
                        </div>
                        <div class="col-xs-6 text-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-check fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">12</p>
                        <p class="announcement-text">To-Do Items</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <div class="col-xs-6">
                            Complete Tasks
                        </div>
                        <div class="col-xs-6 text-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">18</p>
                        <p class="announcement-text">Crawl Errors</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <div class="col-xs-6">
                            Fix Issues
                        </div>
                        <div class="col-xs-6 text-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">56</p>
                        <p class="announcement-text">New Orders!</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <div class="col-xs-6">
                            Complete Orders
                        </div>
                        <div class="col-xs-6 text-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div><!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> New invoices</h3>
            </div>
            <div class="panel-body">
                <div id="invoice-chart"></div>
                <div class="text-right">
                    <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    Morris.Donut({
        element: 'invoice-chart',
        data: [
            {label: "Income", value: 42.7},
            {label: "Outcome", value: 57.3},
        ],
        formatter: function (y) { return y + "%" ;}
    });
</script>