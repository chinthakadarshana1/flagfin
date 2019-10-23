<?php
/**
 * Created by PhpStorm.
 * Review: chinthakaf
 * Date: 3/22/2019
 * Time: 3:39 PM
 */
?>

<?php
$headerVars['pg_title'] = "Review";
$headerVars['pg_header_styles'] = ["assets/libs/simplepagination-1.6/simplePagination.css"];
$headerVars['pg_header_scripts'] = ["assets/libs/vue-2.6/vue.js" , "assets/libs/vue-2.6/vue-router.js"];
$headerVars['pg_header_breadcrumbs'] = ["fa fa-check", "Reviews"];

$this->load->view('_layout/_header.php', $headerVars)
?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reviews
            <small>Add/Search or Modify Reviews</small>
            <small></small>
        </h1>

    </section>

    <!-- Main Content -->
    <section class="content" id="divMainContent">
        <div class="row">
            <div class="col-md-12 padding-lf-0">

                <!-- tabs -->
                <tab-container :tabs="tabs">
                </tab-container>
                <!-- /tabs -->

            </div>
        </div>

        <vue-modal modal-template="deleteReviewTemplate"
                   ref="modalDelete"
                   modal-class="modal-danger"
                   modal-title="Delete Review">
        </vue-modal>
    </section>
    <!--End Main Content-->

</div>

<!-- vue-templates  -->

<!-- search-tab-templates  -->
<script type="text/x-template" id="tabSearchTemplate">
    <div>
        <vue-search-box
                advanced-search-component="reviewAdvancedSearch"
                title="Search Review"
                placeholder="Search By Review UserName/Name">
        </vue-search-box>

        <div class="row">
            <ajax-table
                    ref="reviewsSearchGrid"
                    :required-columns="requiredColumns"
                    :query="query"
                    :api-url="apiUrl"
                    :row-template = "gridRowTemplate">
            </ajax-table>
        </div>
    </div>
</script>

<script type="text/x-template" id="advancedSearchTemplate">
    <div>
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">ID</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" placeholder="ID" v-model="query.ReviewId">
                </div>
                <label class="col-sm-1 control-label">Review Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="Name" v-model="query.Name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Employee</label>
                <div class="col-sm-3">
                    <select2 class="form-control" v-model="query.EmployeeId" :options="select2Options">
                    </select2>
                </div>
                <label class="col-sm-1 control-label">Reviewer</label>
                <div class="col-sm-4">
                    <select2 class="form-control" v-model="query.ReviewerId" :options="select2Options">
                    </select2>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-2">
                    <select class="form-control" v-model="query.StatusId">
                        <option value="0">Any</option>
                        <option value="1">Pending</option>
                        <option value="2">Approved</option>
                        <option value="3">Rejected</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="box-footer">
            <button type="button" class="btn btn-info pull-right col-sm-1 form-actions-btn" @click="searchClicked">
                Search
            </button>
            <button type="button" class="btn btn-default pull-right col-sm-1 form-actions-btn" @click="clearClicked">
                Clear
            </button>
        </div>
    </div>
</script>

<script type="text/x-template" id="gridRowTemplate">
    <tr>
        <td>
            {{row.ReviewId}}
        </td>
        <td>
            {{row.Name}}
        </td>
        <td>
            {{row.EmployeeName}}
        </td>
        <td>
            {{row.ReviewerName}}
        </td>
        <td>
            <span class="label" :class="getStatusCss(row)">{{row.Status}}</span>
        </td>
        <td>
            <div class="btn-group table-action-group">
                <a class="btn btn-default btn-sm" :href="'#/tabView/viewModel.ReviewId='+row.ReviewId">
                    <i class="fa fa-eye"></i>
                </a>
                <a class="btn btn-default btn-sm" :href="'#/tabEdit/editModel.ReviewId='+row.ReviewId">
                    <i class="fa fa-edit"></i>
                </a>
            </div>
        </td>
    </tr>
</script>

<!-- view-tab-templates  -->
<script type="text/x-template" id="tabViewtemplate">

    <div class="box box-default tab-sub-section">
        <div class="box-header with-border collapse-box-header-clickable"
             data-widget="collapse">
            <h4 class="box-title">View Review</h4>
        </div>
        <form class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-2">
                        <span  class="form-control">{{viewModel.ReviewId}}</span>
                    </div>
                    <label class="col-sm-1 control-label">UserName</label>
                    <div class="col-sm-5">
                        <span class="form-control">{{viewModel.UserName}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-3">
                        <span  class="form-control">{{viewModel.FirstName}}</span>
                    </div>
                    <label class="col-sm-1 control-label">Last Name</label>
                    <div class="col-sm-4">
                        <span class="form-control">{{viewModel.LastName}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-8">
                        <span class="form-control">{{viewModel.Email}}</span>
                    </div>
                </div>
            </div>
        </form>

    </div>



</script>

<!-- edit-tab-templates  -->
<script type="text/x-template" id="tabEditTemplate">

    <div class="box box-default tab-sub-section">
        <div class="box-header with-border collapse-box-header-clickable"
             data-widget="collapse">
            <h4 class="box-title">Edit Review Details</h4>
        </div>
        <form class="form-horizontal">
            <div class="box-body">
                <div class="group-break" style="margin-top: 5px;">
                    Account Details
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Review ID</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" placeholder="ID" disabled="disabled"
                               v-model="editModel.ReviewId">
                    </div>
                    <label class="col-sm-1 control-label">User Name</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" placeholder="User Name" data-toggle="tooltip" title="Enter User Name"
                               v-validator="{regex:'[a-z]'}" v-model="editModel.UserName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control" placeholder="Password" v-model="editModel.Password"
                               v-validator="{regex:'.{5,}'}" data-toggle="tooltip" title="Enter Password">
                    </div>
                    <label class="col-sm-2 control-label">Re-enter Password</label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control" placeholder="Re-enter Password" v-model="editModel.ConfirmPassword"
                               v-validator="{regex:'.{5,}'}" :data-is-invalid="editModel.Password != editModel.ConfirmPassword" data-toggle="tooltip" title="Re-Enter Password">
                    </div>
                </div>
                <div class="group-break" style="margin-top: 5px;">
                    Review Details
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="First Name" v-model="editModel.FirstName"
                               v-validator="{regex:'[a-z]'}" data-toggle="tooltip" title="Enter FirstName">
                    </div>
                    <label class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Last Name" v-model="editModel.LastName"
                               v-validator="{regex:'[a-z]'}" data-toggle="tooltip" title="Enter LastName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="Review Email" data-toggle="tooltip" title="Enter Review Email"
                               v-validator="{regex:'email'}"  v-model="editModel.Email" >
                    </div>
                </div>


            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-info pull-right col-sm-1 form-actions-btn"
                @click="saveClicked" >
                    Save
                </button>
            </div>
        </form>
    </div>

</script>

<!-- add-tab-templates  -->
<script type="text/x-template" id="tabAddTemplate">

    <div class="box box-default tab-sub-section">
        <div class="box-header with-border collapse-box-header-clickable"
             data-widget="collapse">
            <h4 class="box-title">Add Review Details</h4>
        </div>
        <form class="form-horizontal">
            <div class="box-body">
                <div class="group-break" style="margin-top: 5px;">
                    Review Details
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Review ID</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" placeholder="ID" disabled="disabled">
                    </div>
                    <label class="col-sm-1 control-label">Review Name</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" placeholder="Review Name" data-toggle="tooltip" title="Enter Review Name"
                               v-validator="{regex:'[a-z]'}" v-model="addModel.Name">
                    </div>
                </div>
                <div class="group-break" style="margin-top: 5px;">
                    Employee Details
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Employee</label>
                    <div class="col-sm-3">
                        <select2 class="form-control" v-model="addModel.EmployeeId" :options="select2Options">
                        </select2>
                    </div>
                    <label class="col-sm-2 control-label">Reviewer</label>
                    <div class="col-sm-3">
                        <select2 class="form-control" v-model="addModel.ReviewerId" :options="select2Options">
                        </select2>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Comment</label>
                    <div class="col-sm-8">
                        <textarea class="form-control"  v-model="addModel.Comment"></textarea>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-info pull-right col-sm-1 form-actions-btn"
                        @click="saveClicked">
                    Save
                </button>
            </div>
        </form>
    </div>
</script>

<!-- delete template-->
<script type="text/x-template" id="deleteRowTemplate">
    <div>
        <div class="modal-body">
            <p>
                You are about to delete the Review : <b>{{deleteModel.review_name}}</b>
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger form-actions-btn btn-outline" @click="deleteReview">Delete</button>
            <button type="button" class="btn btn-default form-actions-btn btn-outline" data-dismiss="modal">Close</button>
        </div>
    </div>
</script>

<!-- /vue-templates -->


<script>
    var pageVars = {
        searchUrl : '<?php echo API_URL.'Review/Search' ?>',
        getUrl : '<?php echo API_URL.'Review/Get' ?>',
        saveUrl : '<?php echo API_URL.'Review/Update' ?>',
        addUrl : '<?php echo API_URL.'Review/Add' ?>',
        deleteUrl : '<?php echo API_URL.'Review/Delete' ?>',
        employeeSearchUrl : '<?php echo API_URL.'Employee/Search' ?>'
    };
</script>

<?php
$footerVars['pg_footer_scripts'] = ["assets/libs/simplepagination-1.6/jquery.simplePagination.js",
    "assets/scripts/review/index.js"];
$footerVars['pg_vue_components'] = ["_vue/vue-tabs",
    "_vue/vue-ajax-grid","_vue/vue-validator","_vue/vue-search-box",
    "_vue/vue-modal","_vue/vue-select2"];
$this->load->view('_layout/_footer.php', $footerVars)
?>



