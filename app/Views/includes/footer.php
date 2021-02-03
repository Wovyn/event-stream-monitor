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
    <!--[if lt IE 9]>
        <script src="/bower_components/respond/dest/respond.min.js"></script>
        <script src="/bower_components/Flot/excanvas.min.js"></script>
        <script src="/bower_components/jquery-1.x/dist/jquery.min.js"></script>
        <![endif]-->
    <!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
    <!--<![endif]-->

    <!-- start: MAIN JAVASCRIPTS -->
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

    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <?php foreach($scripts as $path): ?>
         <script type="text/javascript" src="<?php echo $path; ?>"></script>
    <?php endforeach; ?>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

    <script type="text/javascript" src="/assets/js/app.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
</body>

</html>