"use strict";

//view model
function TestModel(){
    return {
        test_id:"",
        name:"",
        email:"",
        sort_by:0
    };
}

//grid row template
let gridRowTemplate = Vue.component( 'testRow',{
        props: ['row'],
        template: '#gridRowTemplate'
    });

//grid
let testGrid = vueAjaxGrid();

//advanced search
let advancedSearchTemplate = Vue.component('testAdvancedSearch',{
        template: '#advancedSearchTemplate',
        data : function () {
            return{
                query : new window.TestModel()
            }
        },
        methods : {
            searchClicked : function () {
                this.$root.$emit("advancedSearch.searchClicked", this.query);
            },
            clearClicked : function () {
                this.query = new window.TestModel();
                this.$root.$emit("advancedSearch.searchClicked", this.query);
            }
        }
    });

//search box
let searchBox = vueSearchBox();


//tab templates
let searchTab =  {
    name: "Search Test",
    icon: "glyphicon glyphicon-search",
    tabId : "tabSearch",
    isClosed : false,
    isLocked :true,
    component: {
        template: "#tabSearchTemplate",
        data : function () {
                return {
                    tabText : "Search Test",

                    //grid params
                    requiredColumns: [{name : "Test ID",width:75},{name : "Name"},
                                    {name : "Email"},{name : "Created Date", width : 175},
                                    {name : "Actions", width : 120}],

                    query: {
                        page_size : window.MasterVars.DefaultPageSize,
                        page_no : 1,
                        free_text : "",
                        search_model : new TestModel()
                    },
                    apiUrl: window.pageVars.searchUrl,
                    gridRowTemplate : "testRow"
            };
        },
        methods: {
            searchTable: function (isInit) {
                this.query.page_no = 1;
                this.query.page_size = window.MasterVars.DefaultPageSize;
                this.$refs.testsSearchGrid.searchAjax(isInit);
            }
        },
        mounted:function () {
            let searchGridContainer = $("#"+this.tabId).find(".search-grid-container");
            this.$root.$on(searchBox.events.searchClicked, data => {
                this.query.free_text = data.free_text;
                this.query.search_model = new TestModel();
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
                this.query.search_model = new TestModel();
                this.query.free_text = "";
                this.searchTable(1);
            });
            this.searchTable(1);
        }
    },
    routing :{
        data : function () {
            return {
                routeText : "Search Test"
            };
        }
    }
};

let viewTab = {
    name: 'View Test',
    icon: 'fa fa-eye',
    tabId : 'tabView',
    isClosed : true,
    component: {
        template: '#tabViewtemplate',
        data : function () {
            return {
                viewModel : new TestModel()
            };
        },
        methods:{
            loadView : function () {
                if(this.viewModel.test_id){
                    let tabContainer = $("#"+this.tabId);
                    window.CommonFunctions.cHiNLoader(true,tabContainer);
                    window.CommonFunctions.ServerAjaxPost(window.pageVars.getUrl,this.viewModel)
                        .then(function (data) {
                            if (data && data.length) {
                                Vue.set(this, "viewModel", data[0]);
                                window.CommonFunctions.cHiNLoader(false,tabContainer);
                            }else{
                                $.growl.warning({title: "Error occurred", message: "Couldn't find requested Test" });
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
                routeText : "View Test"
            }
        }
    }
};

let editTab ={
    name: 'Modify Test',
    icon: 'glyphicon glyphicon-edit',
    tabId : 'tabEdit',
    isClosed : true,
    component: {
        template: '#tabEditTemplate',
        data : function () {
            return {
                editModel: new window.TestModel()
            };
        },
        methods:{
            loadEditTab : function () {
                if(this.editModel.test_id){
                    let tabContainer = $("#"+this.tabId);
                    window.CommonFunctions.cHiNLoader(true,tabContainer);
                    window.CommonFunctions.ServerAjaxPost(window.pageVars.getUrl,this.editModel)
                        .then(function (data) {
                            if (data && data.length) {
                                Vue.set(this, "editModel", data[0]);
                                window.CommonFunctions.cHiNLoader(false,tabContainer);
                            }else{
                                $.growl.warning({title: "Error occurred", message: "Couldn't find requested Test" });
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
                        if (data && data.length) {
                            Vue.set(this, "editModel", data[0]);
                            window.CommonFunctions.cHiNLoader(false,tabContainer);
                            $.growl.notice({title: "Saved Successfully", message: this.editModel.name+" Saved Successfully" });
                            this.$root.$emit('refreshSearch', null);
                        }else{
                            $.growl.warning({title: "Error Occurred", message: this.editModel.name+" Couldn't Saved" });
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
                routeText : "Modify Test"
            };
        }
    }
};

let addTab ={
    name: 'Add Test',
    icon: 'glyphicon glyphicon-plus',
    tabId : 'tabAdd',
    isClosed : false,
    tabClass : "pull-right",
    isLocked :true,
    component: {
        template: '#tabAddTemplate',
        data : function () {
            return {
                addModel : new TestModel()
            };
        },
        methods:{
            saveClicked : function () {
                let tabContainer = $("#"+this.tabId);
                if(window.CommonFunctions.validateFeilds(tabContainer)){
                    window.CommonFunctions.cHiNLoader(true,tabContainer);
                    window.CommonFunctions.ServerAjaxPost(window.pageVars.addUrl,this.addModel)
                        .then(function (data) {
                            if (data && data.length) {
                                Vue.set(this, "addModel", data[0]);
                                window.CommonFunctions.cHiNLoader(false,tabContainer);
                                $.growl.notice({title: "Added Successfully", message: this.addModel.name+" Added Successfully" });
                                this.clearAddPanel();
                                this.$root.$emit('refreshSearch', null);
                            }else{
                                $.growl.warning({title: "Error Occurred", message: this.addModel.name+" Couldn't Saved" });
                            }
                        }.bind(this));
                }
            },
            clearAddPanel:function(){
                this.addModel= new TestModel();
            }
        }
    },
    routing :{
        data : function () {
            return {
                routeText : "Add Test"
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
