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
$headerVars['pg_header_styles'] = ["assets/styles/home/index.css"];
$headerVars['pg_header_scripts'] = [];
$headerVars['pg_header_breadcrumbs'] = ["fa fa-home", "Home"];

$this->load->view('_layout/_header.php', $headerVars)
?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Home
            <small>Employee Review Home</small>
            <small id="pageHeadingDetails"></small>
        </h1>

    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="col-md-12" id="tileContainer">
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3 id="lblPendingReviews"></h3>

                        <p>Pending Reviews</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-folder-open"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>index.php/review" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 id="lblApprovedReviews"></h3>

                        <p>Approved Reviews</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>index.php/review" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3 id="lblRejectedReviews"></h3>

                        <p>Rejected Reviews</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-thumbs-down"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>index.php/review" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!--End Main Content-->

</div>


<script>
    var pageVars = {
        dashboardUrl : '<?php echo API_URL.'Employee/GetReviewCounts' ?>'
    };
</script>

<?php
$footerVars['pg_footer_scripts'] = ["assets/scripts/home/index.js"];
$this->load->view('_layout/_footer.php', $footerVars)
?>

