@extends('layouts.master')

@section('title')
    @lang('restock.Restock Item in inventory')
@endsection
@section('heading')
    @lang('restock.Restock Item in inventory')
@endsection


@section('content')
    <div id="app">
        <div class="panel panel-default cls-panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {!! Helper::translateAndShorten('Restock Items','restock',100)!!}
                </h3>
            </div>
            @if(isset($restock))
                {!! Form::model($restock, ['action' => ['RestockController@update', $restock->id], 'method' => 'patch']) !!}
                <script>
                    window.productId = '{{$restock->productID}}';
                    window.binLocationId = '{{$restock->binLocationId}}';
                </script>
            @else
                {!! Form::open(array('action' => 'RestockController@store')) !!}
                <script>
                    window.productId = null;
                    window.binLocationId = null;
                </script>
            @endif
            <div class="panel-body">

                <div class="form-group{!! $errors->has('productID') ? ' has-error' : '' !!}">
                    {!! Form::label('productID',  trans('restock.Select Product To Restock') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                        <select2 v-model="productId" :options="{{json_encode($prods)}}"></select2>
                    </div>
                    {!! $errors->first('productID', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('warehouseId') ? ' has-error' : '' !!}">
                    {!! Form::label('warehouseId', trans('restock.Warehouse to Restock item')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-building"></i></span>
                        <locs_list :options="{{$locs}}" name="warehouseId" v-model="binLocationId" ></locs_list>
                    </div>
                    {!! $errors->first('warehouseId', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('supplierID') ? ' has-error' : '' !!}">
                    {!! Form::label('supplierID',trans('restock.Supplier Name')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('supplierID',$allSuppliers, null, ['class' => 'form-control']) !!}
                    </div>
                    {!! $errors->first('supplierID', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('itemCost') ? ' has-error' : '' !!}">
                            {!! Form::label('itemCost',trans('restock.Item Cost (Total cost for items)')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                {!! Form::text('itemCost', null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('itemCost', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('unitCost') ? ' has-error' : '' !!}">
                            {!! Form::label('unitCost',trans('restock.Unit Cost') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                {!! Form::text('unitCost', null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('unitCost', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group{!! $errors->has('amount') ? ' has-error' : '' !!}">
                    {!! Form::label('amount',trans('restock.Number of Items')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
                        {!! Form::text('amount', null, ['class' => 'form-control']) !!}
                    </div>
                    {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
                </div>
                @include('restocks.custom.inputfields')
                <div class="form-group{!! $errors->has('remarks') ? ' has-error' : '' !!}">
                    {!! Form::label('remarks',trans('restock.Remarks')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                        {!! Form::text('remarks', null, ['class' => 'form-control']) !!}
                    </div>
                    {!! $errors->first('remarks', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="form-group{!! $errors->has('image') ? ' has-error' : '' !!}">
                            <div class="text-center"> {!! Form::label('image',  trans('restock.Upload zip of receipts') ) !!}</div>
                            <div class="input-group col-md-12">
                                <div class="dropzone col-md-12" id="image"></div>
                            </div>
                            {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <input type="hidden" name="restockDocs" id="restockDocs"/>
            </div>
            <div class="panel-footer">
                <input type="hidden" name="productID" v-bind:value="productId">
                <input type="hidden" name="productLocationId" v-bind:value="binLocationId">
                <button class="btn btn-flat bg-green save_form btn-block">@lang('restock.Record Restock')</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection




@section('jquery')
    <script>
        var app = new Vue({
            el: '#app',
            http: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            ready: function () {

            },
            data: {
                locationId: 0,
                productId: productId,
                binLocationId: binLocationId

            },
            methods: {
                prodPicked: function (val) {
                    this.fullhash = val;
                    this.$http({
                        url: '{{url('api/dispatch/item')}}' + '/' + val,
                        method: 'GET',
                    }).then(function (response) {
                        this.productId = response.data.prod_id;
                        this.productLocationHash = response.data.hash;
                        this.dispatchedItem = response.data.prod_id;
                        this.hash = response.data.hash;
                        console.log(response.data);
                    }, function (response) {
                        // error callback
                    });

                }
            },
            watch: {
                'amount': function () {
                    var x = this;
                    this.$http({
                        url: '{{action('Api\SalesOrderItemController@validateInventory')}}',
                        method: 'GET',
                        params: {
                            'productId': x.fullhash,
                            'quantity': x.amount
                        }
                    }).then(function (response) {
                        var data = response.data;
                        console.log(data);
                        if (data.enough === false) {
                            var string = 'Over Dispatch Only ' + data.amount + ' items can be dispatched';
                            x.error = string;
                            x.has_error = true;
                        } else {
                            x.has_error = false;
                        }
                    });


                }
            }
        });


    </script>
@endsection