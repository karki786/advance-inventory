@extends('layouts.master')

@section('title')
    View Languages
@endsection
@section('heading')
    View Languages
@endsection


@section('content')
    <div id="app">

        <vtable url="language/items/filter" v-on:collapse="collapse" v-on:expand="expand" :columns="columns" threshold="9" multi-sort=true :filters="filters"></vtable>

    </div>

@endsection




@section('jquery')
    <script>
        var x = new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        name: 'language',
                        title: 'language',
                        visible: true
                    },
                    {
                        name: 'language_full',
                        title: 'language_full',
                        sortField: 'language_full',
                        visible: true
                    },{
                        name: 'translate',
                        title: 'translate',
                        sortField: 'translate',
                        visible: true
                    },
                    {
                        name: '__component:custom-actions',
                        title: 'Actions',
                        titleClass: 'text-center',
                        dataClass: 'text-center',
                        visible: true
                    }
                ],
                filters: [
                    {
                        scope: 'low',
                        text: 'View Low Stock',
                        icon: 'fa fa-minus-circle',
                        color: 'bg-red'
                    },
                    {
                        scope: 'restocks',
                        text: 'Most Restocks',
                        icon: 'fa fa-calendar',
                        color: 'bg-red'
                    }
                ]

            },
            methods: {
                expand(){
                    $('body').removeClass('sidebar-collapse')
                },
                collapse(){
                    $('body').addClass('sidebar-collapse')
                }
            }
        })
    </script>
@endsection