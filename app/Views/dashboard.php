<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <title><?php echo $page_title ?></title>
    <link rel="shortcut icon" href="/assets/images/favicon.png" />
    <!-- start: META -->
    <meta charset="utf-8" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="Responsive Admin Template build with Twitter Bootstrap and jQuery" name="description" />
    <meta content="ClipTheme" name="author" />
    <!-- end: META -->
    <!-- start: MAIN CSS -->
    <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Raleway:400,100,200,300,500,600,700,800,900/" />
    <link type="text/css" rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="/assets/fonts/clip-font.min.css" />
    <link type="text/css" rel="stylesheet" href="/bower_components/iCheck/skins/all.css" />
    <link type="text/css" rel="stylesheet" href="/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" />
    <link type="text/css" rel="stylesheet" href="/bower_components/sweetalert/dist/sweetalert.css" />
    <link type="text/css" rel="stylesheet" href="/assets/css/main.min.css" />
    <link type="text/css" rel="stylesheet" href="/assets/css/main-responsive.min.css" />
    <link type="text/css" rel="stylesheet" media="print" href="/assets/css/print.min.css" />
    <link type="text/css" rel="stylesheet" id="skin_color" href="/assets/css/theme/light.min.css" />

    <!-- end: MAIN CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link href="/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" />
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

    <link type="text/css" rel="stylesheet" href="/assets/css/custom.css" />
</head>

<body>

    <!-- start: HEADER -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <!-- start: TOP NAVIGATION CONTAINER -->
        <div class="container">
            <div class="navbar-header">
                <!-- start: RESPONSIVE MENU TOGGLER -->
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="clip-list-2"></span>
            </button>
                <!-- end: RESPONSIVE MENU TOGGLER -->
                <!-- start: LOGO -->
                <a class="navbar-brand" href="/">
                    <img class="logo" src="/assets/images/logo-1020x220.png" width="1020" height="220" alt="EventStreamMonitor">
                </a>
                <!-- end: LOGO -->
            </div>
            <div class="navbar-tools">
                <!-- start: TOP NAVIGATION MENU -->
                <ul class="nav navbar-right">
                    <!-- start: USER DROPDOWN -->
                    <li class="dropdown current-user">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                            <img src="/assets/images/avatar-1-small.jpg" class="circle-img" alt="">
                            <span class="username">Peter Clark</span>
                            <i class="clip-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="pages_user_profile.html">
                                    <i class="clip-user-2"></i> &nbsp;My Profile
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="/auth/logout">
                                    <i class="clip-exit"></i> &nbsp;Log Out
                                </a>
                            </li>
                        </ul>
                    </li>
                        <!-- end: USER DROPDOWN -->
                </ul>
                <!-- end: TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- end: TOP NAVIGATION CONTAINER -->
    </div>
    <!-- end: HEADER -->
    <!-- start: MAIN CONTAINER -->
    <div class="main-container">
        <div class="navbar-content">
            <!-- start: SIDEBAR -->
            <div class="main-navigation navbar-collapse collapse">
                <!-- start: MAIN MENU TOGGLER BUTTON -->
                <div class="navigation-toggler">
                    <i class="clip-chevron-left"></i>
                    <i class="clip-chevron-right"></i>
                </div>
                <!-- end: MAIN MENU TOGGLER BUTTON -->
                <!-- start: MAIN NAVIGATION MENU -->
                <ul class="main-navigation-menu">
                    <li>
                        <!--active open-->
                        <a href="index.html">
                            <i class="clip-home-3"></i>
                            <span class="title"> Dashboard </span><span class="selected"></span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-screen"></i>
                            <span class="title"> Layouts </span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="layouts_horizontal_menu1.html">
                                    <span class="title"> Horizontal Menu </span>
                                    <span class="badge badge-new">new</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="close-sidebar-left">
                                    <span class="title"> Sidebar Closed </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="set-boxed-layout">
                                    <span class="title"> Boxed Layout </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="set-footer-fixed">
                                    <span class="title"> Footer Fixed </span>
                                </a>
                            </li>
                            <li>
                                <a href="../clip-one-rtl/index.html">
                                    <span class="title"> RTL Version </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="http://www.cliptheme.com/preview/cliponeV2/Frontend/clip-one-template/clip-one/index.html" target="_blank">
                            <i class="clip-cursor"></i>
                            <span class="title"> Frontend Theme </span><span class="selected"></span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-cog-2"></i>
                            <span class="title"> UI Lab </span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="ui_elements.html">
                                    <span class="title"> Elements </span>
                                </a>
                            </li>
                            <li>
                                <a href="ui_buttons.html">
                                    <span class="title"> Buttons &amp; icons </span>
                                </a>
                            </li>
                            <li>
                                <a href="ui_animations.html">
                                    <span class="title"> CSS3 Animation </span>
                                    <span class="badge badge-new">new</span>
                                </a>
                            </li>
                            <li>
                                <a href="ui_modals.html">
                                    <span class="title"> Extended Modals </span>
                                </a>
                            </li>
                            <li>
                                <a href="ui_tabs_accordions.html">
                                    <span class="title"> Tabs &amp; Accordions </span>
                                </a>
                            </li>
                            <li>
                                <a href="ui_sliders.html">
                                    <span class="title"> Sliders </span>
                                </a>
                            </li>
                            <li>
                                <a href="ui_treeview.html">
                                    <span class="title"> Treeview </span>
                                </a>
                            </li>
                            <li>
                                <a href="ui_nestable.html">
                                    <span class="title"> Nestable List </span>
                                </a>
                            </li>
                            <li>
                                <a href="ui_typography.html">
                                    <span class="title"> Typography </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-grid-6"></i>
                            <span class="title"> Tables </span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="table_static.html">
                                    <span class="title">Static Tables</span>
                                </a>
                            </li>
                            <li>
                                <a href="table_responsive.html">
                                    <span class="title">Responsive Tables</span>
                                </a>
                            </li>
                            <li>
                                <a href="table_data.html">
                                    <span class="title">Data Tables</span>
                                </a>
                            </li>
                            <li>
                                <a href="table_export.html">
                                    <span class="title">Table Export</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-pencil"></i>
                            <span class="title"> Forms </span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="form_elements.html">
                                    <span class="title">Form Elements</span>
                                </a>
                            </li>
                            <li>
                                <a href="form_wizard.html">
                                    <span class="title">Form Wizard</span>
                                </a>
                            </li>
                            <li>
                                <a href="form_validation.html">
                                    <span class="title">Form Validation</span>
                                </a>
                            </li>
                            <li>
                                <a href="form_inline.html">
                                    <span class="title">Inline Editor</span>
                                </a>
                            </li>
                            <li>
                                <a href="form_x_editable.html">
                                    <span class="title">Form X-editable</span>
                                </a>
                            </li>
                            <li>
                                <a href="form_image_cropping.html">
                                    <span class="title">Image Cropping</span>
                                </a>
                            </li>
                            <li>
                                <a href="form_multiple_upload.html">
                                    <span class="title">Multiple File Upload</span>
                                </a>
                            </li>
                            <li>
                                <a href="form_dropzone.html">
                                    <span class="title">Dropzone File Upload</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-user-2"></i>
                            <span class="title">Login</span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="login_example1.html">
                                    <span class="title">Login Form Example 1</span>
                                </a>
                            </li>
                            <li>
                                <a href="login_example2.html">
                                    <span class="title">Login Form Example 2</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-file"></i>
                            <span class="title">Pages</span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="pages_user_profile.html">
                                    <span class="title">User Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="pages_invoice.html">
                                    <span class="title">Invoice</span>
                                    <span class="badge badge-new">new</span>
                                </a>
                            </li>
                            <li>
                                <a href="pages_gallery.html">
                                    <span class="title">Gallery</span>
                                </a>
                            </li>
                            <li>
                                <a href="pages_timeline.html">
                                    <span class="title">Timeline</span>
                                </a>
                            </li>
                            <li>
                                <a href="pages_calendar.html">
                                    <span class="title">Calendar</span>
                                </a>
                            </li>
                            <li>
                                <a href="pages_messages.html">
                                    <span class="title">Messages</span>
                                </a>
                            </li>
                            <li>
                                <a href="pages_blank_page.html">
                                    <span class="title">Blank Page</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="clip-attachment-2"></i>
                            <span class="title">Utility</span><i class="icon-arrow"></i>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="utility_faq.html">
                                    <span class="title">Faq</span>
                                </a>
                            </li>
                            <li>
                                <a href="utility_search_result.html">
                                    <span class="title">Search Results </span>
                                    <span class="badge badge-new">new</span>
                                </a>
                            </li>
                            <li>
                                <a href="utility_lock_screen.html">
                                    <span class="title">Lock Screen</span>
                                </a>
                            </li>
                            <li>
                                <a href="utility_404_example1.html">
                                    <span class="title">Error 404 Example 1</span>
                                </a>
                            </li>
                            <li>
                                <a href="utility_404_example2.html">
                                    <span class="title">Error 404 Example 2</span>
                                </a>
                            </li>
                            <li>
                                <a href="utility_404_example3.html">
                                    <span class="title">Error 404 Example 3</span>
                                </a>
                            </li>
                            <li>
                                <a href="utility_500_example1.html">
                                    <span class="title">Error 500 Example 1</span>
                                </a>
                            </li>
                            <li>
                                <a href="utility_500_example2.html">
                                    <span class="title">Error 500 Example 2</span>
                                </a>
                            </li>
                            <li>
                                <a href="utility_pricing_table.html">
                                    <span class="title">Pricing Table</span>
                                </a>
                            </li>
                            <li>
                                <a href="utility_coming_soon.html">
                                    <span class="title">Cooming Soon</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="active">
                            <i class="clip-folder"></i>
                            <span class="title"> 3 Level Menu </span>
                            <i class="icon-arrow"></i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="javascript:;">
                            Item 1 <i class="icon-arrow"></i>
                        </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="#">
                                    Sample Link 1
                                </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                    Sample Link 2
                                </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                    Sample Link 3
                                </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                            Item 1 <i class="icon-arrow"></i>
                        </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="#">
                                    Sample Link 1
                                </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                    Sample Link 1
                                </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                    Sample Link 1
                                </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                            Item 3
                        </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="clip-folder-open"></i>
                            <span class="title"> 4 Level Menu </span><i class="icon-arrow"></i>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="javascript:;">
                            Item 1 <i class="icon-arrow"></i>
                        </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="javascript:;">
                                    Sample Link 1 <i class="icon-arrow"></i>
                                </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-times"></i> Sample Link 1
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-pencil"></i> Sample Link 1
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-edit"></i> Sample Link 1
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">
                                    Sample Link 1
                                </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                    Sample Link 2
                                </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                    Sample Link 3
                                </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:;">
                            Item 2 <i class="icon-arrow"></i>
                        </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="#">
                                    Sample Link 1
                                </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                    Sample Link 1
                                </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                    Sample Link 1
                                </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                            Item 3
                        </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="maps.html">
                            <i class="clip-location"></i>
                            <span class="title">Maps</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li>
                        <a href="charts.html">
                            <i class="clip-bars"></i>
                            <span class="title">Charts</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                </ul>
                <!-- end: MAIN NAVIGATION MENU -->
            </div>
            <!-- end: SIDEBAR -->
        </div>

        <!-- start: PAGE -->
        <div class="main-content">
            <!-- start: PANEL CONFIGURATION MODAL FORM -->
            <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                            <h4 class="modal-title">Panel Configuration</h4>
                        </div>
                        <div class="modal-body">
                            Here will be a configuration form
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                    Close
                </button>
                            <button type="button" class="btn btn-primary">
                    Save changes
                </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- end: SPANEL CONFIGURATION MODAL FORM -->
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
                                Dashboard
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
                            <h1>Dashboard <small>overview &amp; stats </small></h1>
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
                                <i class="clip-user-4 circle-icon circle-green"></i>
                                <h2>Manage Users</h2>
                            </div>
                            <div class="content">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </div>
                            <a class="view-more" href="#">
                                View More <i class="clip-arrow-right-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="core-box">
                            <div class="heading">
                                <i class="clip-clip circle-icon circle-teal"></i>
                                <h2>Manage Orders</h2>
                            </div>
                            <div class="content">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </div>
                            <a class="view-more" href="#">
                                View More <i class="clip-arrow-right-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="core-box">
                            <div class="heading">
                                <i class="clip-database circle-icon circle-bricky"></i>
                                <h2>Manage Data</h2>
                            </div>
                            <div class="content">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                            </div>
                            <a class="view-more" href="#">
                                View More <i class="clip-arrow-right-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="clip-stats"></i> Site Visits
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
                                <div class="flot-medium-container">
                                    <div id="placeholder-h1" class="flot-placeholder"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="clip-pie"></i> Acquisition
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
                                        <div class="flot-mini-container">
                                            <div id="placeholder-h2" class="flot-placeholder"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="clip-bars"></i> Pageviews real-time
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
                                        <div class="flot-mini-container">
                                            <div id="placeholder-h3" class="flot-placeholder"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="row space12">
                            <ul class="mini-stats col-sm-12">
                                <li class="col-sm-4">
                                    <div class="sparkline_bar_good">
                                        <span>3,5,9,8,13,11,14</span>+10%
                                    </div>
                                    <div class="values">
                                        <strong>18304</strong> Visits
                                    </div>
                                </li>
                                <li class="col-sm-4">
                                    <div class="sparkline_bar_neutral">
                                        <span>20,15,18,14,10,12,15,20</span>0%
                                    </div>
                                    <div class="values">
                                        <strong>3833</strong> Unique Visitors
                                    </div>
                                </li>
                                <li class="col-sm-4">
                                    <div class="sparkline_bar_bad">
                                        <span>4,6,10,8,12,21,11</span>+50%
                                    </div>
                                    <div class="values">
                                        <strong>18304</strong> Pageviews
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="row space12">
                            <div class="col-sm-6">
                                <div class="easy-pie-chart">
                                    <span class="bounce number" data-percent="44"> <span class="percent">44</span> </span>
                                    <div class="label-chart">
                                        Bounce Rate
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="easy-pie-chart">
                                    <span class="cpu number" data-percent="82"> <span class="percent">82</span> </span>
                                    <div class="label-chart">
                                        New Visits
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="clip-users-2"></i> Users
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
                            <div class="panel-body panel-scroll" style="height:300px">
                                <table class="table table-striped table-hover" id="sample-table-1">
                                    <thead>
                                        <tr>
                                            <th class="center">Photo</th>
                                            <th>Full Name</th>
                                            <th class="hidden-xs">Email</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="center"><img src="/assets/images/avatar-1.jpg" alt="image" /></td>
                                            <td>Peter Clark</td>
                                            <td class="hidden-xs">
                                                <a href="#" rel="nofollow" target="_blank">
                                                    peter@example.com
                                                </a>
                                            </td>
                                            <td class="center">
                                                <div>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                            <i class="fa fa-cog"></i> <span class="caret"></span>
                                                        </a>
                                                        <ul role="menu" class="dropdown-menu pull-right">
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-share"></i> Share
                                                                </a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-times"></i> Remove
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="center"><img src="/assets/images/avatar-2.jpg" alt="image" /></td>
                                            <td>Nicole Bell</td>
                                            <td class="hidden-xs">
                                                <a href="#" rel="nofollow" target="_blank">
                                                    nicole@example.com
                                                </a>
                                            </td>
                                            <td class="center">
                                                <div>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                            <i class="fa fa-cog"></i> <span class="caret"></span>
                                                        </a>
                                                        <ul role="menu" class="dropdown-menu pull-right">
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-share"></i> Share
                                                                </a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-times"></i> Remove
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="center"><img src="/assets/images/avatar-3.jpg" alt="image" /></td>
                                            <td>Steven Thompson</td>
                                            <td class="hidden-xs">
                                                <a href="#" rel="nofollow" target="_blank">
                                                    steven@example.com
                                                </a>
                                            </td>
                                            <td class="center">
                                                <div>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                            <i class="fa fa-cog"></i> <span class="caret"></span>
                                                        </a>
                                                        <ul role="menu" class="dropdown-menu pull-right">
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-share"></i> Share
                                                                </a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-times"></i> Remove
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="center"><img src="/assets/images/avatar-5.jpg" alt="image" /></td>
                                            <td>Kenneth Ross</td>
                                            <td class="hidden-xs">
                                                <a href="#" rel="nofollow" target="_blank">
                                                    kenneth@example.com
                                                </a>
                                            </td>
                                            <td class="center">
                                                <div>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                            <i class="fa fa-cog"></i> <span class="caret"></span>
                                                        </a>
                                                        <ul role="menu" class="dropdown-menu pull-right">
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-share"></i> Share
                                                                </a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-times"></i> Remove
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="center"><img src="/assets/images/avatar-4.jpg" alt="image" /></td>
                                            <td>Ella Patterson</td>
                                            <td class="hidden-xs">
                                                <a href="#" rel="nofollow" target="_blank">
                                                    ella@example.com
                                                </a>
                                            </td>
                                            <td class="center">
                                                <div>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                            <i class="fa fa-cog"></i> <span class="caret"></span>
                                                        </a>
                                                        <ul role="menu" class="dropdown-menu pull-right">
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-share"></i> Share
                                                                </a>
                                                            </li>
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="#">
                                                                    <i class="fa fa-times"></i> Remove
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="clip-checkbox"></i> To Do
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
                            <div class="panel-body panel-scroll" style="height:300px">
                                <ul class="todo">
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc" style="opacity: 1; text-decoration: none;">Staff Meeting</span>
                                            <span class="label label-danger" style="opacity: 1;"> today</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc" style="opacity: 1; text-decoration: none;"> New frontend layout</span>
                                            <span class="label label-danger" style="opacity: 1;"> today</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc"> Hire developers</span>
                                            <span class="label label-warning"> tommorow</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc">Staff Meeting</span>
                                            <span class="label label-warning"> tommorow</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc"> New frontend layout</span>
                                            <span class="label label-success"> this week</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc"> Hire developers</span>
                                            <span class="label label-success"> this week</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc"> New frontend layout</span>
                                            <span class="label label-info"> this month</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc"> Hire developers</span>
                                            <span class="label label-info"> this month</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc" style="opacity: 1; text-decoration: none;">Staff Meeting</span>
                                            <span class="label label-danger" style="opacity: 1;"> today</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc" style="opacity: 1; text-decoration: none;"> New frontend layout</span>
                                            <span class="label label-danger" style="opacity: 1;"> today</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="todo-actions" href="javascript:void(0)">
                                            <i class="fa fa-square-o"></i>
                                            <span class="desc"> Hire developers</span>
                                            <span class="label label-warning"> tommorow</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="clip-calendar"></i> Calendar
                                <div class="panel-tools">
                                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                    </a>
                                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                                        <i class="fa fa-wrench"></i>
                                    </a>
                                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    <a class="btn btn-xs btn-link panel-expand" href="#">
                                        <i class="fa fa-resize-full"></i>
                                    </a>
                                    <a class="btn btn-xs btn-link panel-close" href="#">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id='calendar'></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="clip-bubble-4"></i> Chats
                                        <div class="panel-tools">
                                            <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                            </a>
                                            <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                                                <i class="fa fa-wrench"></i>
                                            </a>
                                            <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <a class="btn btn-xs btn-link panel-expand" href="#">
                                                <i class="fa fa-resize-full"></i>
                                            </a>
                                            <a class="btn btn-xs btn-link panel-close" href="#">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="panel-body panel-scroll" style="height:460px">
                                        <ol class="discussion">
                                            <li class="other">
                                                <div class="avatar">
                                                    <img alt="" src="/assets/images/avatar-4.jpg">
                                                </div>
                                                <div class="messages">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                                    </p>
                                                    <span class="time"> 51 min </span>
                                                </div>
                                            </li>
                                            <li class="self">
                                                <div class="avatar">
                                                    <img alt="" src="/assets/images/avatar-1.jpg">
                                                </div>
                                                <div class="messages">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                                    </p>
                                                    <span class="time"> 37 mins </span>
                                                </div>
                                            </li>
                                            <li class="other">
                                                <div class="avatar">
                                                    <img alt="" src="/assets/images/avatar-3.jpg">
                                                </div>
                                                <div class="messages">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                                    </p>
                                                </div>
                                            </li>
                                            <li class="self">
                                                <div class="avatar">
                                                    <img alt="" src="/assets/images/avatar-1.jpg">
                                                </div>
                                                <div class="messages">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                                    </p>
                                                </div>
                                            </li>
                                            <li class="other">
                                                <div class="avatar">
                                                    <img alt="" src="/assets/images/avatar-4.jpg">
                                                </div>
                                                <div class="messages">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                                    </p>
                                                </div>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="chat-form">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-mask-date" placeholder="Type a message here...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-teal" type="button">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: PAGE CONTENT-->
            </div>
        </div>
        <!-- end: PAGE -->
    </div>
    <!-- end: MAIN CONTAINER -->
    <!-- start: FOOTER -->
    <div class="footer clearfix">
        <div class="footer-inner">
            <script>
                document.write(new Date().getFullYear())
            </script> &copy; clip-one by cliptheme.
        </div>
        <div class="footer-items">
            <span class="go-top"><i class="clip-chevron-up"></i></span>
        </div>
    </div>
    <!-- end: FOOTER -->
    <!-- start: MAIN JAVASCRIPTS -->
    <!--[if lt IE 9]>
        <script src="/bower_components/respond/dest/respond.min.js"></script>
        <script src="/bower_components/Flot/excanvas.min.js"></script>
        <script src="/bower_components/jquery-1.x/dist/jquery.min.js"></script>
        <![endif]-->
    <!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
    <!--<![endif]-->

    <script type="text/javascript" src="/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/bower_components/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
    <script type="text/javascript" src="/bower_components/blockUI/jquery.blockUI.js"></script>
    <script type="text/javascript" src="/bower_components/iCheck/icheck.min.js"></script>
    <script type="text/javascript" src="/bower_components/perfect-scrollbar/js/min/perfect-scrollbar.jquery.min.js"></script>
    <script type="text/javascript" src="/bower_components/jquery.cookie/jquery.cookie.js"></script>
    <script type="text/javascript" src="/bower_components/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="/assets/js/min/main.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/bower_components/Flot/jquery.flot.js"></script>
    <script src="/bower_components/Flot/jquery.flot.pie.js"></script>
    <script src="/bower_components/Flot/jquery.flot.resize.js"></script>
    <script src="/assets/plugin/jquery.sparkline.min.js"></script>
    <script src="/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <script src="/bower_components/jqueryui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <script src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="/assets/js/min/index.min.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

    <script>
        jQuery(document).ready(function() {
            Main.init();
            Index.init();
        });
    </script>

</body>

</html>