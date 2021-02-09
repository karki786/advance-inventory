@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('purchaseorder.Create New Purchase Order')
@endsection
@section('heading')
    {!! Helper::translateAndShorten('Create New Purchase Order','purchaseorder',50)!!}
@endsection

@section('content')
    <style>
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

        .grid-input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;

        }

        .sub-table-amount {
            background: #FFF;
            color: #666;
            box-shadow: 0 1px 0 #D0D7E9;
            border: 0.1px solid #f4f4f4 !important;
            border-radius: 0 !important;
            display: table-cell !important;
            vertical-align: middle !important;
            font-family: 'Source Sans Pro', sans-serif !important;
            padding: 10px !important;
            text-align: right;
        }

        .sub-table-title {
            background: #FFF;
            color: #666;
            box-shadow: 0 1px 0 #D0D7E9;
            border: 0.1px solid #f4f4f4 !important;
            border-radius: 0 !important;
            display: table-cell !important;
            vertical-align: middle !important;
            font-family: 'Source Sans Pro', sans-serif !important;
            padding: 10px !important;
        }

        .no-padding {
            padding: 0px !important;
        }

        .fade-enter-active, .fade-leave-active {
            transition: opacity .10000s
        }

        .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */
        {
            opacity: 0
        }
    </style>


    @if(isset($purchaseorder))
        {!! Form::model($purchaseorder, ['action' => ['PurchaseOrderController@update', $purchaseorder->id], 'method' =>
        'patch'])
        !!}
        <script>
            window.supplierId = {{$purchaseorder->supplierId}};
            window.lpoDate = '{{\Carbon\Carbon::parse($purchaseorder->lpoDate)->format('Y/m/d')}}';
            window.deliverBy = '{{\Carbon\Carbon::parse($purchaseorder->deliverBy)->format('Y/m/d')}}';
            window.items = {!! $orders !!};
            window.edit = true;
            window.id = {{$purchaseorder->id}};
        </script>
    @else
        {!! Form::open(array('action' => 'PurchaseOrderController@store', 'files'=>false)) !!}
        <script>
            window.supplierId = null;
            window.lpoDate = null;
            window.deliverBy = null;
            window.salesOrderId = null;
            window.contactId = null;
            window.items = [];
            window.invoiceDate = null;
            window.edit = false;
            window.id = null;
        </script>
    @endif
    <div id="purchaseOrder">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group{!! $errors->has('supplierId') ? ' has-error' : '' !!}">
                    {!! Form::label('supplierId', trans('purchaseorder.Supplier Name')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <select2 :options="{{ $suppliers }} " v-model="supplierId" name="supplierId"></select2>
                    </div>
                    {!! $errors->first('supplierId', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{!! $errors->has('lpoDate') ? ' has-error' : '' !!}">
                    {!! Form::label('lpoDate', trans('purchaseorder.Lpo Date')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <date name="lpoDate" v-model="lpoDate"
                              limit="{{Carbon\Carbon::today()->format('Y/m/d')}}"></date>
                    </div>
                    {!! $errors->first('lpoDate', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{!! $errors->has('deliverBy') ? ' has-error' : '' !!}">
                    {!! Form::label('deliverBy', trans('purchaseorder.Deliver By')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <date name="deliverBy" v-model="deliverBy"
                              limit="{{Carbon\Carbon::today()->format('Y/m/d')}}"></date>

                    </div>
                    {!! $errors->first('deliverBy', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default cls-panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {!! Helper::translateAndShorten('Purchase Order Items','purchaseorder',50)!!}
                        </h3>
                    </div>

                    <div class="panel-body">

                        <grid :product_url='{!!  json_encode(url('/invoice/api/getproduct/'))!!}'
                              :barcode_url='{!! json_encode(url('/invoice/api/getproductscan/')) !!}'
                              :delete_url='{!! json_encode(url('invoice/stock/delete')) !!}'
                              :countries="{{json_encode($countries)}}"
                              :prods="{{ json_encode($prods) }}"
                              :def_curr="{{json_encode($prevCurr)}}"
                              :old_data='items'
                              :base_url="{{json_encode(url('pl/api'))}}"
                              validate=false
                              pricing="unitCost"
                              :edit="edit"
                              :id="id"
                        >

                        </grid>


                    </div>
                </div>

                <div class="panel panel-default cls-panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            @lang('purchaseorder.LPO Status')
                        </h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-group{!! $errors->has('lpoStatus') ? ' has-error' : '' !!}">
                            {!! Form::label('lpoStatus',  trans('purchaseorder.LPO Status') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                                {!! Form::select('lpoStatus',array('2'=>'Awaiting Approval','0'=>'Rejected','1'=>'Approved'), null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                            </div>
                            {!! $errors->first('lpoStatus', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('rejectionReason') ? ' has-error' : '' !!}">
                            {!! Form::label('rejectionReason',  trans('purchaseorder.Rejection Reason') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                                {!! Form::text('rejectionReason', null, ['class' => 'form-control','placeholder'=>'Rejection Reason']) !!}
                                <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                            </div>
                            {!! $errors->first('rejectionReason', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="panel panel-default cls-panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {!! Helper::translateAndShorten('Terms','purchaseorder',40)!!}
                </h3>
            </div>

            <div class="panel-body">


                <div class="form-group{!! $errors->has('termsOfPayment') ? ' has-error' : '' !!}">
                    {!! Form::label('termsOfPayment', trans('purchaseorder.Terms Of Payment')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-file"></i></span>
                        {!! Form::text('termsOfPayment', null, ['class' => 'form-control','placeholder'=>'Terms of Payment']) !!}
                    </div>
                    {!! $errors->first('termsOfPayment', '<p class="help-block">:message</p>') !!}
                </div>


                <div class="form-group{!! $errors->has('departmentId') ? ' has-error' : '' !!}">
                    {!! Form::label('departmentId', trans('purchaseorder.Department')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                        {!! Form::select('departmentId',$departments, null, ['class' => 'form-control dep']) !!}
                    </div>
                    {!! $errors->first('departmentId', '<p class="help-block">:message</p>') !!}
                </div>


                <div class="form-group{!! $errors->has('remarks') ? ' has-error' : '' !!}">
                    {!! Form::label('remarks', trans('purchaseorder.Remarks')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                        {!! Form::text('remarks', null, ['class' => 'form-control','placeholder'=>'']) !!}
                    </div>
                    {!! $errors->first('remarks', '<p class="help-block">:message</p>') !!}
                </div>

            </div>


        </div>


        <button type="submit"
                class="btn btn-flat bg-green save_form btn-block"> {!! Helper::translateAndShorten('Save Purchase Order','createorder',50)!!}</button>
        {!! Form::close() !!}
    </div>
@endsection

@section('jquery')
    <script>
        var vm = new Vue({
            el: '#purchaseOrder',
            data: {
                items: items,
                supplierId: supplierId,
                lpoDate: lpoDate,
                deliverBy: deliverBy,
                edit: edit,
                id: id
            },
            watch: {
                onHold: function () {

                }
            }
        });


    </script>
@endsection