<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/22/2019
 * Time: 3:52 PM
 */

$footerScripts = isset($pg_footer_scripts) ? $pg_footer_scripts : [];
$vueComponents = isset($pg_vue_components) ? $pg_vue_components : [];
?>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0.0
    </div>
    <strong>© 2019 &nbsp;&nbsp; <a href="<?php echo base_url(); ?>">emp.chinthakafernando.com</a></strong>
</footer>

</div>
<!-- ./wrapper -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/libs/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/libs/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/libs/jQuery-slimScroll-1.3.8/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/libs/jquery-growl-1.3/jquery.growl.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/_layout.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/_common.js"></script>


<script>
    MasterVars = {
        BaseUrl : "<?php echo base_url(); ?>",
        ApiToken : "<?php echo $_SESSION[SESSION_TOKEN]?>",
        DefaultPageSize : 10
    };

    CommonFunctions = cHiNCommon.CommonFunctions;
</script>

<!--Vue-Components -->
<?php
foreach ($vueComponents as &$vueComponent) {
    $this->load->view($vueComponent);
} ?>
<!--/Vue-Components -->

<!-- Page scripts-->
<?php
foreach ($footerScripts as &$script) { ?>
    <script type="text/javascript" src="<?php echo base_url().$script; ?>"></script>
<?php } ?>
<!-- Page scripts-->

</body>
</html>
