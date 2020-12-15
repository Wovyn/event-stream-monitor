<?php echo view('auth/includes/header'); ?>

<body class="login">
    <div class="main-login col-sm-4 col-sm-offset-4">
        <div class="logo">
            <!-- CLIP<i class="clip-clip"></i>ONE -->
            <img src="/assets/images/logo-1020x300.png" width="1020" height="300" alt="EventStreamMonitor">
        </div>
        <!-- start: RESETPASSWORD BOX -->
        <div class="box-resetpassword">
            <h3><?php echo lang('Auth.reset_password_heading');?></h3>
            <form class="form-resetpassword" method="post" action="/auth/reset_password/<?php echo $code ?>">
                <?php if($message): ?>
                    <?php echo $message;?>
                <?php endif; ?>
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
                </div>
                <fieldset>
                    <div class="form-group">
                        <span class="input-icon">
                            <input type="password" class="form-control" name="new" id="new" placeholder="New Password">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <div class="form-group">
                        <span class="input-icon">
                            <input type="password" class="form-control" name="new_confirm" id="new_confirm" placeholder="Confirm New Password">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <?php echo form_input($user_id);?>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-bricky pull-right">
                            Reset Password <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
        <!-- end: RESETPASSWORD BOX -->
    </div>

<?php echo view('auth/includes/footer'); ?>