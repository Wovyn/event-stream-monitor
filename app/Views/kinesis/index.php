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
            <div class="col-md-12">
                <!-- start: DYNAMIC TABLE PANEL -->
                <table class="dt-table table table-striped table-bordered table-hover table-full-width" id="kinesis-table">
                    <thead>
                        <tr>
                            <th>Region</th>
                            <th>Data Stream Name</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- sample data -->
                        <tr>
                            <td>Sample Region</td>
                            <td>Sample Name</td>
                            <td>Sample State</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Sample Region</td>
                            <td>Sample Name</td>
                            <td>Sample State</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>Sample Region</td>
                            <td>Sample Name</td>
                            <td>Sample State</td>
                            <td>3</td>
                        </tr>
                    </tbody>
                </table>
                <!-- end: DYNAMIC TABLE PANEL -->
            </div>
        </div>
    </div>
</div>

<?php echo view('includes/footer') ?>