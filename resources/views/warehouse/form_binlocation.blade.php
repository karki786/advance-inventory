<div class="panel panel-default cls-panel">
    <div class="panel-heading">
        <h3 class="panel-title">
           @lang('warehouse.Add A Storage Location')
        </h3>
    </div>
    @if(isset($bin))
        {!! Form::model($bin, ['action' => ['BinLocationController@update', $bin->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'BinLocationController@store', 'files'=>false)) !!}
    @endif


    <div class="panel-body">
        @if (Session::has('info'))
            <div class="alert alert-success">
                {!!  Session::get('info') !!}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <input type="hidden" name="whsId" value="{{$warehouse->id}}"/>
                <div class="form-group{!! $errors->has('warehouseName') ? ' has-error' : '' !!}">
                    {!! Form::label('warehouseName', trans('warehouse.Warehouse')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-building"></i></span>
                        {!! Form::text('warehouseName', $warehouse->whsName, ['class' => 'form-control','placeholder'=>'Warehouse','disabled'=>'true']) !!}
                    </div>
                    {!! $errors->first('warehouseName', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{!! $errors->has('binCode') ? ' has-error' : '' !!}">
                    {!! Form::label('binCode', trans('warehouse.Storage Location Name') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                        {!! Form::text('binCode', null, ['class' => 'form-control','placeholder'=>'Storage Location Name']) !!}
                    </div>
                    {!! $errors->first('binCode', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group{!! $errors->has('binDescription') ? ' has-error' : '' !!}">
                    {!! Form::label('binDescription', trans('warehouse.Storage Location Description')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                        {!! Form::text('binDescription', null, ['class' => 'form-control','placeholder'=>'Description']) !!}
                        <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                    </div>
                    {!! $errors->first('binDescription', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{!! $errors->has('binBarcode') ? ' has-error' : '' !!}">
                    {!! Form::label('binBarcode', trans('warehouse.Barcode')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                        {!! Form::text('binBarcode', null, ['class' => 'form-control','placeholder'=>'Barcode']) !!}
                    </div>
                    {!! $errors->first('binBarcode', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group{!! $errors->has('binMaxLevel') ? ' has-error' : '' !!}">
                    {!! Form::label('binMaxLevel', trans('warehouse.Bin Max Level')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                        {!! Form::text('binMaxLevel', null, ['class' => 'form-control','placeholder'=>'Bin Max Level']) !!}
                        <span class="input-group-addon"><i class="fa fa-ascending"></i></span>
                    </div>
                    {!! $errors->first('binMaxLevel', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{!! $errors->has('binMaxWeight') ? ' has-error' : '' !!}">
                    {!! Form::label('binMaxWeight', trans('warehouse.Bin Max Weight')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                        {!! Form::text('binMaxWeight', null, ['class' => 'form-control','placeholder'=>'Max Weight']) !!}
                        <span class="input-group-addon"><i class="fa fa-kilo"></i></span>
                    </div>
                    {!! $errors->first('binMaxWeight', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>

    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-flat bg-green btn-block">@lang('warehouse.Save')</button>
    </div>
    {!! Form::close() !!}
</div>