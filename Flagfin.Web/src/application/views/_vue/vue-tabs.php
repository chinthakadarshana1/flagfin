<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/23/2019
 * Time: 2:49 PM
 */
?>


<!--
https://vuejs.org/v2/style-guide/
https://codepen.io/patrickodacre/pen/zxwWPO
https://router.vuejs.org/guide/essentials/passing-props.html#boolean-mode
-->

<style>

</style>

<script type="text/x-template" id="router-template">
    <h5 style="display:none">{{routeText}}</h5>
</script>

<script type="text/x-template" id="tab-container-template">

    <div class="nav-tabs-custom">
        <router-view></router-view>

        <!--tab links-->
        <ul class="nav nav-tabs">
            <li :id="tab.tabId+'-li'"
                :key="tab.tabId+'-li'"
                :class="[{ active: currentTab.tabId === tab.tabId },{hide : tab.isClosed}, tab.tabClass]"
                @click.self="currentTab = tab"
                v-for="tab in tabs">

                <a :href="'#/'+tab.tabId">
                    <span :class="tab.icon" class="nav-tab-icon"></span> {{tab.name}}
                </a>
                <span class="btn btn-box-tool close-tab" :class="['tab-close-button',{hide:tab.isLocked}]"
                      @click="closeTab(tab,$event)">
                        <i class="fa fa-times"></i>
                </span>
            </li>
        </ul>
        <!-- /.tab links-->

        <!--tab content-->
        <div class="tab-content">
            <component
                v-bind:is="tab.tabId"
                v-for="tab in tabs"
                :key="tab.tabId"
                :ref="tab.tabId"
                :isActive = "currentTab.tabId === tab.tabId"
                :id="tab.tabId"
                :tabId = "tab.tabId"
                :class="['tab-pane fade',{'active in' : currentTab.tabId === tab.tabId}]" >
            </component>
        </div>
        <!-- /.tab-content -->

    </div>
</script>


<script type="application/javascript">

    function vueTabContainer(tabs) {

        let ret = {};

        if(!tabs || !tabs.length ){
            throw new Error('Tabs not provided');
        }


        let routeMixins = {
            template: '#router-template',
            props : {
                tabId:String,
                cparams:String
            },
            methods:{
                init : function () {
                    this.$parent.setTab(this.tabId,this.$route.params.cparams);
                }
            },
            mounted : function () {
                this.init();
            }
        };

        // define a mixin object
        let tabsMixin = {
            props:{
                isActive : false,
                tabId : String,
                isClosed : Boolean
            },
            watch:{
                '$route.name': function (newVal, oldVal) {
                    if(newVal == this.tabId)
                        this.onTabLoad();
                }
            },
            methods: {
                onTabLoad : function () {
                    if(this.onLoad)
                        this.onLoad(this.onLoadParams);
                }
            },
            computed : {
            },
            mounted:function () {
                if(this.$route.name == this.tabId)
                    this.onTabLoad();
            }
        };

        let routes = [];

        //registering globally
        for(let i = 0 ;i<tabs.length;i++){
            tabs[i].component.mixins = [tabsMixin];
            tabs[i].routing.mixins = [routeMixins];

            Vue.component(tabs[i].tabId,tabs[i].component);

            let roteString = '/'+tabs[i].tabId+'/:cparams?';

            routes.push(
                { name:tabs[i].tabId, path: roteString, component: tabs[i].routing,props: {tabId : tabs[i].tabId } }
            );
        }

        const router = new VueRouter({
            routes : routes
        });

        Vue.component('tab-container', {
            template: '#tab-container-template',
            props: {
                tabs: {
                    type:Array,
                    required:true,
                    validator:function (value) {
                        return value.length > 0;
                    }
                }
            },
            data :function () {
                return {
                    currentTab: this.tabs[0]
                };
            },
            computed :{
            },
            watch:{
                "currentTab.tabId":function (value) {
                    this.currentTab.isClosed = false;
                }
            },
            methods:{
                setTab : function (tabId ,params) {
                    if(this.currentTab.tabId != tabId){
                        this.currentTab = this.tabs.find(d => d.tabId === tabId);
                    }

                    let currentComp = (this.$refs[tabId] && this.$refs[tabId].length>0) && this.$refs[tabId][0];

                    if(currentComp){
                        if(params){
                            let propList = params.split('&');
                            for(let i=0;i<propList.length;i++){
                                let keyValue = propList[i].split('=');
                                if(keyValue.length == 2){
                                    //query.name = 'dsdfsfd dsf' scenario
                                    let objectParam = keyValue[0].split('.');
                                    while(objectParam.length > 1){
                                        currentComp = currentComp[objectParam.shift()];
                                    }
                                    //currentComp[objectParam.shift()] = keyValue[1];
                                    //dynamically adding data property
                                    //https://vuejs.org/v2/guide/reactivity.html#Change-Detection-Caveats
                                    Vue.set(currentComp, objectParam.shift(), keyValue[1]);
                                }
                            }
                        }
                    }

                },
                closeTab:function (tab,event) {
                    tab.isClosed = true;
                    this.currentTab = this.tabs[0];
                    this.$router.replace("/"+this.tabs[0].tabId);
                    //router.go(-1);
                    event.preventDefault();
                }
            }

        });


        ret.router = router;

        //default tabs behaviours mixins
        ret.searhTabMixins = {
            methods: {
                searchClicked:function () {
                    let searchGridContainer = $("#"+this.tabId).find(".search-grid-container");
                    this.query.page_size = 10;
                    this.query.page_no = 1;
                    this.searchTable(1);
                    CommonFunctions.scrollTo( searchGridContainer);
                },
                toggleAdvancedSearch : function (event) {
                    this.isAdvancedSearch = !this.isAdvancedSearch;
                }
            }
        };



        return ret;
    }


</script>

