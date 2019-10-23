<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/30/2019
 * Time: 1:13 PM
 */
?>

<script type="text/x-template" id="vue-search-box-template">
    <!-- search box -->
    <div class="box box-default tab-sub-section">
        <div class="box-header with-border collapse-box-header-clickable" @keypress="enterpressed">
            <div class="freetext-search-container">
                <span class="box-title">{{title}}</span>
                <div class="freetext-search-container2" :class="{'disabled-click':isAdvancedSearch}">
                    <input type="text" class="form-control freetext-input" :placeholder="placeholder" v-model="query.free_text"/>
                    <span class="btn btn-default freetext-refresh-btn" @click="clearClicked">
                            <i class="fa fa-undo"></i>&nbsp;
                    </span>
                    <span class="btn btn-default freetext-search-btn" @click="searchClicked">
                            <i class="fa fa-search"></i>&nbsp;
                    </span>
                </div>
            </div>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool pull-right" @click="toggleAdvancedSearch">
                    <i class="fa" :class="searchBarBtnClass"></i>
                </button>
            </div>
        </div>
        <form class="form-horizontal" :class="{hidden:!isAdvancedSearch}">
            <component v-bind:is="advancedSearchComponent"
                       ref="advancedSearchComponent">
            </component>
        </form>
    </div>
    <!-- /search box-->
</script>

<script type="application/javascript">

    function vueSearchBox() {
        let ret = {};
        ret.events = {
            searchClicked : "vueSearchBox.searchClicked"
        };

        ret.component = Vue.component('vue-search-box', {
            template: '#vue-search-box-template',
            props: {
                advancedSearchComponent : {required:true},
                title :{required:true},
                placeholder:{required:true},
                isAdvanced : {default: false}
            },
            data :function () {
                return {
                    isAdvancedSearch : this.isAdvanced,
                    query : {
                        free_text : ""
                    }
                };
            },
            computed :{
                searchBarBtnClass : function () {
                    return !this.isAdvancedSearch ? "fa-angle-double-down" : "fa-angle-double-up";
                }
            },
            watch:{
                isAdvancedSearch : function (newVal, oldVal) {
                    if(newVal)
                        this.query.free_text = "";
                }
            },
            methods:{
                toggleAdvancedSearch:function () {
                    this.isAdvancedSearch = !this.isAdvancedSearch;
                },
                clearClicked : function () {
                    this.query.free_text = "";
                    this.$root.$emit(ret.events.searchClicked, this.query);
                },
                searchClicked : function () {
                    this.$root.$emit(ret.events.searchClicked, this.query);
                },
                enterpressed : function (e) {
                    if (e.keyCode === 13) {
                        this.searchClicked();
                    }
                }
            }
        });

        return ret;
    }

</script>


