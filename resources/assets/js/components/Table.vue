<template>

    <div class="vtable">

        <filter-bar :filters="filters" :fields="fields"></filter-bar>

        <vuetable
                ref="vuetable"
                :api-url="url"
                :fields="fields"
                pagination-path=""
                :row-class="rowColor"
                :css="css.table"
                :append-params="moreParams"
                :multi-sort="true"
                @vuetable:loading="showLoader"
                @vuetable:loaded="hideLoader"
                @vuetable:pagination-data="onPaginationData"
                @vuetable:cell-clicked="onCellClicked"
        ></vuetable>
        <div class="vuetable-pagination">
            <div class="row">
                <div class="col-md-6">
                    <vuetable-pagination-info ref="paginationInfo"
                                              info-class="pagination-info"
                    ></vuetable-pagination-info>
                </div>
                <div class="col-md-6">
                    <vuetable-pagination ref="pagination"
                                         :css="css"
                                         @vuetable-pagination:change-page="onChangePage"
                    ></vuetable-pagination>
                </div>
            </div>
        </div>
        <delete :show=show :delete_url="delete_url"></delete>
    </div>
</template>

<script>
    // import accounting from 'accounting'
    //import moment from 'moment'
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import Vue from 'vue'
    import VueEvents from 'vue-events'
    import FilterBar from './FilterBar'
    import CustomActions from './CustomActions'
    import Delete from './Delete.vue'

    Vue.use(VueEvents)
    Vue.component('filter-bar', FilterBar)
    Vue.component('custom-actions', CustomActions)
    Vue.http.interceptors.push(function (request, next) {
        request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;
        next();
    });
    export default {
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo,
            Delete
        },
        props: ['columns', 'url', 'filters', 'threshold'],
        mounted: function () {

        },
        data: function () {
            return {
                show: false,
                delete_id: null,
                delete_url: null,
                loading: false,
                css: {
                    table: {
                        tableClass: 'table table-paper table-condensed table-bordered',
                        ascendingIcon: 'glyphicon glyphicon-chevron-up',
                        descendingIcon: 'glyphicon glyphicon-chevron-down'
                    },

                    wrapperClass: 'pagination',
                    activeClass: 'active',
                    disabledClass: 'disabled',
                    pageClass: 'page',
                    linkClass: 'link',

                    icons: {
                        first: 'glyphicon glyphicon-step-backward',
                        prev: 'glyphicon glyphicon-chevron-left',
                        next: 'glyphicon glyphicon-chevron-right',
                        last: 'glyphicon glyphicon-step-forward',
                    }
                },
                moreParams: {
                    paginate: 1
                }
            }
        },
        methods: {
            showLoader () {
                this.loading = true
            },
            hideLoader () {
                this.loading = false
            },
            rowColor: function (item) {
                return item.color;
            },
            destroyItem: function (item) {

            },
            onCellClicked: function (item) {
                console.log(item);
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
                this.$refs.paginationInfo.setPaginationData(paginationData)
            }
        },
        watch: {},
        computed: {
            fields: function () {
                return this.columns;
            }
        },
        events: {
            'filter-set' (filterText) {
                this.moreParams = {
                    filter: filterText,
                    paginate: 1
                }
                Vue.nextTick(() => this.$refs.vuetable.refresh())
            },
            'delete-show' (data) {
                this.delete_url = data;
                this.show = true;
            },
            'delete-hide' (data) {
                this.show = false;
            },
            'delete-finished' (data) {
                this.show = false;
                var params = this.$refs.vuetable.getAllQueryParams()
                this.moreParams = {
                    filter: params.filter,
                    paginate: 1
                }
                Vue.nextTick(() => this.$refs.vuetable.refresh())
            },
            'report_type' (report) {
                // GET /someUrl
                var params = this.$refs.vuetable.getAllQueryParams()
                var x = this.columns.filter(function (el) {
                    return el.visible == true;
                });
                params.paginate = 0;
                params.filetype = report;
                params.columns = x;
                var queryString = $.param(params);
                var uri = this.url + '?' + queryString;
                window.open(uri)

            },
            'filter-scope' (filterText) {
                this.moreParams = {
                    scope: filterText,
                    paginate: 1
                }
                Vue.nextTick(() => this.$refs.vuetable.refresh())
            },
            'filter-reset' () {
                this.moreParams = {
                    paginate: 1
                }
                Vue.nextTick(() => this.$refs.vuetable.refresh())
            },
            'field-toggle'(field){
                field.visible = !field.visible
                Vue.nextTick(() => this.$refs.vuetable.normalizeFields());
                console.log(this.$refs.vuetable.getAllQueryParams());
                //Emit column Collapse
                var x = this.columns.filter(function (el) {
                    return el.visible == true;
                });
                if (parseInt(x.length) > parseInt(this.threshold)) {
                    this.$emit('collapse');
                } else {
                    this.$emit('expand');
                }
            }
        }
    }


</script>
<style>
    .vtable {
        padding-bottom: 20px;
    }

    .pagination {
        margin: 0;
        float: right;
    }

    .pagination a {
        text-decoration: none;
        cursor: pointer;
    }

    .pagination a.page {
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 10px;
        margin-right: 2px;
    }

    .pagination a.page.active {
        color: white;
        background-color: #337ab7;
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 10px;
        margin-right: 2px;
    }

    .pagination a.btn-nav {
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 7px;
        margin-right: 2px;
    }

    .pagination a.btn-nav.disabled {
        color: lightgray;
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 7px;
        margin-right: 2px;
        cursor: not-allowed;
    }

    .pagination-info {
        float: left;
    }

    th.sortable:hover {
        text-decoration: none !important;
    }
</style>


