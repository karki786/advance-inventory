@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('salesorder.Sales Order')
@endsection

@section('heading')
    @lang('salesorder.Sales Order')
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
    @if(isset($salesOrder))
        {!! Form::model($salesOrder, ['action' => ['SalesOrderController@update', $salesOrder->id], 'method' =>
        'patch'])
        !!}
        <script>
            window.customerId = {{$salesOrder->customerId}};
            window.contactId = {{$salesOrder->contactId}};
            window.sales = {!! $salesOrder->items !!};
            window.edit = true;
            window.id = {{$salesOrder->id}};
        </script>
    @else
        {!! Form::open(array('action' => 'SalesOrderController@store', 'files'=>false)) !!}
        <script>
            window.edit = false;
            window.customerId = null;
            window.salesOrderId = null;
            window.contactId = null;
            window.sales = [];
            window.invoiceDate = null;
            window.edit = false;
            window.id = null;
            @if(old('sales'))
                window.sales = {!!json_encode(old('sales'))!!};
            @endif
                    @if(old('customerId'))
                window.customerId = {{old('customerId')}};
            @endif
                    @if(old('contactId'))
                window.contactId = {{old('contactId')}};
            @endif
        </script>
    @endif
    <style>
        .grid-input {
            width: 100%;
            height: 100%;
            border: none;

        }

        .no-padding {
            padding: 0px;;
        }
    </style>
    <div id="invoice_module">
        <div class="row">

            <div class="col-md-6">
                <div class="form-group{!! $errors->has('customerId') ? ' has-error' : '' !!}">
                    {!! Form::label('customerId',  trans('salesorder.Company Name') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <select2 :options="{{$customers}}" name="customerId" v-model="customerId"></select2>
                    </div>
                    {!! $errors->first('customerId', '<p class="help-block">:message</p>') !!}
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group{!! $errors->has('contactId') ? ' has-error' : '' !!}">
                    {!! Form::label('contactId',  trans('salesorder.Contact Person') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <select2 id="contacts" v-model="contactId" name="contactId"></select2>
                    </div>
                    {!! $errors->first('contactId', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default cls-panel" >


                  <div class="panel-body">
                      <grid :product_url='{!!  json_encode(url('/invoice/api/getproduct/'))!!}'
                            :barcode_url='{!! json_encode(url('/invoice/api/getproductscan/')) !!}'
                            :delete_url='{!! json_encode(url('sales/stock/delete/')) !!}'
                            :countries="{{json_encode($countries)}}"
                            :prods="{{ json_encode($prods) }}"
                            :def_curr="{{json_encode($prevCurr)}}"
                            :old_data='sales'
                            :base_url="{{json_encode(url('sl/api'))}}"
                            pricing="useSellingPrice"
                            :validate="true"
                            :edit="edit"
                            :id="id"
                      >

                      </grid>
                  </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default cls-panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            @lang('salesorder.Extra Details')
                        </h3>
                    </div>

                    <div class="panel-body">

                        <div class="form-group{!! $errors->has('onHold') ? ' has-error' : '' !!}">
                            {!! Form::label('onHold',  trans('salesorder.Hold Items') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                                {!! Form::select('onHold',array(0=>'Sale',1=>'On Hold For Client'), null, ['class' => 'form-control onHold']) !!}
                            </div>
                            {!! $errors->first('onHold', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="form-group{!! $errors->has('generatePackingSlip') ? ' has-error' : '' !!}">
                            {!! Form::label('generatePackingSlip',  trans('salesorder.Generate Packing Slip') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                                {!! Form::select('generatePackingSlip',array(0=>'Do not Generate',1=>'Generate Packing Clip'), null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('generatePackingSlip', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('emailCustomer') ? ' has-error' : '' !!}">
                            {!! Form::label('emailCustomer',  trans('salesorder.Email Customer') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                {!! Form::select('emailCustomer',array(0=>'Dont Send Email',1=>'Send Email'), null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('emailCustomer', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('paymentMethod') ? ' has-error' : '' !!}">
                            {!! Form::label('paymentMethod',  trans('salesorder.Payment Method') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                {!! Form::text('paymentMethod', null, ['class' => 'form-control','placeholder'=>'Payment Method']) !!}
                            </div>
                            {!! $errors->first('paymentMethod', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('paymentTerms') ? ' has-error' : '' !!}">
                            {!! Form::label('paymentTerms',  trans('salesorder.Payment Terms') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                                {!! Form::textarea('paymentTerms', null, ['rows'=>'2','class' => 'form-control','placeholder'=>'Payment Terms']) !!}
                            </div>
                            {!! $errors->first('paymentTerms', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('delivery') ? ' has-error' : '' !!}">
                            {!! Form::label('delivery',  trans('salesorder.Mark for Delivery') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                                {!! Form::select('delivery',array('0'=>'',1=>'Deliver'), 0, ['class' => 'form-control deliver']) !!}
                            </div>
                            {!! $errors->first('delivery', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('remark') ? ' has-error' : '' !!}">
                            {!! Form::label('remark', trans('salesorder.Remarks') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                                {!! Form::textarea('remark', null, ['rows'=>'3','class' => 'form-control','placeholder'=>'Remarks']) !!}
                            </div>
                            {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
                        </div>

                        <button type="submit"
                                class="btn btn-flat bg-green save_form btn-block">@lang('salesorder.Save')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection


@section('jquery')
    <script>
        Vue.config.debug = true;
        $(document).ready(function () {
            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });

        var vm = new Vue({
            el: '#invoice_module',
            data: {
                customerId: customerId,
                contactId: contactId,
                sales: sales,
                edit: edit,
                id: id
            },
            watch: {
                customerId: function () {
                    if (this.customerId === undefined || this.customerId === 'null' || this.customerId === null || this.customerId == "") {
                        return 0;
                    }
                    $('#contacts').select2().empty();
                    $("#contacts").prop("disabled", true);
                    $.notify(
                        "Fetching Company Contacts",
                        {
                            className: 'info',
                            autoHideDelay: 5000,
                        }
                    );
                    this.$http({
                        url: "{{url('customer/contacts')}}" + '/' + this.customerId,
                        method: 'GET'
                    }).then(function (response) {
                        $('#contacts').select2({
                            data: response.data
                        });
                        $("#contacts").prop("disabled", false);
                        console.log(contactId);
                        $("#contacts").val(contactId).trigger("change");
                        $.notify(
                            "Contacts Fetched",
                            {
                                className: 'success',
                                autoHideDelay: 5000,
                            }
                        );
                    }, function (response) {
                        // error callback
                    });
                }
            }
        });
    </script>
@endsection