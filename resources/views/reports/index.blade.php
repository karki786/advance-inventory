@extends('layouts.master')

@section('title')

@endsection



@section('content')
    {!! Form::open(array('action' => 'ReportController@store', 'files'=>false)) !!}
    <div class="form-group{!! $errors->has('reportType') ? ' has-error' : '' !!}">
        {!! Form::label('reportType', 'Report To Generate') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-file-o"></i></span>
            {!! Form::select('reportType',array('monthlydispatchcount'=>'monthlydispatchcount'), null, ['class' => 'form-control']) !!}

        </div>
        {!! $errors->first('reportType', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group{!! $errors->has('fileType') ? ' has-error' : '' !!}">
            {!! Form::label('fileType', 'File Type') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-file-o"></i></span>
                 {!! Form::select('fileType',['pdf','xlsx'], null, ['class' => 'form-control']) !!}

            </div>
            {!! $errors->first('fileType', '<p class="help-block">:message</p>') !!}
        </div>
    <button type="submit" class="btn btn-flat bg-green btn-block">Generate Report</button>
    {!! Form::close() !!}
    <hr/>
@endsection

@section('js')

@endsection