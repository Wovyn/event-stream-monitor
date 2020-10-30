<?php echo view('auth/includes/header'); ?>

<body class="lock-screen">
    <div class="main-ls">
        <div class="logo">
            CLIP<i class="clip-clip"></i>ONE
        </div>
        <div class="box-ls">
            <img alt="" src="/assets/images/avatar-1-xl.jpg" />
            <div class="user-info">
                <h1><i class="fa fa-lock"></i> <?php echo $user->first_name . ' ' . $user->last_name ?></h1>
                <span><?php echo $user->email ?></span>
                <span><em>Please enter your password to un-lock.</em></span>
                <form action="/auth/lockscreen" method="post">
                    <div class="input-group <?php echo isset($has_error) ? 'has-error' : '' ?>">
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-blue" type="submit">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                        </span>
                    </div>
                    <div class="relogin">
                        <a href="/auth/logout">
                            Not <?php echo $user->first_name . ' ' . $user->last_name ?>?
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="copyright">
            <script>
                document.write(new Date().getFullYear())
            </script> &copy; clip-one by cliptheme.
        </div>
    </div>

<?php echo view('auth/includes/footer'); ?>