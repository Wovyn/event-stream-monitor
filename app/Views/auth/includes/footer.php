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
    <script type="text/javascript" src="/bower_components/bootstrap-modal/js/bootstrap-modal.js"></script>
    <script type="text/javascript" src="/bower_components/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
    <script type="text/javascript" src="/bower_components/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
    <script type="text/javascript" src="/bower_components/blockUI/jquery.blockUI.js"></script>
    <script type="text/javascript" src="/bower_components/iCheck/icheck.min.js"></script>
    <script type="text/javascript" src="/bower_components/perfect-scrollbar/js/min/perfect-scrollbar.jquery.min.js"></script>
    <script type="text/javascript" src="/bower_components/jquery.cookie/jquery.cookie.js"></script>
    <script type="text/javascript" src="/bower_components/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="/bower_components/moment/moment.js"></script>
    <script type="text/javascript" src="/bower_components/moment/moment-timezone.js"></script>
    <script type="text/javascript" src="/bower_components/jstz/jstz.min.js"></script>
    <script type="text/javascript" src="/assets/js/min/main.min.js"></script>
    <script type="text/javascript" src="/assets/js/lodash.min.js"></script>
    <script type="text/javascript" src="/assets/js/app.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="/assets/js/login.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

    <script>
        jQuery(document).ready(function() {
            Main.init();
            Login.init();

            window.localStorage.clear();
        });
    </script>

</body>

</html>