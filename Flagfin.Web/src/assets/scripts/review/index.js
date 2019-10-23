"use strict";

//view model
function EmployeeModel(status){
    return {
        EmployeeId:0,
        UserName:"",
        Email:"",
        Password:"",
        ConfirmPassword:"",
        FirstName : "",
        LastName : "",
        sort_by:0
    };
}

//grid row template
let gridRowTemplate = Vue.component( 'employeeRow',{
        props: ['row'],
        template: '#gridRowTemplate',
        methods:{
            deleteRow : function () {
                this.$root.$emit('deleteEmployeeEvent', this.row);
            }
        }
    });

//grid
let employeeGrid = vueAjaxGrid();

//advanced search
let advancedSearchTemplate = Vue.component('employeeAdvancedSearch',{
        template: '#advancedSearchTemplate',
        data : function () {
            return{
                query : new window.EmployeeModel(-1)
            }
        },
        methods : {
            searchClicked : function () {
                this.$root.$emit("advancedSearch.searchClicked", this.query);
            },
            clearClicked : function () {
                this.query = new window.EmployeeModel(-1);
                this.$root.$emit("advancedSearch.searchClicked", this.query);
            }
        }
    });

//search box
let searchBox = vueSearchBox();

//delete template
Vue.component('deleteEmployeeTemplate',{
        template: '#deleteRowTemplate',
        data : function () {
            return {
                deleteModel : new window.EmployeeModel()
            }
        },
        methods:{
            deleteEmployee : function () {
                let container = $(this.$el).parents(".modal-dialog");

                window.CommonFunctions.cHiNLoader(true,container);
                window.CommonFunctions.ServerAjaxPost(window.pageVars.deleteUrl,this.deleteModel)
                    .then(function (data) {
                        if (data && data.length) {
                            //console.log(data);
                            window.CommonFunctions.cHiNLoader(false,container);
                            this.$parent.hide();
                            $.growl.notice({title: "Deleted Successfully", message: this.deleteModel.userName+" Deleted Successfully" });
                            this.$root.$emit('refreshSearch', null);
                        }else{
                            $.growl.warning({title: "Error Occurred", message: this.deleteModel.userName+" Couldn't Delete" });
                        }
                    }.bind(this));
            }
        },
        mounted:function () {
            this.$root.$on('deleteEmployeeEvent', data => {
                Vue.set(this, "deleteModel", data);
                this.$parent.show();
            });
        }
    });

//modal
let modal = vueModal();


//tab templates
let searchTab =  {
    name: "Search Employee",
    icon: "glyphicon glyphicon-search",
    tabId : "tabSearch",
    isClosed : false,
    isLocked :true,
    component: {
        template: "#tabSearchTemplate",
        data : function () {
                return {
                    tabText : "Search Employee",

                    //grid params
                    requiredColumns: [{name : "Employee ID",width:100},{name : "User Name"},
                                    {name : "Employee Name", width : 300},{name : "Email"},
                                    {name : "Actions", width : 175}],

                    query: {
                        page_size : window.MasterVars.DefaultPageSize,
                        page_no : 1,
                        free_text : "",
                        search_model : new EmployeeModel(-1)
                    },
                    apiUrl: window.pageVars.searchUrl,
                    gridRowTemplate : "employeeRow"
            };
        },
        methods: {
            searchTable: function (isInit) {
                this.query.page_no = 1;
                this.query.page_size = window.MasterVars.DefaultPageSize;
                this.$refs.employeesSearchGrid.searchAjax(isInit);
            }
        },
        mounted:function () {
            let searchGridContainer = $("#"+this.tabId).find(".search-grid-container");
            this.$root.$on(searchBox.events.searchClicked, data => {
                this.query.free_text = data.free_text;
                this.query.search_model = new EmployeeModel(-1);
                this.searchTable(1);
                CommonFunctions.scrollTo( searchGridContainer);
            });

            this.$root.$on('advancedSearch.searchClicked', data => {
                Vue.set(this.query, "search_model", data);
                this.query.free_text = "";
                this.searchTable(1);
                CommonFunctions.scrollTo( searchGridContainer);
            });

            this.$root.$on('refreshSearch', data => {
                this.query.search_model = new EmployeeModel(-1);
                this.query.free_text = "";
                this.searchTable(1);
            });
            this.searchTable(1);
        }
    },
    routing :{
        data : function () {
            return {
                routeText : "Search Employee"
            };
        }
    }
};

let viewTab = {
    name: 'View Employee',
    icon: 'fa fa-eye',
    tabId : 'tabView',
    isClosed : true,
    component: {
        template: '#tabViewtemplate',
        data : function () {
            return {
                viewModel : new EmployeeModel()
            };
        },
        methods:{
            loadView : function () {
                if(this.viewModel.EmployeeId){
                    let tabContainer = $("#"+this.tabId);
                    window.CommonFunctions.cHiNLoader(true,tabContainer);
                    window.CommonFunctions.ServerAjaxPost(window.pageVars.getUrl,this.viewModel)
                        .then(function (data) {
                            if (data) {
                                Vue.set(this, "viewModel", data);
                                window.CommonFunctions.cHiNLoader(false,tabContainer);
                            }else{
                                $.growl.warning({title: "Error occurred", message: "Couldn't find requested Employee" });
                            }
                        }.bind(this));
                }
            },
            onLoad : function (dt) {
                this.loadView();
            }
        }
    },
    routing :{
        data : function () {
            return {
                routeText : "View Employee"
            }
        }
    }
};

let editTab ={
    name: 'Modify Employee',
    icon: 'glyphicon glyphicon-edit',
    tabId : 'tabEdit',
    isClosed : true,
    component: {
        template: '#tabEditTemplate',
        data : function () {
            return {
                editModel: new window.EmployeeModel()
            };
        },
        methods:{
            loadEditTab : function () {
                if(this.editModel.EmployeeId){
                    let tabContainer = $("#"+this.tabId);
                    window.CommonFunctions.cHiNLoader(true,tabContainer);
                    window.CommonFunctions.ServerAjaxPost(window.pageVars.getUrl,this.editModel)
                        .then(function (data) {
                            if (data) {
                                Vue.set(this, "editModel", data);
                                window.CommonFunctions.cHiNLoader(false,tabContainer);
                            }else{
                                $.growl.warning({title: "Error occurred", message: "Couldn't find requested Employee" });
                            }
                        }.bind(this));
                }
            },
            saveClicked : function () {
                let tabContainer = $("#"+this.tabId);
                if(window.CommonFunctions.validateFeilds(tabContainer)){
                window.CommonFunctions.cHiNLoader(true,tabContainer);
                window.CommonFunctions.ServerAjaxPost(window.pageVars.saveUrl,this.editModel)
                    .then(function (data) {
                        if (data) {
                            Vue.set(this, "editModel", data);
                            window.CommonFunctions.cHiNLoader(false,tabContainer);
                            $.growl.notice({title: "Saved Successfully", message: this.editModel.UserName+" Saved Successfully" });
                            this.$root.$emit('refreshSearch', null);
                        }else{
                            $.growl.warning({title: "Error Occurred", message: this.editModel.UserName+" Couldn't Saved" });
                        }
                    }.bind(this));
                }
            },
            onLoad : function (dt) {
                this.loadEditTab();
            }
        }
    },
    routing :{
        data : function () {
            return {
                routeText : "Modify Employee"
            };
        }
    }
};

let addTab ={
    name: 'Add Employee',
    icon: 'glyphicon glyphicon-plus',
    tabId : 'tabAdd',
    isClosed : false,
    tabClass : "pull-right",
    isLocked :true,
    component: {
        template: '#tabAddTemplate',
        data : function () {
            return {
                addModel : new EmployeeModel()
            };
        },
        methods:{
            saveClicked : function () {
                let tabContainer = $("#"+this.tabId);
                if(window.CommonFunctions.validateFeilds(tabContainer)){
                    window.CommonFunctions.cHiNLoader(true,tabContainer);
                    window.CommonFunctions.ServerAjaxPost(window.pageVars.addUrl,this.addModel, "POST")
                        .then(function (data) {
                            if (data) {
                                Vue.set(this, "addModel", data);
                                window.CommonFunctions.cHiNLoader(false,tabContainer);
                                $.growl.notice({title: "Added Successfully", message: this.addModel.UserName+" Added Successfully" });
                                this.clearAddPanel();
                                this.$root.$emit('refreshSearch', null);
                            }else{
                                $.growl.warning({title: "Error Occurred", message: this.addModel.UserName+" Couldn't Saved" });
                            }
                        }.bind(this));
                }
            },
            clearAddPanel:function(){
                this.addModel= new EmployeeModel();
            }
        }
    },
    routing :{
        data : function () {
            return {
                routeText : "Add Employee"
            };
        }
    }
};

let tabs = [
    searchTab,
    viewTab,
    editTab,
    addTab
];

//tab conteiner
let tabContainer = vueTabContainer(tabs);


// bootstrap the app
let app = new Vue({
    el: '#divMainContent',
    data:{
        tabs : tabs
    },
    methods: {
    },
    router : tabContainer.router
});

