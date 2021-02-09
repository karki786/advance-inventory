@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('category.Create Category')
@endsection

@section('sidebar')

@endsection
@section('heading')
    @lang('category.Create Product Category')
@endsection
@section('content')
    <div class="panel panel-default cls-panel">
        <div class="panel-heading">
            <h3 class="panel-title">
                @lang('category.Create/Edit Category')
            </h3>
        </div>
        @if(isset($category))
            {!! Form::model($category, ['action' => ['CategoryController@update', $category->id], 'method' =>
            'patch'])
            !!}
        @else
            {!! Form::open(array('action' => 'CategoryController@store', 'files'=>false)) !!}
        @endif

        <div class="panel-body">
            <div class="form-group{!! $errors->has('categoryName') ? ' has-error' : '' !!}">
                {!! Form::label('categoryName', trans('category.Category Name')) !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-list"></i></span>
                    {!! Form::text('categoryName', null, ['class' => 'form-control','placeholder'=>'']) !!}
                </div>
                {!! $errors->first('categoryName', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{!! $errors->has('categoryDescription') ? ' has-error' : '' !!}">
                {!! Form::label('categoryDescription',  trans('category.Category Description') ) !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                    {!! Form::textarea('categoryDescription', null, ['class' => 'form-control','placeholder'=>'Category Description ']) !!}
                </div>
                {!! $errors->first('categoryDescription', '<p class="help-block">:message</p>') !!}
            </div>

        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-flat bg-green btn-block save_form">@lang('category.Submit')</button>
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@section('js')

@endsection