<?php
/**
 * Created by PhpStorm.
 * User: chinthakaf
 * Date: 3/23/2019
 * Time: 3:04 PM
 */
?>


<script type="text/x-template" id="ajax-table-template">
    <!--result list-->
    <div class="search-grid-container">
        <div class="table-container">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th v-for="col in columns" :width="col.width">

                        <input :id="'chkSelectAll'+_uid" v-if="col.type && col.type=='chkbox'"
                               type="checkbox" class="custom-checkbox-sm"
                                v-model="isSelectAll"/>
                        <label v-if="col.type && col.type=='chkbox'" :for="'chkSelectAll'+_uid"></label>

                        <span v-if="!col.type">{{ col.name | capitalize }}</span>
                    </th>
                </tr>
                </thead>

                <tbody>
                    <component
                            v-bind:is="rowTemplate"
                            v-for="(row,index) in rows"
                            :ref="'row-'+index"
                            :key="'row-'+index"
                            :row="row">
                    </component>
                </tbody>
            </table>
        </div>
        <div class="box-footer grid-footer">
            <div class="col-sm-6 pull-left hidden-xs">
                <div class="grid-current-page">Page <span id="currentPage">{{query.page_no}}</span> of
                    <span>{{query.total_pages}}</span></div>
                <div class="grid-total-rows-container">
                    total <span>{{query.total_records}}</span> records
                </div>
                <div class="grid-rows-div">
                    <label for="cmbRowsPerPage">Rows :</label>
                    <select v-model="query.page_size" class="form-control rows-per-pege-cmb">
                        <option>10</option>
                        <option>20</option>
                        <option>40</option>
                    </select>
                </div>
                <div class="table-paging-goto">
                    <label>page </label>
                    <input type="text" v-model="query.page_no" class="form-control go-to-page-txt">
                </div>
            </div>
            <div class="col-sm-5 pull-right pagination-container">
            </div>
        </div>
    </div>
    <!-- /.result list-->
</script>

<script type="application/javascript">

    function vueAjaxGrid() {
        const defaultPageSizeKey = "vue-ajax-grid-page-size";
        let defaultPageSize = 10;

        // register the grid component
        let componant = Vue.component('ajax-table', {
            template: '#ajax-table-template',
            props: {
                requiredColumns: {
                    type:Array,
                    required:true,
                    validator:function (value) {
                        return value.length > 0;
                    }
                },
                query: {
                    page_size: 10,
                    page_no: 1,
                    total_records : 0,
                    total_pages : 0
                },
                rowTemplate : {
                    required:true
                },
                apiUrl: String
            },
            data: function () {
                return {
                    apiUrlString: this.apiUrl,
                    columns: this.requiredColumns,
                    isSelectAll : false,
                    rows: []
                };
            },
            filters: {
                capitalize: function (str) {
                    return str.charAt(0).toUpperCase() + str.slice(1)
                }
            },
            computed :{
            },
            watch: {
                "query.page_size": function (newVal, oldVal) {
                    if (newVal != oldVal) {
                        localStorage.setItem(defaultPageSizeKey,newVal+"");
                        this.query.page_no = 1;
                        this.searchAjax();
                        this.bindPaging();
                    }
                },
                "query.page_no": function (newVal, oldVal) {
                    if (newVal != oldVal) {
                        this.searchAjax();
                        this.bindPaging(newVal);
                    }
                },
                "isSelectAll" : function (newVal, oldVal) {
                    for(let i=0;i<this.rows.length;i++){
                        Vue.set(this.rows[i],'is_selected',newVal);
                    }
                }
            },
            methods: {
                searchAjax: function (isInit) {
                    let container = $(this.$el);
                    window.CommonFunctions.cHiNLoader(true,container);
                    window.CommonFunctions.ServerAjaxPost(this.apiUrlString,this.query)
                        .then(function (data) {
                            if (data) {
                                //console.log(data);
                                let rowData = data.data;

                                this.query.page_no = data.page_no;
                                this.query.page_size = data.page_size;
                                this.query.total_records = data.total_records;

                                this.rows = rowData;
                                if (isInit)
                                    this.bindPaging();
                                window.CommonFunctions.cHiNLoader(false,container);
                            }
                        }.bind(this));
                },
                bindPaging: function (page_no) {
                    let paginationDiv = $(this.$el).find(".pagination-container");
                    if (!page_no) {
                        pagination = paginationDiv.pagination({
                            items: this.query.total_records,
                            itemsOnPage: this.query.page_size,
                            displayedPages: 2,
                            hrefTextPrefix: "#page-",
                            useAnchors: false,
                            cssStyle: "light-theme",
                            onPageClick: function (pgN, ev) {
                                this.query.page_no = pgN;
                            }.bind(this)
                        });
                    }
                    else {
                        pagination = paginationDiv.pagination('selectPage', page_no);
                    }
                    this.query.total_pages = paginationDiv.pagination('getPagesCount');
                }
            },
            mounted: function () {
                //this.searchAjax(1);
            }
        });
        return componant;
    }

</script>
