@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('dispatch.Dispatch Item')
@endsection
@section('heading')
    @lang('dispatch.Dispatch Product')
@endsection

@section('content')
    @if(isset($dispatch))
        {!! Form::model($dispatch, ['action' => ['DispatchController@update', $dispatch->id], 'method' =>
        'patch'])
        !!}
        <script>
            window.dispatchedItem = {{$dispatch->dispatchedItem}};
            window.productId = '{{$dispatch->productId}}';
            window.dispatchedTo = '{{$dispatch->dispatchedTo}}';
            window.productLocationHash = '{{$dispatch->hash}}';
        </script>
    @else
        {!! Form::open(array('action' => 'DispatchController@store')) !!}
        <script>
            window.dispatchedItem = null;
            window.productId = null;
            window.dispatchedTo = null;
            window.productLocationHash = null;

        </script>
    @endif
    <div id="app">
        <div v-if="has_error" class="alert alert-error">
            @{{error}}
        </div>
        <div class="panel panel-default cls-panel" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel-heading" role="tab" id="dispatchform">
                <h3 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                    aria-expanded="true"
                    aria-controls="collapseOne">
                    {!! Helper::translateAndShorten('Dispatch a Product','dispatch',50)!!}
                </h3>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="dispatchform">

                <div class="panel-body">
                    <div class="form-group{!! $errors->has('dispatchedItem') ? ' has-error' : '' !!}">
                        {!! Form::label('dispatchedItem',  trans('dispatch.Item to Dispatch') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                            <prod v-on:input="prodPicked" v-model="prod_id" :options="{{json_encode($prods)}}"></prod>
                        </div>
                        {!! $errors->first('dispatchedItem', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group{!! $errors->has('dispatchedTo') ? ' has-error' : '' !!}">
                        {!! Form::label('dispatchedTo', trans('dispatch.Dispatched To').' (Add Staff in Staff Module)') !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <select2  v-model="dispatchedTo" name="dispatchedTo" :options="{{json_encode($users)}}"></select2>
                        </div>
                        {!! $errors->first('dispatchedTo', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group{!! $errors->has('amount') ? ' has-error' : '' !!}">
                        {!! Form::label('amount', trans('dispatch.Dispatched Amount')) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-sort-amount-asc"></i></span>
                            {!! Form::text('amount', null, ['class' => 'form-control']) !!}
                        </div>
                        {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group{!! $errors->has('remarks') ? ' has-error' : '' !!}">
                        {!! Form::label('remarks', trans('dispatch.Remarks')) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-comments"></i></span>
                            {!! Form::text('remarks', null, ['class' => 'form-control']) !!}
                        </div>
                        {!! $errors->first('remarks', '<p class="help-block">:message</p>') !!}
                    </div>


                </div>
                <input type="hidden" name="productLocationHash" v-bind:value="productLocationHash"/>
                <input type="hidden" name="dispatchedItem" v-bind:value="dispatchedItem"/>
                <div class="panel-footer">
                    <button type="submit"
                            class="btn btn-flat bg-green save_form  btn-block">@lang('dispatch.Dispatch')</button>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}
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
            mounted: function () {
                if (this.productId != null) {
                  //  this.prodPicked(this.productId);
                    this.prod_id = this.productId;
                }
            },
            data: {
                amount: '',
                productId: '',
                warehouseId: '',
                productLocationHash: productLocationHash,
                hash: '',
                showmultilocation: 1,
                fullhash: '',
                error: '',
                has_error: false,
                dispatchedItem: dispatchedItem,
                productId: productId,
                prod_id : productId,
               dispatchedTo :dispatchedTo
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
                productId: function () {
                    console.log('ha');
                },
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