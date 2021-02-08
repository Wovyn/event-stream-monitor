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
                        <a href="/">Home</a>
                    </li>
                    <li class="active">
                        Kinesis
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
                    <div class="toolbar">
                        <a class="btn btn-primary add-stream-btn" href="/kinesis/add">Create Kinesis Data Stream</a>
                    </div>

                    <?php echo view('includes/page_header') ?>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <!-- end: PAGE HEADER -->
        <!-- start: PAGE CONTENT -->
        <div class="row">
            <div class="col-md-12">
                <!-- start: DYNAMIC TABLE PANEL -->
                <table class="dt-table table table-striped table-bordered table-hover table-full-width" id="kinesis-table">
                    <thead>
                        <tr>
                            <th>Region</th>
                            <th>Name</th>
                            <th>Shards</th>
                            <th>Created</th>
                            <th>Last Updated</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="dataTables_empty" colspan="6">Loading data from database.</td>
                        </tr>
                    </tbody>
                </table>
                <!-- end: DYNAMIC TABLE PANEL -->
            </div>
        </div>
    </div>
</div>

<?php echo view('includes/footer') ?>