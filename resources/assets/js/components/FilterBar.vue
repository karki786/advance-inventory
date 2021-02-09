<template>
    <div class="filter-bar">
        <div class="row">
            <div class="toolbar">
                <div class="col-md-4">
                    <div class="btn-group">
                        <button type="button" class="btn btn-flat btn-sm bg-purple dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-filter"></i> Filter Records <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li v-for="filter in filters" @click.prevent="doFilterScope(filter)"><a href="#"> <i
                                    v-bind:class="filter.icon"></i> {{filter.text}}</a></li>
                            <li class="divider" v-if="filters.length > 0"></li>
                            <li v-for="filter in defaultFilters" @click.prevent="doFilterScope(filter)"><a href="#"> <i
                                    v-bind:class="filter.icon"></i> {{filter.text}}</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-flat btn-sm bg-gray" @click.prevent="resetFilter"><i class="fa fa-eraser"></i>
                        Reset Filters
                    </button>
                </div>
                <div class="col-md-4 ">
                    <div class="btn-group">
                        <button type="button" class="btn btn-flat btn-sm bg-maroon dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-list-alt"></i> Toggle Columns <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li v-for="field in fields" @click.prevent="doToggleField(field)"><a href="#">

                                <i v-if="field.visible === true || field.visible === undefined || field.visible === 'undefined'"
                                   class="fa fa-eye"></i>
                                <i v-if="field.visible === false" class="fa fa-eye-slash"></i>
                                {{field.title}}

                            </a></li>


                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-flat btn-sm bg-blue dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-download"></i> Download Report <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a v-on:click="report('excel')" href="#"><i class="fa fa-file-excel-o"></i> Excel</a>
                                <a v-on:click="report('pdf')" href="#"><i class="fa fa-file-pdf-o"></i>PDF</a>
                                <!--
                                <a href="#"><i class="fa fa-envelope"></i> Email</a>
                                <a href="#"><i class="fa fa-clock-o"></i> Schedule Email Report</a>
                                -->
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-4 text-right">
                    <div class="form-group pull-right" style="margin-bottom: 0px;">
                        <div class="input-group">

                            <input type="text" v-model="filterText" class="form-control input-sm" @keyup.enter="doFilter"
                                   placeholder="name, nickname, or email">
                            <span class="input-group-btn">  <button class="btn btn-flat btn-sm bg-green"
                                                                    @click.prevent="doFilter">Go</button></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        props: ['filters', 'fields'],
        data () {
            return {
                filterText: '',
                scope: null,
                defaultFilters:[
                    {
                        scope: 'trash',
                        text: 'View Deleted Items',
                        icon: 'fa fa-trash',
                        color: 'bg-purple'
                    },

                    {
                        scope: 'latest',
                        text: 'Latest',
                        icon: 'fa fa-clock-o',
                        color: 'bg-red'
                    },
                    {
                        scope: 'lastupdate',
                        text: 'Last Updated',
                        icon: 'fa fa-clock-o',
                        color: 'bg-red'
                    },
                    {
                        scope: 'today',
                        text: 'Created Today',
                        icon: 'fa fa-clock-o',
                        color: 'bg-red'
                    },
                    {
                        scope: 'week',
                        text: 'Past Week',
                        icon: 'fa fa-calendar',
                        color: 'bg-red'
                    },
                    {
                        scope: 'month',
                        text: 'Past Month',
                        icon: 'fa fa-calendar',
                        color: 'bg-red'
                    }
                ]
            }
        },
        methods: {
            doFilter () {
                this.$events.fire('filter-set', this.filterText)
            },
            doFilterScope (filter) {
                this.scope = filter.scope;
                this.$events.fire('filter-scope', filter.scope)
            },
            doToggleField(field){
                this.field = !field;
                this.$events.fire('field-toggle', field)
            },
            report(report){
                this.$events.fire('report_type', report)
            },
            resetFilter () {
                this.filterText = ''
                this.scope = null;
                this.$events.fire('filter-reset')
            }
        }
    }
</script>
<style>
    .filter-type {
        padding-top: 7px;
        font-size: 15px;
        font-weight: bold;
    }

    .filter-bar {
        margin-bottom: 10px;
        background: #fcfcfc;
        padding: 5px;
        border: 1px solid #e7e6e8;
    }
</style>