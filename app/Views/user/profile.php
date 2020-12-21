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
            <div class="col-sm-12">
                <div class="tabbable">
                    <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                        <li class="active"><a data-toggle="tab" href="#panel_overview">Overview</a></li>
                        <li><a data-toggle="tab" href="#panel_edit_account">Edit Account</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="panel_overview" class="tab-pane in active">
                            <div class="row">
                                <div class="col-sm-5 col-md-4">
                                    <div class="user-left">
                                        <div class="center">
                                            <h4><?php echo $user->first_name . ' ' . $user->last_name ?></h4>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="user-image">
                                                    <div id="kv-avatar-errors" class="center-block" style="display:none"></div>
                                                    <div class="kv-avatar ">
                                                        <input id="avatar" name="avatar" type="file" class="file-loading">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <p>
                                                <a class="btn btn-social-icon btn-twitter">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                                <a class="btn btn-social-icon btn-linkedin">
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                                <a class="btn btn-social-icon btn-google">
                                                    <i class="fa fa-google-plus"></i>
                                                </a>
                                                <a class="btn btn-social-icon btn-github">
                                                    <i class="fa fa-github"></i>
                                                </a>
                                            </p>
                                            <hr>
                                        </div>
                                        <table class="table table-condensed table-hover">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">Contact Information</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>email:</td>
                                                    <td><a href="mailto:<?php echo $user->email ?>"><?php echo $user->email ?></a></td>
                                                    <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>phone:</td>
                                                    <td><a href="tel:<?php echo $user->phone ?>"><?php echo $user->phone ?></a></td>
                                                    <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-condensed table-hover">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">General information</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Company</td>
                                                    <td><?php echo $user->company ?></td>
                                                    <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Last Logged In</td>
                                                    <td><?php echo $user->last_login ?></td>
                                                    <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-7 col-md-8">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas convallis porta purus, pulvinar mattis nulla tempus ut. Curabitur quis dui orci. Ut nisi dolor, dignissim a aliquet quis, vulputate id dui. Proin ultrices ultrices ligula, dictum varius
                                        turpis faucibus non. Curabitur faucibus ultrices nunc, nec aliquet leo tempor cursus.
                                    </p>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <button class="btn btn-icon btn-block">
                                                <i class="clip-clip"></i>
                                                Projects <span class="badge badge-info"> 4 </span>
                                            </button>
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="btn btn-icon btn-block pulsate">
                                                <i class="clip-bubble-2"></i>
                                                Messages <span class="badge badge-info"> 23 </span>
                                            </button>
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="btn btn-icon btn-block">
                                                <i class="clip-calendar"></i>
                                                Calendar <span class="badge badge-info"> 5 </span>
                                            </button>
                                        </div>
                                        <div class="col-sm-3">
                                            <button class="btn btn-icon btn-block">
                                                <i class="clip-list-3"></i>
                                                Notifications <span class="badge badge-info"> 9 </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <i class="clip-menu"></i> Recent Activities
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
                                            <ul class="activities">
                                                <li>
                                                    <a class="activity" href="javascript:void(0)">
                                                        <i class="clip-upload-2 circle-icon circle-green"></i>
                                                        <span class="desc">You uploaded a new release.</span>
                                                        <div class="time">
                                                            <i class="fa fa-time bigger-110"></i> 2 hours ago
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="activity" href="javascript:void(0)">
                                                        <img alt="image" src="/assets/images/avatar-2.jpg">
                                                        <span class="desc">Nicole Bell sent you a message.</span>
                                                        <div class="time">
                                                            <i class="fa fa-time bigger-110"></i> 3 hours ago
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="activity" href="javascript:void(0)">
                                                        <i class="clip-data circle-icon circle-bricky"></i>
                                                        <span class="desc">DataBase Migration.</span>
                                                        <div class="time">
                                                            <i class="fa fa-time bigger-110"></i> 5 hours ago
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="activity" href="javascript:void(0)">
                                                        <i class="clip-clock circle-icon circle-teal"></i>
                                                        <span class="desc">You added a new event to the calendar.</span>
                                                        <div class="time">
                                                            <i class="fa fa-time bigger-110"></i> 8 hours ago
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="activity" href="javascript:void(0)">
                                                        <i class="clip-images-2 circle-icon circle-green"></i>
                                                        <span class="desc">Kenneth Ross uploaded new images.</span>
                                                        <div class="time">
                                                            <i class="fa fa-time bigger-110"></i> 9 hours ago
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="activity" href="javascript:void(0)">
                                                        <i class="clip-image circle-icon circle-green"></i>
                                                        <span class="desc">Peter Clark uploaded a new image.</span>
                                                        <div class="time">
                                                            <i class="fa fa-time bigger-110"></i> 12 hours ago
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <i class="clip-checkmark-2"></i> To Do
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
                        </div>
                        <div id="panel_edit_account" class="tab-pane">
                            <form action="/user/profile/update" role="form" id="update-profile-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Profile Info</h3>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                First Name
                                            </label>
                                            <input type="text" placeholder="Peter" class="form-control" id="first_name" name="first_name" required value="<?php echo $user->first_name ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Last Name
                                            </label>
                                            <input type="text" placeholder="Clark" class="form-control" id="last_name" name="last_name" required value="<?php echo $user->last_name ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Email Address
                                            </label>
                                            <input type="email" placeholder="peter@example.com" class="form-control" id="email" name="email" required value="<?php echo $user->email ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Phone
                                            </label>
                                            <input type="text" placeholder="(641)-734-4763" class="form-control" id="phone" name="phone" required value="<?php echo $user->phone ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Password
                                            </label>
                                            <input type="password" placeholder="password" class="form-control" name="password" id="password">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Confirm Password
                                            </label>
                                            <input type="password" placeholder="confirm password" class="form-control" id="confirm_password" name="confirm_password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Company
                                            </label>
                                            <input type="text" placeholder="Company" class="form-control" id="company" name="company" required value="<?php echo $user->company ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Image Upload
                                            </label>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div id="kv-avatar-errors-2" class="center-block" style="display:none"></div>
                                                <div class="kv-avatar ">
                                                    <input id="avatar-2" name="avatar" type="file" class="file-loading">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>
                                            By clicking UPDATE, you are agreeing to the Policy and Terms &amp; Conditions.
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-teal btn-block" type="submit">
                                            Update <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view('includes/footer') ?>