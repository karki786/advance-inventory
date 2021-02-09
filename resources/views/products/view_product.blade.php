@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!}| @lang('product.View Product') {{$product->productName}}
@endsection


<style>
    .box-header > .box-tools {
        top: -2px !important;
    }
</style>
@section('heading')
    @lang('product.View Product')
@endsection
@section('content')
    <div id="app">
        <div class="panel panel-default cls-panel">
            <div class="panel-body">
                <canvas id="mix4" count="1"></canvas>
            </div>
        </div>


        <chartjs-bar target="mix4"
                     :data="[{{$product->restocks->sum('amount')}},{{$product->dispatches->sum('amount')}},{{$product->invoiceitems->sum('quantity')}},{{$product->purchaseorderitems->sum('amount')}}]"
                     :backgroundcolor="['rgba(75,0,192,0.6)','rgba(0,88,88,0.6)','rgba(75,192,0,0.6)','rgba(75,192,192,0.6)']"
                     :labels="['Restocks','Dispatches','Invoiced','Re-ordered']"></chartjs-bar>

        <div class="alert alert-info">
            @lang('product.Click On image to download Label')
        </div>


        <table class="table table-paper table-condensed table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('product.Location')</th>
                <th>@lang('product.Bin')</th>
                <th>@lang('product.Large BarCode')</th>
                <th>@lang('product.BarCode')</th>

            </tr>
            </thead>
            <tbody>

            <?php $i = 1; ?>

            @foreach ($product->locations as $location)
                    <tr class="">
                        <th scope="row">{{$i}}</th>
                        <td>{{ucwords($location->productLocationName)}}</td>
                        <td>{{$location->binLocationName}}</td>
                        <td><a href="{{url(Storage::url('barcodes/l' . $location->productBarcode . '.jpg'))}}"><img
                                        style="width: 200px;" class="img-responsive img-thumbnail"
                                        src="{{url(Storage::url('barcodes/l' . $location->productBarcode . '.jpg'))}}"/></a>
                        </td>
                        <td><a href="{{url(Storage::url('barcodes/' . $product->barcode . '.jpg'))}}"><img
                                        style="width: 200px;" class="img-responsive img-thumbnail"
                                        src="{{url(Storage::url('barcodes/' . $product->barcode . '.jpg'))}}"/></a></td>

                        </td>
                        <?php $i++; ?>
                    </tr>
            @endforeach
            <tr class="">
                <th scope="row">#</th>
                <td>Store</td>
                <td>-</td>
                <td><a href="{{url(Storage::url('barcodes/l' . $product->barcode . '.jpg'))}}"><img
                                class="img-responsive img-thumbnail" style="width: 200px;"
                                src="{{url(Storage::url('barcodes/l' . $product->barcode . '.jpg'))}}"/></a></td>
                <td><a href="{{url(Storage::url('barcodes/' . $product->barcode . '.jpg'))}}"><img
                                class="img-responsive img-thumbnail" style="width: 200px;"
                                src="{{url(Storage::url('barcodes/' . $product->barcode . '.jpg'))}}"/></a></td>


                </td>
                <?php $i++; ?>
            </tr>
            </tbody>
        </table>

    </div>
@endsection


@section('jquery')
    <script>
        app = new Vue({
            el: '#app',
            data: {}
        });
    </script>
@endsection