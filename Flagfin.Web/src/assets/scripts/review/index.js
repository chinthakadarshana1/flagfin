"use strict";

//view model
function ReviewModel(status){
    return {
        ReviewId:0,
        ReviewerId:0,
        ReviewerName:"",
        EmployeeId:0,
        EmployeeName:"",
        Status : "",
        StatusId : 0,
        Comment : "",
        Name:"",
        sort_by:0
    };
}

//grid row template
let gridRowTemplate = Vue.component( 'reviewRow',{
        props: ['row'],
        template: '#gridRowTemplate',
        methods:{
            deleteRow : function () {
                this.$root.$emit('deleteReviewEvent', this.row);
            },
            getStatusCss : function (row) {
                var ret = "label-danger";
                if(row.StatusId == 1)
                    ret= "label-warning";
                else if(row.StatusId == 2)
                    ret= "label-success";
                return ret;
            },
        }
    });

//grid
let reviewGrid = vueAjaxGrid();

//advanced search
let advancedSearchTemplate = Vue.component('reviewAdvancedSearch',{
        template: '#advancedSearchTemplate',
        data : function () {
            return{
                query : new window.ReviewModel(-1),
                select2Options:{
                    minimumInputLength: 2,
                    ajax: window.employeeSearchAjax()
                }
            }
        },
        methods : {
            searchClicked : function () {
                this.$root.$emit("advancedSearch.searchClicked", this.query);
            },
            clearClicked : function () {
                this.query = new window.ReviewModel(-1);
                this.$root.$emit("advancedSearch.searchClicked", this.query);
            }
        }
    });

//search box
let searchBox = vueSearchBox();

//delete template
Vue.component('deleteReviewTemplate',{
        template: '#deleteRowTemplate',
        data : function () {
            return {
                deleteModel : new window.ReviewModel()
            }
        },
        methods:{
            deleteReview : function () {
                let container = $(this.$el).parents(".modal-dialog");

                window.CommonFunctions.cHiNLoader(true,container);
                window.CommonFunctions.ServerAjaxPost(window.pageVars.deleteUrl,this.deleteModel)
                    .then(function (data) {
                        if (data && data.length) {
                            //console.log(data);
                            window.CommonFunctions.cHiNLoader(false,container);
                            this.$parent.hide();
                            $.growl.notice({title: "Deleted Successfully", message: this.deleteModel.ReviewId+" Deleted Successfully" });
                            this.$root.$emit('refreshSearch', null);
                        }else{
                            $.growl.warning({title: "Error Occurred", message: this.deleteModel.ReviewId+" Couldn't Delete" });
                        }
                    }.bind(this));
            }
        },
        mounted:function () {
            this.$root.$on('deleteReviewEvent', data => {
                Vue.set(this, "deleteModel", data);
                this.$parent.show();
            });
        }
    });

//modal
let modal = vueModal();


//tab templates
let searchTab =  {
    name: "Search Review",
    icon: "glyphicon glyphicon-search",
    tabId : "tabSearch",
    isClosed : false,
    isLocked :true,
    component: {
        template: "#tabSearchTemplate",
        data : function () {
                return {
                    tabText : "Search Review",

                    //grid params
                    requiredColumns: [{name : "Review ID",width:100},{name : "Review",width : 200},{name : "Employee",width : 200},
                                    {name : "Reviewer", width : 200},{name : "Status"},
                                    {name : "Actions", width : 175}],

                    query: {
                        page_size : window.MasterVars.DefaultPageSize,
                        page_no : 1,
                        free_text : "",
                        search_model : new ReviewModel(-1)
                    },
                    apiUrl: window.pageVars.searchUrl,
                    gridRowTemplate : "reviewRow"
            };
        },
        methods: {
            searchTable: function (isInit) {
                this.query.page_no = 1;
                this.query.page_size = window.MasterVars.DefaultPageSize;
                this.$refs.reviewsSearchGrid.searchAjax(isInit);
            }
        },
        mounted:function () {
            let searchGridContainer = $("#"+this.tabId).find(".search-grid-container");
            this.$root.$on(searchBox.events.searchClicked, data => {
                this.query.free_text = data.free_text;
                this.query.search_model = new ReviewModel(-1);
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
                this.query.search_model = new ReviewModel(-1);
                this.query.free_text = "";
                this.searchTable(1);
            });
            this.searchTable(1);
        }
    },
    routing :{
        data : function () {
            return {
                routeText : "Search Review"
            };
        }
    }
};

let viewTab = {
    name: 'View Review',
    icon: 'fa fa-eye',
    tabId : 'tabView',
    isClosed : true,
    component: {
        template: '#tabViewtemplate',
        data : function () {
            return {
                viewModel : new ReviewModel()
            };
        },
        methods:{
            loadView : function () {
                if(this.viewModel.ReviewId){
                    let tabContainer = $("#"+this.tabId);
                    window.CommonFunctions.cHiNLoader(true,tabContainer);
                    window.CommonFunctions.ServerAjaxPost(window.pageVars.getUrl,this.viewModel)
                        .then(function (data) {
                            if (data) {
                                Vue.set(this, "viewModel", data);
                                window.CommonFunctions.cHiNLoader(false,tabContainer);
                            }else{
                                $.growl.warning({title: "Error occurred", message: "Couldn't find requested Review" });
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
                routeText : "View Review"
            }
        }
    }
};

let editTab ={
    name: 'Modify Review',
    icon: 'glyphicon glyphicon-edit',
    tabId : 'tabEdit',
    isClosed : true,
    component: {
        template: '#tabEditTemplate',
        data : function () {
            return {
                editModel: new window.ReviewModel(),
                select2Options:{
                    minimumInputLength: 2,
                    ajax: window.employeeSearchAjax()
                }
            };
        },
        methods:{
            loadEditTab : function () {
                if(this.editModel.ReviewId){
                    let tabContainer = $("#"+this.tabId);
                    window.CommonFunctions.cHiNLoader(true,tabContainer);
                    window.CommonFunctions.ServerAjaxPost(window.pageVars.getUrl,this.editModel)
                        .then(function (data) {
                            if (data) {
                                Vue.set(this, "editModel", data);
                                window.CommonFunctions.cHiNLoader(false,tabContainer);
                            }else{
                                $.growl.warning({title: "Error occurred", message: "Couldn't find requested Review" });
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
                            $.growl.notice({title: "Saved Successfully", message: this.editModel.ReviewId+" Saved Successfully" });
                            this.$root.$emit('refreshSearch', null);
                        }else{
                            $.growl.warning({title: "Error Occurred", message: this.editModel.ReviewId+" Couldn't Saved" });
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
                routeText : "Modify Review"
            };
        }
    }
};

let addTab ={
    name: 'Add Review',
    icon: 'glyphicon glyphicon-plus',
    tabId : 'tabAdd',
    isClosed : false,
    tabClass : "pull-right",
    isLocked :true,
    component: {
        template: '#tabAddTemplate',
        data : function () {
            return {
                addModel : new ReviewModel(),
                select2Options:{
                    minimumInputLength: 2,
                    ajax: window.employeeSearchAjax()
                }
            };
        },
        methods:{
            saveClicked : function () {
                let tabContainer = $("#"+this.tabId);
                if(window.CommonFunctions.validateFeilds(tabContainer)){
                    window.CommonFunctions.cHiNLoader(true,tabContainer);
                    this.addModel.StatusId = 1;
                    window.CommonFunctions.ServerAjaxPost(window.pageVars.addUrl,this.addModel, "POST")
                        .then(function (data) {
                            if (data) {
                                Vue.set(this, "addModel", data);
                                window.CommonFunctions.cHiNLoader(false,tabContainer);
                                $.growl.notice({title: "Added Successfully", message: this.addModel.Name+" Added Successfully" });
                                this.clearAddPanel();
                                this.$root.$emit('refreshSearch', null);
                            }else{
                                $.growl.warning({title: "Error Occurred", message: this.addModel.Name+" Couldn't Saved" });
                            }
                        }.bind(this));
                }
            },
            clearAddPanel:function(){
                this.addModel= new ReviewModel();
            }
        }
    },
    routing :{
        data : function () {
            return {
                routeText : "Add Review"
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


function employeeSearchAjax() {
    let ajaxOptions = {
        url: window.pageVars.employeeSearchUrl,
        dataType: 'json',
        headers : {
            'Authorization': 'Bearer '+window.MasterVars.ApiToken,
            "Content-Type" : "application/json"
        },
        processResults: function (data) {
            if(data && data.data.length>0){
                let employees = data.data;
                return {
                    results: $.map(employees, function (item) {
                        return {
                            text: item.UserName,
                            id: item.EmployeeId
                        }
                    })
                };
            }
        }
    };
    return ajaxOptions;
}
