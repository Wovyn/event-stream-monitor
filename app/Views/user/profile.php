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
            <div class="col-sm-12">
                <div class="tabbable">
                    <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue">
                        <li class="active"><a data-toggle="tab" href="#overview">Overview</a></li>
                        <li><a data-toggle="tab" href="#edit_account">Edit Account</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="overview" class="tab-pane in active">
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
                                                    <td><a href="#edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>phone:</td>
                                                    <td><a href="tel:<?php echo $user->phone ?>"><?php echo $user->phone ?></a></td>
                                                    <td><a href="#edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
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
                                                    <td><a href="#edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>Last Logged In</td>
                                                    <td><?php echo $user->last_login ?></td>
                                                    <td><a href="#edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-7 col-md-8">
                                    <form action="/user/profile/update_keys" role="form" id="update-keys-form">
                                        <fieldset>
                                            <legend>
                                                Twilio API Keys
                                                <a class="popovers" href="javascript:;"
                                                    data-original-title="Configure Twilio API Keys"
                                                    data-content="Event Stream Monitor requires Twilio API Keys to call the Twilio Event Stream APIs. You can use the Twilio Console to create a set of revokable API Keys.  In the Twilio Console, create a 'Standard' Key Type set of API Keys.  Click here to <a href='https://www.twilio.com/console/project/api-keys' target='_blank'>Create API Keys</a> then you can copy and paste the SID and Secret into the fields below."
                                                    data-html="true"
                                                    data-placement="top"
                                                >
                                                    <i class="fa fa-question-circle"></i>
                                                </a>
                                            </legend>

                                            <div class="form-group">
                                                <label class="control-label">
                                                    SID
                                                </label>
                                                <input type="text" placeholder="SID" class="form-control" id="twilio_sid" name="twilio_sid" required value="<?php echo isset($auth_keys->twilio_sid) ? $auth_keys->twilio_sid : '' ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Secret
                                                </label>
                                                <div class="input-group input-append input-hidden-container input-hidden">
                                                    <input type="text" placeholder="Secret" class="form-control" id="twilio_secret" name="twilio_secret" required value="<?php echo isset($auth_keys->twilio_secret) ? $auth_keys->twilio_secret : '' ?>">
                                                    <span class="input-group-addon add-on toggle"><i class="clip-eye"></i></span>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <br>
                                        <fieldset>
                                            <legend>
                                                AWS API Keys
                                                <a class="popovers" href="javascript:;"
                                                    data-original-title="AWS API Keys and Configuration"
                                                    data-content="To allow Event Stream Monitor to create and configure AWS resources on your behalf, there are several steps that must be taken to obtain values for the fields below.  Click here to <a href='https://docs.google.com/document/d/1iUATJFnRaQXv7OvvWu5mAvpDDCd6H6EkZOjVNAAK69c/edit?usp=sharing' target='_blank'>Read the AWS Configuration Steps</a>"
                                                    data-html="true"
                                                    data-placement="top"
                                                >
                                                    <i class="fa fa-question-circle"></i>
                                                </a>
                                            </legend>

                                            <div class="form-group">
                                                <label class="control-label">
                                                    Access Key
                                                </label>
                                                <input type="text" placeholder="Access Key" class="form-control" id="aws_access" name="aws_access" value="<?php echo isset($auth_keys->aws_access) ? $auth_keys->aws_access : '' ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Secret Key
                                                </label>
                                                <div class="input-group input-append input-hidden-container input-hidden">
                                                    <input type="text" placeholder="Secret Key" class="form-control" id="aws_secret" name="aws_secret" value="<?php echo isset($auth_keys->aws_secret) ? $auth_keys->aws_secret : '' ?>">
                                                    <span class="input-group-addon add-on toggle"><i class="clip-eye"></i></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Event Stream Role ARN
                                                </label>
                                                <input type="text" placeholder="Event Stream Role ARN" class="form-control" id="event_stream_role_arn" name="event_stream_role_arn" value="<?php echo isset($auth_keys->event_stream_role_arn) ? $auth_keys->event_stream_role_arn : '' ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    External ID
                                                </label>
                                                <div class="input-group input-append input-hidden-container input-hidden">
                                                    <input type="text" placeholder="External ID" class="form-control" id="external_id" name="external_id" value="<?php echo isset($auth_keys->external_id) ? $auth_keys->external_id : '' ?>">
                                                    <span class="input-group-addon add-on toggle"><i class="clip-eye"></i></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    S3 - Firehose Role ARN
                                                </label>
                                                <input type="text" placeholder="S3 - Firehose Role ARN" class="form-control" id="s3_firehose_role_arn" name="s3_firehose_role_arn" value="<?php echo isset($auth_keys->s3_firehose_role_arn) ? $auth_keys->s3_firehose_role_arn : '' ?>">
                                            </div>
                                        </fieldset>

                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-6">
                                                <button class="btn btn-teal btn-block" type="submit">
                                                    Update <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="edit_account" class="tab-pane">
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