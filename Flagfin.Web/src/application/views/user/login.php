<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 4/4/2019
 * Time: 11:50 AM
 */

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login to Employee Review System</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/libs/fontawesome-free-5.7.2/css/all.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/libs/jquery-growl-1.3/jquery.growl.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/styles/_layout.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/styles/_skin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/styles/_components.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/styles/user/register.css" rel="stylesheet">
</head>

<body class="login-page">

    <div style="height:100vh;"></div>
    <div class="login-box login-wrapper">
        <!-- /.login-logo -->
        <div id="divLogin" class="login-box-body">
            <div class="login-logo">
                <a href="<?php echo base_url(); ?>">
                    <img src="<?php echo base_url(); ?>assets/images/layout/logo-w-sm.png" style="width: 200px;">
                </a>
            </div>

            <form id="frmLogin">
                <div class="form-group has-feedback">
                    <input type="text" id="txtUserName" class="form-control-md" placeholder="UserName" data-toggle="tooltip"
                           title="Enter UserName">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="txtPassword" class="form-control-md" placeholder="Password"
                           data-toggle="tooltip" title="Enter Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">

                    <button type="button" id="btnLogin" class="btn-md btn-primary btn-block btn-flat">
                        Sign In
                    </button>
                </div>
                <div class="form-group company-info-container">
                    <address>
                        <strong>Employee Performance Review System.</strong><br/>
                        Register For Employee Review System<br/>
                    </address>
                </div>
            </form>

            <div class="login-footer-logo">

            </div>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

<script src="<?php echo base_url(); ?>assets/libs/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/libs/jquery-growl-1.3/jquery.growl.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/_common.js"></script>


<script type="text/javascript">
    MasterVars = {
        BaseUrl : "<?php echo base_url(); ?>"
    };

    CommonFunctions = cHiNCommon.CommonFunctions;

    var pageVars = {
        loginUrl : '<?php echo base_url('index.php/user/loginUser') ?>',
        baseUrl : "<?php echo base_url(); ?>"
    };
</script>

    <script src="<?php echo base_url(); ?>assets/scripts/user/login.js"></script>

</body>
</html>

