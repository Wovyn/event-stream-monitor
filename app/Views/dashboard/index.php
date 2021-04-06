<?php echo view('includes/header') ?>

<div class="main-content">
    <div class="container">
        <!-- start: PAGE HEADER -->
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-home-3"></i>
                        <a href="#">
                            Home
                        </a>
                    </li>
                    <li class="active">
                        <?php echo $meta['header']; ?>
                    </li>
                    <li class="search-box">
                        <form class="sidebar-search">
                            <div class="form-group">
                                <input type="text" placeholder="Start Searching...">
                                <button class="submit">
                                    <i class="clip-search-3"></i>
                                </button>
                            </div>
                        </form>
                    </li>
                </ol>
                <div class="page-header">
                    <?php echo view('includes/page_header') ?>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <!-- end: PAGE HEADER -->
        <!-- start: PAGE CONTENT -->
        <div class="row">
            <div class="col-sm-4">
                <div class="core-box">
                    <div class="heading">
                        <i class="clip-barcode circle-icon circle-bricky"></i>
                        <h2>Manage Event Stream Sinks</h2>
                    </div>
                    <div class="content">
                        This is where you can create a Sink Instance, validate the Sink Instance, and also create, update, and delete subscriptions.
                    </div>
                    <a class="view-more" href="/eventstreams">
                        View More <i class="clip-arrow-right-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="core-box">
                    <div class="heading">
                        <i class="clip-windy circle-icon circle-teal"></i>
                        <h2>Manage Kinesis Data Sinks</h2>
                    </div>
                    <div class="content">
                        This is where you can create, update, and delete AWS Kinesis Data Streams.  These are currently the primary Event Stream Sink types.
                    </div>
                    <a class="view-more" href="/kinesis">
                        View More <i class="clip-arrow-right-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="core-box">
                    <div class="heading">
                        <i class="clip-database circle-icon circle-green"></i>
                        <h2>Manage Consumers</h2>
                    </div>
                    <div class="content">
                        This is where you will be able to create, update, and delete AWS Kinesis consumers.  This will start with Elasticsearch instances.
                    </div>
                    <a class="view-more" href="#">
                        View More <i class="clip-arrow-right-2"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="clip-stats"></i> Streams
                        <div class="panel-tools">
                            <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                            </a>
                            <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <a class="btn btn-xs btn-link panel-refresh" href="#">
                                <i class="fa fa-refresh"></i>
                            </a>
                            <a class="btn btn-xs btn-link panel-close" href="#">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <!-- d3-hierarchy -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>

<?php echo view('includes/footer') ?>