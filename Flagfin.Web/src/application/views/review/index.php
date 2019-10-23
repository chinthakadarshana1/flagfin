<?php
/**
 * Created by PhpStorm.
 * Employee: chinthakaf
 * Date: 3/22/2019
 * Time: 3:39 PM
 */
?>

<?php
$headerVars['pg_title'] = "Employee";
$headerVars['pg_header_styles'] = ["assets/libs/simplepagination-1.6/simplePagination.css"];
$headerVars['pg_header_scripts'] = ["assets/libs/vue-2.6/vue.js" , "assets/libs/vue-2.6/vue-router.js"];
$headerVars['pg_header_breadcrumbs'] = ["fa fa-user", "Employees"];

$this->load->view('_layout/_header.php', $headerVars)
?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employees
            <small>Add/Search or Modify Employees</small>
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

        <vue-modal modal-template="deleteEmployeeTemplate"
                   ref="modalDelete"
                   modal-class="modal-danger"
                   modal-title="Delete Employee">
        </vue-modal>
    </section>
    <!--End Main Content-->

</div>

<!-- vue-templates  -->

<!-- search-tab-templates  -->
<script type="text/x-template" id="tabSearchTemplate">
    <div>
        <vue-search-box
                advanced-search-component="employeeAdvancedSearch"
                title="Search Employee"
                placeholder="Search By Employee UserName/Name">
        </vue-search-box>

        <div class="row">
            <ajax-table
                    ref="employeesSearchGrid"
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
                    <input type="text" class="form-control" placeholder="ID" v-model="query.EmployeeId">
                </div>
                <label class="col-sm-1 control-label">User Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="Name" v-model="query.UserName">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Employee Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="Employee Name" v-model="query.FirstName">
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
            {{row.EmployeeId}}
        </td>
        <td>
            {{row.UserName}}
        </td>
        <td>
            {{row.FirstName}} {{row.LastName}}
        </td>
        <td>
            {{row.Email}}
        </td>
        <td>
            <div class="btn-group table-action-group">
                <a class="btn btn-default btn-sm" :href="'#/tabView/viewModel.EmployeeId='+row.EmployeeId">
                    <i class="fa fa-eye"></i>
                </a>
                <a class="btn btn-default btn-sm" :href="'#/tabEdit/editModel.EmployeeId='+row.EmployeeId">
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
            <h4 class="box-title">View Employee</h4>
        </div>
        <form class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-2">
                        <span  class="form-control">{{viewModel.EmployeeId}}</span>
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
            <h4 class="box-title">Edit Employee Details</h4>
        </div>
        <form class="form-horizontal">
            <div class="box-body">
                <div class="group-break" style="margin-top: 5px;">
                    Account Details
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Employee ID</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" placeholder="ID" disabled="disabled"
                               v-model="editModel.EmployeeId">
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
                    Employee Details
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
                        <input type="text" class="form-control" placeholder="Employee Email" data-toggle="tooltip" title="Enter Employee Email"
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
            <h4 class="box-title">Add Employee Details</h4>
        </div>
        <form class="form-horizontal">
            <div class="box-body">
                <div class="group-break" style="margin-top: 5px;">
                    Account Details
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Employee ID</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" placeholder="ID" disabled="disabled">
                    </div>
                    <label class="col-sm-1 control-label">User Name</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" placeholder="User Name" data-toggle="tooltip" title="Enter User Name"
                               v-validator="{regex:'[a-z]'}" v-model="addModel.UserName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control" placeholder="Password" v-model="addModel.Password"
                               v-validator="{regex:'.{5,}'}" data-toggle="tooltip" title="Enter Password">
                    </div>
                    <label class="col-sm-2 control-label">Re-enter Password</label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control" placeholder="Re-enter Password" v-model="addModel.ConfirmPassword"
                               v-validator="{regex:'.{5,}'}" :data-is-invalid="addModel.Password != addModel.ConfirmPassword" data-toggle="tooltip" title="Re-Enter Password">
                    </div>
                </div>
                <div class="group-break" style="margin-top: 5px;">
                    Employee Details
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="First Name" v-model="addModel.FirstName"
                               v-validator="{regex:'[a-z]'}" data-toggle="tooltip" title="Enter FirstName">
                    </div>
                    <label class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Last Name" v-model="addModel.LastName"
                               v-validator="{regex:'[a-z]'}" data-toggle="tooltip" title="Enter LastName">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="Employee Email" data-toggle="tooltip" title="Enter Employee Email"
                               v-validator="{regex:'email'}"  v-model="addModel.Email" >
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
                You are about to delete the Employee : <b>{{deleteModel.employee_name}}</b>
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger form-actions-btn btn-outline" @click="deleteEmployee">Delete</button>
            <button type="button" class="btn btn-default form-actions-btn btn-outline" data-dismiss="modal">Close</button>
        </div>
    </div>
</script>

<!-- /vue-templates -->


<script>
    var pageVars = {
        searchUrl : '<?php echo API_URL.'Employee/SearchUser' ?>',
        getUrl : '<?php echo API_URL.'Employee/Get' ?>',
        saveUrl : '<?php echo API_URL.'Employee/Update' ?>',
        addUrl : '<?php echo API_URL.'Employee/Add' ?>',
        deleteUrl : '<?php echo API_URL.'Employee/Delete' ?>'
    };
</script>

<?php
$footerVars['pg_footer_scripts'] = ["assets/libs/simplepagination-1.6/jquery.simplePagination.js",
    "assets/scripts/employee/employee.js"];
$footerVars['pg_vue_components'] = ["_vue/vue-tabs",
    "_vue/vue-ajax-grid","_vue/vue-validator","_vue/vue-search-box",
    "_vue/vue-modal"];
$this->load->view('_layout/_footer.php', $footerVars)
?>



