@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('invoice.Create Invoice')
@endsection

@section('heading')
    @lang('invoice.Create Invoice')
@endsection

@section('content')

    {{-- @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    @if(isset($invoice))
        {!! Form::model($invoice, ['action' => ['InvoiceController@update', $invoice->id], 'method' =>
        'patch'])
        !!}
        <script>
            window.customerId = {{$invoice->customerId}};
            window.invoiceDate = '{{$invoice->invoiceDate}}';
            window.salesOrderId = '{{$invoice->salesOrderId}}';
            window.invoiceId = {{$invoice->id}};
            window.contactId = {{$invoice->contactId}};
            window.sales = {!! $invoice->items !!};
            window.edit = true;
            window.id = {{$invoice->id}};
        </script>

    @else
        {!! Form::open(array('action' => 'InvoiceController@store', 'files'=>false)) !!}
        <script>
            window.customerId = null;
            window.invoiceId = null;
            window.salesOrderId = null;
            window.contactId = null;
            window.sales = [];
            window.invoiceDate = null;
            window.edit = false;
            window.id = null;
        </script>
    @endif
    <div id="invoice_module">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group{!! $errors->has('invoiceDate') ? ' has-error' : '' !!}">
                    {!! Form::label('invoiceDate',  trans('invoice.Invoice Date') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <date name="invoiceDate" limit='0d' v-model="invoiceDate"></date>
                    </div>


                    {!! $errors->first('invoiceDate', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{!! $errors->has('customerId') ? ' has-error' : '' !!}">
                    {!! Form::label('customerId',  trans('invoice.Company Name') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <select2 :options="{{$customers}}" name="customerId" v-model="customerId"></select2>
                    </div>
                    {!! $errors->first('customerId', '<p class="help-block">:message</p>') !!}
                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group{!! $errors->has('contactId') ? ' has-error' : '' !!}">
                    {!! Form::label('contactId',  trans('invoice.Contact Person') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <select2 id="contacts" name="contactId"></select2>
                    </div>
                    {!! $errors->first('contactId', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default cls-panel">


                    <div class="panel-body">
                        <grid :product_url='{!!  json_encode(url('/invoice/api/getproduct/'))!!}'
                              :barcode_url='{!! json_encode(url('/invoice/api/getproductscan/')) !!}'
                              :delete_url='{!! json_encode(url('sales/stock/delete/')) !!}'
                              :countries="{{json_encode($countries)}}"
                              :prods="{{ json_encode($prods) }}"
                              :def_curr="{{json_encode($prevCurr)}}"
                              :old_data='sales'
                              :base_url="{{json_encode(url('inv/api'))}}"
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
            <div class="col-md-6">


                <div class="form-group{!! $errors->has('salesOrderId') ? ' has-error' : '' !!}">
                    {!! Form::label('salesOrderId',  trans('invoice.Based on Sales Order') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-file"></i></span>
                        <select2 :options="{{$orders}}" v-model="salesOrderId" name="salesOrderId"></select2>
                    </div>
                    {!! $errors->first('salesOrderId', '<p class="help-block">:message</p>') !!}
                </div>


                <div class="form-group{!! $errors->has('paymentMethod') ? ' has-error' : '' !!}">
                    {!! Form::label('paymentMethod',  trans('invoice.Payment Method') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        {!! Form::text('paymentMethod', null, ['class' => 'form-control','placeholder'=>'Payment Method']) !!}
                    </div>
                    {!! $errors->first('paymentMethod', '<p class="help-block">:message</p>') !!}
                </div>

                <div class="form-group{!! $errors->has('remark') ? ' has-error' : '' !!}">
                    {!! Form::label('remark',  trans('invoice.Remarks') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                        {!! Form::textarea('remark', null, ['rows'=>'3','class' => 'form-control','placeholder'=>'Remarks']) !!}
                    </div>
                    {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
                </div>


            </div>
            <div class="col-md-6">
                <div class="form-group{!! $errors->has('emailCustomer') ? ' has-error' : '' !!}">
                    {!! Form::label('emailCustomer',  trans('invoice.Email Customer') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        {!! Form::select('emailCustomer',array(0=>'Dont Send Email',1=>'Send Email'), null, ['class' => 'form-control']) !!}
                    </div>
                    {!! $errors->first('emailCustomer', '<p class="help-block">:message</p>') !!}
                </div>

                <div class="form-group{!! $errors->has('paymentTerms') ? ' has-error' : '' !!}">
                    {!! Form::label('paymentTerms',  trans('invoice.Payment Terms') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                        {!! Form::text('paymentTerms', null, ['class' => 'form-control','placeholder'=>'Payment Terms']) !!}
                        <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                    </div>
                    {!! $errors->first('paymentTerms', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-flat bg-green btn-block save_form">@lang('invoice.Save')</button>
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
                    invoiceId: invoiceId,
                    contactId: contactId,
                    salesOrderId: salesOrderId,
                    sales: sales,
                    invoiceDate: invoiceDate,
                    id: id,
                    edit: edit
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
                            console.log(response);

                            $('#contacts').select2({
                                data: response.data
                            });
                            $("#contacts").prop("disabled", false);
                            // $("#contacts").val().trigger("change");
                            console.log(this.contactId);
                            $("#contacts").val(this.contactId).trigger("change");
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
            })
        ;
    </script>
@endsection