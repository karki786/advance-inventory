@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('category.Product Categories')
@endsection

@section('sidebar')

@endsection

@section('heading')
    @lang('category.Product Categories')
@endsection
@section('content')
    <div id="app">
        <vtable url="{{action('CategoryController@table')}}" :columns="columns" :filters="filters"></vtable>
    </div>
@endsection

@section('jquery')
    <script>
        new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        name: 'categoryName',
                        title:  '{{trans('category.Category Name')}}' ,
                        visible:true
                    }, {
                        name: 'categoryDescription',
                        title: '{{ trans('category.Category Description') }}',
                        visible:true
                    }, {
                        name: 'categoryName',
                        title: '{{ trans('category.Category Name') }}',
                        visible:true
                    },
                    {
                        name: '__component:custom-actions',
                        title: 'Actions',
                        titleClass: 'text-center',
                        dataClass: 'text-center',
                        visible:true
                    }
                ],
                filters: [

                ]

            },
            methods: {}
        })
    </script>
@endsection
