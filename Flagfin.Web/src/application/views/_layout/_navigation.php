<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/22/2019
 * Time: 4:23 PM
 */
?>

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <div class="sidebar-scroll-container">
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left info">
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu tree" data-widget="tree">
                <li>
                    <a href="<?php echo base_url(); ?>index.php/home">
                        <i class="fa fa-home"></i> <span>Home</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url(); ?>index.php/reviews">
                        <i class="fa fa-check"></i> <span>Reviews</span>
                    </a>
                </li>

                <li>
                    <a href="<?php echo base_url(); ?>index.php/employee">
                        <i class="fa fa-user"></i> <span>Employees</span>
                    </a>
                </li>
            </ul>
        </section>
    </div>
    <!-- /.sidebar -->
</aside>
