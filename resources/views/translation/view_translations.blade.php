@extends('layouts.master')

@section('title')
    View Translations
@endsection
@section('heading')
    View Translations
@endsection


@section('content')
         <a href="{{action('TranslationController@compile')}}" class="btn btn-flat bg-green btn-block">Compile Translations</a>
    <div id="app">

        <vtable url="translations/items/filter" v-on:collapse="collapse" v-on:expand="expand" :columns="columns" threshold="9" multi-sort=true :filters="filters"></vtable>

    </div>

@endsection




@section('jquery')
    <script>
        var x = new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        name: 'module',
                        title: 'module',
                        visible: true
                    },
                    {
                        name: 'language',
                        title: 'language',
                        sortField: 'language',
                        visible: true
                    },{
                        name: 'orig_lang',
                        title: 'Original Text',
                        sortField: 'orig_lang',
                        visible: true
                    },{
                        name: 'trans_lang',
                        title: 'Translated Text',
                        sortField: 'trans_lang',
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