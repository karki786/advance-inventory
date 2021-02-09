@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('payment.Record Payment')
@endsection
@section('heading')
    @lang('payment.Create Payment')
@endsection
@section('content')

    <div class="panel panel-default cls-panel">

        @if(isset($payment))
            {!! Form::model($payment, ['action' => ['PaymentController@update', $payment->id], 'method' =>
            'patch'])
            !!}
            <script>
                window.customerid = {{$payment->customerId}};
                window.invoiceid = {{$payment->invoiceId}};
                window.oldId = {{$payment->invoiceId}};
            </script>
        @else
            {!! Form::open(array('action' => 'PaymentController@store', 'files'=>false)) !!}
            <script>
                window.customerid = '{{$customerId}}';
                window.invoiceid = '{{$orderNo}}';
                window.oldId = '{{$orderNo}}';
            </script>
        @endif


        <div class="panel-body">
            <div id="app">
                <div class="form-group{!! $errors->has('customerId') ? ' has-error' : '' !!}">
                    {!! Form::label('customerId', 'Customer') !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <select2 :options="{{$customers}}" name="customerId" v-model="customerid"></select2>
                    </div>
                    {!! $errors->first('customerid', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('invoiceId') ? ' has-error' : '' !!}">
                    {!! Form::label('invoiceId',  trans('payment.Invoice Number') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-file"></i></span>
                        <select2 :options="invoices" name="invoiceId" class="h" v-model="invoiceid"></select2>
                    </div>
                    {!! $errors->first('invoiceid', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('paymentAmount') ? ' has-error' : '' !!}">
                    {!! Form::label('paymentAmount',  trans('payment.Payment Amount') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        {!! Form::text('paymentAmount', null, ['v-model'=>'payment','class' => 'form-control','placeholder'=>'Payment Amount']) !!}
                    </div>
                    {!! $errors->first('paymentAmount', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('amountDue') ? ' has-error' : '' !!}">
                    {!! Form::label('amountDue',  trans('payment.Amount Due') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        {!! Form::text('', null, ['v-model'=>'sum','class' => 'form-control','disabled'=>'true','placeholder'=>'Amount due']) !!}
                    </div>
                    {!! $errors->first('amountDue', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('paymentMethod') ? ' has-error' : '' !!}">
                    {!! Form::label('paymentMethod',  trans('payment.Payment Method') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-method"></i></span>
                        {!! Form::select('paymentMethod',array('Cash' => 'Cash','Cheque'=> 'Cheque','Paypal'=>'Paypal'), null, ['class' => 'form-control paymentMethod']) !!}
                    </div>
                    {!! $errors->first('paymentMethod', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('paymentDetails') ? ' has-error' : '' !!}">
                    {!! Form::label('paymentDetails',  trans('payment.Payment Details') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-list"></i></span>
                        {!! Form::text('paymentDetails', null, ['class' => 'form-control','placeholder'=>'Payment Details Cheque Number e.t.c']) !!}
                    </div>
                    {!! $errors->first('paymentDetails', '<p class="help-block">:message</p>') !!}
                </div>

            </div>
        </div>

        <div class="panel-footer">
            <button type="submit" class="btn btn-flat bg-green btn-block save_form">@lang('payment.Save')</button>
        </div>
        {!! Form::close() !!}


    </div>
@endsection

@section('jquery')
    <script>
        $(document).ready(function () {

            var app = new Vue({
                el: '#app',
                http: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                data: {
                    invoiceid: invoiceid,
                    customerid: customerid,
                    oldId: oldId,
                    payment: 0,
                    sum: 0,
                    invoices: []
                },
                methods: {},
                watch: {
                    'customerid': function (val, oldVal) {
                        if (this.customerid === undefined || this.customerid === 'null' || this.customerid === null) {
                            return 0;
                        }
                        $('.invoiceNo').select2().empty();
                        $(".invoiceNo").prop("disabled", true);
                        $.notify(
                            "Fetching Company Invoices",
                            {
                                className: 'info',
                                autoHideDelay: 5000,
                            }
                        );
                        var x = this;
                        this.$http.get('{{url('/payment/api/customer/')}}' + '/' + this.customerid).then(function (response) {
                            x.invoices = response.data;
                            x.invoiceid = oldId;
                            $.notify(
                                "Finished Checking Invoices : ",
                                {
                                    className: 'success',
                                    autoHideDelay: 5000,
                                    position: "bottom center"
                                }
                            );
                        }, function (response) {

                            // error callback
                        });

                    }
                    ,
                    'invoiceid': function (val, oldVal) {
                        if (this.invoiceid === undefined || this.invoiceid === 'null' || this.invoiceid === null) {
                            return 0;
                        }
                        //api/v1/product/ismulti/
                        $(".panel-heading").notify(
                            "Checking Amount Left to pay",
                            {
                                className: 'info',
                                autoHideDelay: 5000,
                                position: "bottom center"
                            }
                        );
                        this.$http.get('{{url('/payment/api/invoice/')}}' + '/' + this.invoiceid).then(function (response) {

                            console.log(response.data.cost);
                            this.sum = response.data.cost;
                            this.payment = response.data.cost;
                            $(".panel-heading").notify(
                                "Finished Checking Amount : ",
                                {
                                    className: 'success',
                                    autoHideDelay: 5000,
                                    position: "bottom center"
                                }
                            );

                        }, function (response) {

                            // error callback
                        });


                    }

                }
            })
            //End
        });

    </script>
@endsection