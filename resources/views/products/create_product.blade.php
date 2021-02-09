@extends('layouts.master')
@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('product.Add Product')
@endsection

@section('heading')
    @lang('product.Create Product')
@endsection

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="panel panel-default cls-panel ">
        <div class="panel-heading ">
            <h3 class="panel-title">
                {!! \App\Helper::translateAndShorten('Add Product','product',50)!!}
            </h3>
        </div>
        @if(isset($product))
            {!! Form::model($product, ['action' => ['ProductController@update', $product->id], 'method' =>
            'patch'])
            !!}
            <script>

                window.locations = {!! $gridData !!};
                window.usesMultipleStorage = {{$product->usesMultipleStorage}};
                window.productCurrency = '{{$product->productCurrency}}';
                window.edit = true;
                window.id = {{$product->id}};
                window.expiryDate = '{{$product->expiryDate}}';
            </script>
        @else
            {!! Form::open(array('action' => 'ProductController@store', 'files'=>false,'class'=>'')) !!}
            <script>
                @if(old('usesMultipleStorage'))
                    window.locations = {!!  json_encode(old('locations'))!!};
                window.usesMultipleStorage = {{old('usesMultipleStorage')}};
                window.productCurrency = '{{old('productCurrency')}}';
                window.edit = false;
                window.id = null;
                window.expiryDate = '{{old('$product->expiryDate')}}';
                @else
                    window.locations = [];
                window.usesMultipleStorage = 0;
                window.productCurrency = '{{$def_currency}}';
                window.edit = false;
                window.id = null;
                window.expiryDate = '';
                @endif
            </script>
        @endif
        <div id="create_product">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('productName') ? ' has-error' : '' !!}">
                            {!! Form::label('productName',  trans('product.Product Name') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                                {!! Form::text('productName', null, ['class' => 'form-control products', 'autocomplete'=>'off']) !!}
                            </div>
                            {!! $errors->first('productName', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('amount') ? ' has-error' : '' !!}">
                            {!! Form::label('amount', trans('product.Initial Amount of Item in Stock')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
                                {!! Form::text('amount', null, [":disabled"=>"storagetype == 1 ? true : false",'class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                </div>

                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('productTaxRate') ? ' has-error' : '' !!}">
                            {!! Form::label('productTaxRate', trans('product.Product Tax Rate')) !!}
                            <div class="input-group">
                                <span class="input-group-addon">%</span>
                                {!! Form::text('productTaxRate', null, ['class' => 'form-control','placeholder'=>'Tax Rate']) !!}

                            </div>
                            {!! $errors->first('productTaxRate', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('reorderAmount') ? ' has-error' : '' !!}">
                            {!! Form::label('reorderAmount', trans('product.Reorder Stock Amount')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-sort-numeric-desc"></i></span>
                                {!! Form::text('reorderAmount', null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('reorderAmount', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('location') ? ' has-error' : '' !!}">
                            {!! Form::label('location', trans('product.Product Location in Store')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                                {!! Form::text('location', null, [":disabled"=>"storagetype == 1 ? true : false",'class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('sellingPrice') ? ' has-error' : '' !!}">
                            {!! Form::label('sellingPrice', trans('product.Selling Price')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                {!! Form::text('sellingPrice', null, [ ":disabled"=>"storagetype == 1 ? true : false",'class' => 'form-control','placeholder'=>'Selling Price']) !!}

                            </div>
                            {!! $errors->first('sellingPrice', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                </div>
                <div class="col-md-12">

                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('barcode') ? ' has-error' : '' !!}">
                            {!! Form::label('barcode', trans('product.Barcode')) !!} (Numbers Only upto 12 Digits) - Make Sure Check Digit is Correct
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                {!! Form::text('barcode', '', ['class' => 'form-control','placeholder'=>'Text for Barcode'])
                                !!}
                            </div>
                            {!! $errors->first('barcode', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('qrcode') ? ' has-error' : '' !!}">
                            {!! Form::label('qrcode', trans('product.QrCode')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-qrcode"></i></span>
                                {!! Form::text('qrcode', null, ['class' => 'form-control','placeholder'=>'Text for Barcode'])
                                !!}
                            </div>
                            {!! $errors->first('qrcode', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('unitCost') ? ' has-error' : '' !!}">
                            {!! Form::label('unitCost', trans('product.Unit Cost')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                {!! Form::text('unitCost', null, [":disabled"=>"storagetype == 1 ? true : false", 'class' => 'form-control unitCost']) !!}
                            </div>
                            {!! $errors->first('unitCost', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('categoryId') ? ' has-error' : '' !!}">
                            {!! Form::label('categoryId', trans('product.Category')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tasks"></i></span>
                                {!! Form::select('categoryId',$categories, null, ['class' => 'form-control catSelect']) !!}
                            </div>
                            {!! $errors->first('categoryId', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('productSku') ? ' has-error' : '' !!}">
                            {!! Form::label('productSku', trans('product.Product SKU')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                {!! Form::text('productSku', null, ['class' => 'form-control','placeholder'=>'SKU']) !!}

                            </div>
                            {!! $errors->first('productSku', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('expiryDate') ? ' has-error' : '' !!}">
                            {!! Form::label('expiryDate', trans('product.Expiration Date')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <date name="expiryDate" v-model="expiryDate"></date>
                            </div>
                            {!! $errors->first('expiryDate', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('productWeight') ? ' has-error' : '' !!}">
                            {!! Form::label('productWeight', trans('product.Product Weight')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                                {!! Form::text('productWeight', null, ['class' => 'form-control','placeholder'=>'Weight']) !!}
                            </div>
                            {!! $errors->first('productWeight', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('productMeasurementUnit') ? ' has-error' : '' !!}">
                            {!! Form::label('productMeasurementUnit', trans('product.Product Measurement Unit')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                                {!! Form::text('productMeasurementUnit', null, ['class' => 'form-control','placeholder'=>'KG']) !!}
                            </div>
                            {!! $errors->first('productMeasurementUnit', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('productSpecification') ? ' has-error' : '' !!}">
                            {!! Form::label('productSpecification', trans('product.Product Specification')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                                {!! Form::text('productSpecification', null, ['class' => 'form-control','placeholder'=>'Product Specification']) !!}

                            </div>
                            {!! $errors->first('productSpecification', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('productSerial') ? ' has-error' : '' !!}">
                            {!! Form::label('productSerial', trans('product.Product Serial Number')) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                {!! Form::text('productSerial', null, ['class' => 'form-control serial']) !!}
                            </div>
                            {!! $errors->first('productSerial', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('productCurrency') ? ' has-error' : '' !!}">
                            {!! Form::label('productCurrency',  trans('product.Product Currency') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                <select2 name="productCurrency" v-model="productCurrency"
                                         :options="{{  json_encode($currencies)}}"></select2>
                            </div>
                            {!! $errors->first('productCurrency', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{!! $errors->has('productManufacturer') ? ' has-error' : '' !!}">
                            {!! Form::label('productManufacturer',  trans('product.Product Manufacturer') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                {!! Form::text('productManufacturer', null, ['class' => 'form-control','placeholder'=>'Manufacturer']) !!}
                            </div>
                            {!! $errors->first('productManufacturer', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group{!! $errors->has('usesMultipleStorage') ? ' has-error' : '' !!}">
                            {!! Form::label('usesMultipleStorage',trans('product.Enable Multi Storage') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                                {!! Form::select('usesMultipleStorage',array(0=>'Disabled','1'=>'Enabled'), null, ['class' => 'form-control','v-model'=>'storagetype']) !!}
                            </div>
                            {!! $errors->first('usesMultipleStorage', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div v-if="storagetype == 1" class="col-md-12 ">
                        <hr/>
                        {!! trans('product.Multiple Storage Locations') !!} :

                        <location_grid
                                :locs="{{$locs}}"
                                :old_data="locations"
                                delete_url="{{url('api/v1/product/location/')}}"
                                item_edit="{{url('api/location')}}"
                                :edit="edit"
                                :id="id"
                        ></location_grid>
                        <hr/>
                    </div>

                </div>
                @if(isset($product))
                    <upload image_url="{{url('photo/')}}"
                            id={{$product->id}} url="{{url('product/upload/photo/'.$product->id)}}"
                            token="{!! csrf_token() !!}">
                    </upload>
                @endif
                <input type="hidden" value="" name="productImage"/>


            </div>

            <div class="panel-footer">
                <button type="submit" class="btn btn-flat bg-green save_form btn-block"><i
                            class="fa fa-save"></i> {!! trans('product.Add Product') !!}</button>
            </div>
            {!! Form::close() !!}
        </div>


    </div>
@endsection


@section('jquery')

    <script>
        function formatRepo(repo) {

            return '<b>' + repo.whsName + '</b>' + '<br/><b>Bin Location :</b> <i>' + repo.binCode;
        }

        function formatRepoSelection(repo) {
            return repo.binCode || repo.text;
        }


        app = new Vue({
            el: '#create_product',
            data: {
                storagetype: usesMultipleStorage,
                prodq: '',
                locations: locations,
                productCurrency: productCurrency,
                edit: edit,
                id: id,
                expiryDate: expiryDate
            }
        });
    </script>
@endsection