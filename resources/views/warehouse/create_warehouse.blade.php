@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('warehouse.Create Warehouse')
@endsection

@section('sidebar')

@endsection
@section('heading')
    @lang('warehouse.Create Warehouse')
@endsection

@section('content')
    <div class="panel panel-default cls-panel">
        <div class="panel-heading">
            <h3 class="panel-title">
                @lang('warehouse.Add A Warehouse')
            </h3>
        </div>
        @if(isset($warehouse))
            {!! Form::model($warehouse, ['action' => ['WarehouseController@update', $warehouse->id], 'method' =>
            'patch'])
            !!}
        @else
            {!! Form::open(array('action' => 'WarehouseController@store', 'files'=>false)) !!}
        @endif
        <div class="panel-body">
            @if (Session::has('info'))
                <div class="alert alert-success">
                    {!!   Session::get('info') !!}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{!! $errors->has('whsName') ? ' has-error' : '' !!}">
                        {!! Form::label('whsName', trans('warehouse.Warehouse Name')) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-building"></i></span>
                            {!! Form::text('whsName', null, ['class' => 'form-control','placeholder'=>'Warehouse Name']) !!}
                        </div>
                        {!! $errors->first('whsName', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{!! $errors->has('whsStreet') ? ' has-error' : '' !!}">
                        {!! Form::label('whsStreet', trans('warehouse.Warehouse Street') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-street"></i></span>
                            {!! Form::text('whsStreet', null, ['class' => 'form-control','placeholder'=>'Warehouse Street']) !!}
                        </div>
                        {!! $errors->first('whsStreet', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{!! $errors->has('whsZipCode') ? ' has-error' : '' !!}">
                        {!! Form::label('whsZipCode', trans('warehouse.Warehouse Zip Code')) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                            {!! Form::text('whsZipCode', null, ['class' => 'form-control','placeholder'=>'Zip Code']) !!}
                        </div>
                        {!! $errors->first('whsZipCode', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{!! $errors->has('whsCity') ? ' has-error' : '' !!}">
                        {!! Form::label('whsCity', trans('warehouse.Warehouse City')) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-building"></i></span>
                            {!! Form::text('whsCity', null, ['class' => 'form-control','placeholder'=>'Warehouse City']) !!}
                        </div>
                        {!! $errors->first('whsCity', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{!! $errors->has('whsState') ? ' has-error' : '' !!}">
                        {!! Form::label('whsState', trans('warehouse.Warehouse State')) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                            {!! Form::text('whsState', null, ['class' => 'form-control','placeholder'=>'State']) !!}
                        </div>
                        {!! $errors->first('whsState', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{!! $errors->has('whsBuilding') ? ' has-error' : '' !!}">
                        {!! Form::label('whsBuilding', trans('warehouse.Warehouse Building')) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-building"></i></span>
                            {!! Form::text('whsBuilding', null, ['class' => 'form-control','placeholder'=>'Warehouse Building']) !!}

                        </div>
                        {!! $errors->first('whsBuilding', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{!! $errors->has('whsStoreKeeper') ? ' has-error' : '' !!}">
                        {!! Form::label('whsStoreKeeper', trans('warehouse.Store Keeper')) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::select('whsStoreKeeper',$users, null, ['class' => 'form-control storekeeper']) !!}

                        </div>
                        {!! $errors->first('whsStoreKeeper', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{!! $errors->has('isActive') ? ' has-error' : '' !!}">
                        {!! Form::label('isActive', trans('warehouse.Is Active')) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                            {!! Form::select('isActive',array(''=>'',1=>'active','0'=>'inactive'), null, ['class' => 'form-control isactive']) !!}

                        </div>
                        {!! $errors->first('isActive', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>


        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-flat save_form bg-green btn-block">@lang('warehouse.Save')</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
    $('.storekeeper').select2({
    allowClear: true
    });

    $('.isactive').select2({
    allowClear: true
    });
@endsection