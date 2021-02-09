@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!}|Import Data
@endsection

@section('heading')
    Upload Data
@endsection

@section('content')
    <div class="alert alert-danger text-center">
        To import data you need to have data in the format below please download the Data Transfer Workbench Excel Sheet
        here. <b>ProductName, Location and amount Must be filled out </b>

        <br/>

    </div>
    <div class="text-center">
        <a class="btn btn-flat bg-green text-center" href="{{url('/product/stock/import?download=true')}}">Download
            Workbench</a>
    </div>
    <br/>

    {!! Form::open(array('action' => 'ProductController@uploadData', 'files'=>true)) !!}
    <div class="panel panel-default cls-panel">
        <div class="panel-heading">
            <h3 class="panel-title">
                Upload CSV Data
            </h3>
        </div>

        <div class="panel-body">
            <div class="form-group  {!! $errors->has('workbenchfile') ? ' has-error' : '' !!}">
                {!! Form::label('workbenchfile', 'Workbench File') !!}

                {!! Form::file('workbenchfile', ['class' => '']) !!}

                {!! $errors->first('workbenchfile', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-flat bg-green btn-block">Import Data</button>
        </div>
    </div>


    {!! Form::close() !!}


@endsection

@section('js')

@endsection