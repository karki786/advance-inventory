@extends('layouts.master')

@section('title')
    @lang('purchaseorder.Restock Item From Purchase Order')
@endsection
@section('heading')
    @lang('purchaseorder.Restock Item From Purchase Order')
@endsection

@section('content')
    <script>
        window.items = {!! json_encode($orders) !!}
    </script>
    <div id="app">
        <style>
            .editablegrid-received {
                background: rgb(255, 255, 224) !important;
            }

            .item-edit {
                display: none;
            }

            .item-editing {
                display: block;
            }

            .amount_display {
                box-shadow: 0 1px 2px #E5E5E5;
                padding: 1px;
                margin-bottom: 3px;
                text-align: center;
                padding: 5px;
            }

            .amount_display h3 {
                margin: 0px;
                padding: 0px;
            }

            .display {
                margin-bottom: 8px;
            }

            .item-edit {
                display: none;
            }

            .item-editing {
                display: block;
            }

            .grid-input {
                width: 100%;
                height: 100%;
                border: none;

            }

            .no-padding {
                padding: 0px;;
            }

        </style>

        {!! Form::open(array('action' => 'PurchaseOrderController@postRestockFromPurchaseOrder', 'onsubmit' => 'return postForm();',
         'files'=>false)) !!}
        <table class="table table-paper table-bordered ">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('purchaseorder.Product Name')</th>
                <th>@lang('purchaseorder.Unit Cost')</th>
                <th>@lang('purchaseorder.Amount')</th>
                <th>@lang('purchaseorder.UnitCost')</th>
                <th>@lang('purchaseorder.Selling Price')</th>
                <th>@lang('purchaseorder.Delivered')</th>
                <th>@lang('purchaseorder.Received')</th>
                <th>@lang('purchaseorder.Location')</th>

            </tr>
            </thead>
            <tbody>


            <tr class="" v-for="item in items">

                <th scope="row">#</th>
                <td class="no-padding">

                    <input v-model="item.productDescription"
                           class="grid-input" disabled>
                </td>
                <td class="no-padding text-center">

                    <input v-model="item.unitCost" class="grid-input" disabled/>
                </td>
                <td class="no-padding text-center">
                    <input v-model="item.amount" class="grid-input" disabled/>
                </td>
                <td class="no-padding text-center">
                    <input v-model="item.unitCost" class="grid-input" disabled/>
                </td>
                <td class="no-padding text-center">
                    <input v-model="item.sellingPrice" class="grid-input" />
                </td>
                <td class="no-padding text-center">
                    <input v-model="item.delivered" class="grid-input" disabled/>
                </td>
                <td class="no-padding text-center">
                    <input v-model="item.received" max="4" class="grid-input"/>
                </td>
                <td class="no-padding">

                    <div style="width: 300px;" v-if="item.usesMultipleStorage">
                        <locs_list v-model="item.location" v-on:input="locationChanged" :options="{{$locs}}"></locs_list>
                    </div>
                    <div v-else>
                        Product does not use Multiple Storage
                    </div>
                </td>


            </tr>


            </tbody>
        </table>

        <input type="hidden" name="orders" v-bind:value="dat"/>

        <input type="hidden" name="supplierId" value="{{$purchaseorder->supplierId}}"/>
        <button type="submit" class="btn btn-flat bg-green btn-block">@lang('purchaseorder.Restock With Above Values')</button>


        {!! Form::close() !!}
    </div>
@endsection



@section('jquery')

    <script>

        var vm = new Vue({
            el: '#app',
            data: {
                items: items,
            },
            methods: {
                locationChanged(val){
                    console.log(val);
                    console.log(this);
                    this.fullhash = val;
                    this.$http({
                        url: '{{url('api/dispatch/item')}}' + '/' + val,
                        method: 'GET',
                    }).then(function (response) {
                        console.log(response.data);
                    }, function (response) {
                        // error callback
                    });
                }
            },
            computed:{
                dat:function(){
                    return JSON.stringify(this.items);
                }
            }

        });
    </script>
@endsection