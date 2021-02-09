@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('dispatch.View Dispatch')
@endsection
@section('heading')
    @lang('dispatch.View Dispatch')
@endsection

@section('content')
    <style>
        /*Panel tabs*/
        .panel-tabs {
            position: relative;
            bottom: 30px;
            clear: both;
            border-bottom: 1px solid transparent;
        }

        .panel-tabs > li {
            float: left;
            margin-bottom: -1px;
        }

        .panel-tabs > li > a {
            margin-right: 2px;
            margin-top: 4px;
            line-height: .85;
            border: 1px solid transparent;
            border-radius: 4px 4px 0 0;
            color: #ffffff;
        }

        .panel-tabs > li > a:hover {
            border-color: transparent;
            color: #ffffff;
            background-color: transparent;
        }

        .panel-tabs > li.active > a,
        .panel-tabs > li.active > a:hover,
        .panel-tabs > li.active > a:focus {
            color: #fff;
            cursor: default;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            background-color: rgba(255, 255, 255, .23);
            border-bottom-color: transparent;
        }
    </style>
    @if(isset($dispatch))
        {!! Form::model($dispatch, ['action' => ['DispatchController@update', $dispatch->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'DispatchController@store', 'files'=>false)) !!}
    @endif
    <div class="panel panel-info">

        <div class="panel-heading">
            <h3 class="panel-title">@lang('dispatch.Dispatch Information')</h3>
            <span class="pull-right">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li class="active"><a href="#tab1"
                                                  data-toggle="tab">@lang('dispatch.Dispatch Information')</a></li>
                            <li><a href="#tab2" data-toggle="tab">@lang('dispatch.Mark As Defective')</a></li>

                        </ul>
                    </span>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <div class="col-md-2">
                        @if (count($dispatch->photos) > 0) {
                        <img class="thumbnail"
                             src="{{$dispatch->product->photos()->whereIsthumbnail(1)->first()->filename['path']}}">
                        @else
                            <img class="thumbnail" src="{{url('products') . '/' . 'productplaceholder.png'}}">
                        @endif
                    </div>
                    <div class="col-md-8">
                        @lang('dispatch.Product Name') : {{$dispatch->product->productName}}
                        <hr/>
                        @lang('dispatch.Dispatched To') : {{$dispatch->staff->name}}
                        <hr/>
                        @lang('dispatch.Dispatched Amount') : {{$dispatch->amount}}
                        <hr/>
                    </div>


                </div>
                <div class="tab-pane" id="tab2">
                    <div class="alert alert-info">
                        @lang('dispatch.Please not that once item is marked as defective it is returned to store automatically')
                    </div>


                    <div class="form-group{!! $errors->has('isDefective') ? ' has-error' : '' !!}">
                        {!! Form::label('isDefective',  trans('dispatch.Is Item Defective') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                            {!! Form::select('isDefective',array(1=>'Defective Item', 0=>'Item is Okay'), null, ['class' => 'form-control']) !!}
                        </div>
                        {!! $errors->first('isDefective', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group{!! $errors->has('defectRemark') ? ' has-error' : '' !!}">
                        {!! Form::label('defectRemark',  trans('dispatch.Defect Remark') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                            {!! Form::text('defectRemark', null, ['class' => 'form-control','placeholder'=>'Defect Remark']) !!}
                        </div>
                        {!! $errors->first('defectRemark', '<p class="help-block">:message</p>') !!}
                    </div>
                    <input type="hidden" name="dispatchedItem" value="{{$dispatch->dispatchedItem}}"/>
                    <input type="hidden" name="productLocationId" value="{{$dispatch->productLocationId}}"/>

                </div>

            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-flat bg-green btn-block">@lang('dispatch.Save Changes')</button>
        </div>

    </div>
    {!! Form::close() !!}

@endsection

@section('js')

@endsection