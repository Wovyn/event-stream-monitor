<?php echo view('auth/includes/header'); ?>

<body class="login">
    <div class="main-login col-sm-4 col-sm-offset-4">
        <div class="logo">
            <!-- CLIP<i class="clip-clip"></i>ONE -->
            <img src="/assets/images/logo-1020x300.png" width="1020" height="300" alt="EventStreamMonitor">
        </div>
        <!-- start: LOGIN BOX -->
        <div class="box-login">
            <h3>Sign in to your account</h3>
            <p>
                Please enter your name and password to log in.
            </p>
            <form class="form-login" method="post" action="/auth/login">
                <?php if($message): ?>
                    <?php echo $message;?>
                <?php endif; ?>
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
                </div>
                <fieldset>
                    <div class="form-group">
                        <span class="input-icon">
                            <input type="text" class="form-control" name="identity" id="identity" placeholder="Username">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>
                    <div class="form-group form-actions">
                        <span class="input-icon">
                            <input type="password" class="form-control password" name="password" id="password" placeholder="Password">
                            <i class="fa fa-lock"></i>
                            <a class="forgot" href="#">
                                I forgot my password
                            </a>
                        </span>
                    </div>
                    <div class="form-actions">
                        <label for="remember" class="checkbox-inline">
                            <input type="checkbox" class="grey remember" id="remember" name="remember">
                            Keep me signed in
                        </label>
                        <button type="submit" class="btn btn-bricky pull-right">
                            Login <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                    <div class="new-account">
                        Don't have an account yet?
                        <a href="#" class="register">
                            Create an account
                        </a>
                    </div>
                </fieldset>
            </form>
        </div>
        <!-- end: LOGIN BOX -->
        <!-- start: FORGOT BOX -->
        <div class="box-forgot">
            <h3>Forget Password?</h3>
            <p>
                Enter your e-mail address below to reset your password.
            </p>
            <form class="form-forgot" action="/auth/forgot_password" method="post">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
                </div>
                <fieldset>
                    <div class="form-group">
                        <span class="input-icon">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>
                    <div class="form-actions">
                        <a class="btn btn-light-grey go-back">
                            <i class="fa fa-circle-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-bricky pull-right">
                            Submit <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
        <!-- end: FORGOT BOX -->
        <!-- start: REGISTER BOX -->
        <div class="box-register">
            <h3>Sign Up</h3>
            <p>
                Enter your personal details below:
            </p>
            <form class="form-register" action="/auth/register" method="post">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
                </div>
                <fieldset>
                    <div class="form-group">
                        <span class="input-icon">
                            <input class="form-control" type="text" placeholder="First Name" name="first_name"/>
                            <i class="fa fa-font"></i>
                        </span>
                    </div>
                    <div class="form-group">
                        <span class="input-icon">
                            <input class="form-control" type="text" placeholder="Last Name" name="last_name"/>
                            <i class="fa fa-font"></i>
                        </span>
                    </div>
                    <div class="form-group">
                        <span class="input-icon">
                            <input class="form-control" type="text" placeholder="Phone" name="phone"/>
                            <i class="fa fa-phone"></i>
                        </span>
                    </div>
                    <div class="form-group">
                        <span class="input-icon">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>
                    <div class="form-group">
                        <span class="input-icon">
                            <input type="password" class="form-control" id="register_password" name="password" placeholder="Password">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <div class="form-group">
                        <span class="input-icon">
                            <input type="password" class="form-control" name="password_confirm" placeholder="Re-type Your Password">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="agree" class="checkbox-inline">
                                <input type="checkbox" class="grey agree" id="agree" name="agree">
                                I agree to the Terms of Service and Privacy Policy
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a class="btn btn-light-grey go-back">
                            <i class="fa fa-circle-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-bricky pull-right">
                            Submit <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <!-- end: REGISTER BOX -->

<?php echo view('auth/includes/footer'); ?>