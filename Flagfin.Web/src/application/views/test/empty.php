<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/22/2019
 * Time: 3:39 PM
 */
?>

<?php
$headerVars['pg_title'] = "Test";
$headerVars['pg_header_styles'] = [];
$headerVars['pg_header_scripts'] = [];
$headerVars['pg_header_breadcrumbs'] = ["fa fa-file", "Test Management", "Tests"];

$this->load->view('_layout/_header.php', $headerVars)
?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Test
            <small>Add/Search or modify Tests</small>
            <small id="pageHeadingDetails"></small>
        </h1>

    </section>

    <!-- Main Content -->
    <section class="content">

    </section>
    <!--End Main Content-->

</div>


<?php
$footerVars['pg_footer_scripts'] = [];
$this->load->view('_layout/_footer.php', $footerVars)
?>

