<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/22/2019
 * Time: 3:40 PM
 */

$pageTitle = isset($pg_title) ? $pg_title : "" ;
$headerStyles = isset($pg_header_styles) ? $pg_header_styles : [];
$headerScripts = isset($pg_header_scripts) ? $pg_header_scripts : [];
$breadCrumbs = isset($pg_header_breadcrumbs) ? $pg_header_breadcrumbs : [];

$loggedInUser = null;

$authorizedData = authorizeUser("");
if($authorizedData["is_authorized"]){
    $loggedInUser = $authorizedData["user"];
}
else{
    redirect("/user", 'refresh');
}
?>

<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title><?php echo $pageTitle?></title>

    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/libs/fontawesome-free-5.7.2/css/all.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/libs/jquery-growl-1.3/jquery.growl.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link href="<?php echo base_url(); ?>assets/styles/_layout.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/styles/_skin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/styles/_components.css" rel="stylesheet">

    <?php
    foreach ($headerStyles as &$style) { ?>
        <link href="<?php echo base_url().$style; ?>" rel="stylesheet">
    <?php } ?>

    <?php
    foreach ($headerScripts as &$script) { ?>
        <script type="text/javascript" src="<?php echo base_url().$script; ?>"></script>
    <?php } ?>

</head>


<body class="base-skin fixed sidebar-mini sidebar-mini-expand-feature">

<!-- Site wrapper -->
<div class="wrapper" id="mainBodyContainer">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo hidden-xs">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">
                <img src="<?php echo base_url(); ?>assets/images/layout/logo-xs.png">
            </span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <img src="<?php echo base_url(); ?>assets/images/layout/logo-w-sm.png">
            </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle"
               data-toggle="push-menu" role="button">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle navigation</span>
            </a>
            <a class="xs-logo-icon visible-xs">
                <img src="<?php echo base_url(); ?>assets/images/layout/logo-xs.png">
            </a>
            <div class="page-title-header">
                <ol>
                    <?php
                    if(count($breadCrumbs)>1){
                        for($i = 0 ;$i<count($breadCrumbs); $i++){
                            if($i == 0){
                                ?> <li><i class="<?php echo $breadCrumbs[0] ?>"></i> <?php echo $breadCrumbs[1] ?></li> <?php
                                $i = 1;
                            }else{
                                ?>  <li><?php echo $breadCrumbs[$i] ?></li> <?php
                            }
                        }
                    }
                    ?>
                </ol>
            </div>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo base_url(); ?>assets/images/layout/user.png" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?php echo $loggedInUser->UserName ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <p>
                                    <small>
                                        <?php echo $loggedInUser->UserName?>
                                    </small>
                                    <?php echo '('.$loggedInUser->Email.')'?>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div>
                                    <a href="<?php echo base_url(); ?>index.php/user/logoutUser"
                                       class="btn-md btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

<?php
$this->load->view('_layout/_navigation.php',null)
?>