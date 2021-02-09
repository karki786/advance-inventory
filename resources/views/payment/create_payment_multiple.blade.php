@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('payment.Record Payment')
@endsection

@section('content')

    <div class="panel panel-default cls-panel">
        <div class="panel-heading">
            <h3 class="panel-title">
                @lang('payment.Create Payment')
            </h3>
        </div>
        @if(isset($payment))
            {!! Form::model($payment, ['action' => ['PaymentController@groupSave', $payment->id], 'method' =>
            'patch'])
            !!}
        @else
            {!! Form::open(array('action' => 'PaymentController@groupSave', 'files'=>false)) !!}
        @endif


        <div class="panel-body">
            <div class="form-group{!! $errors->has('customerId') ? ' has-error' : '' !!}">
                {!! Form::label('customerId', 'Customer') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::select('customerId',$customers, null, ['v-selecttwo'=>'customerid','class' => 'form-control customer']) !!}
                </div>
                {!! $errors->first('customerId', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{!! $errors->has('paymentDue') ? ' has-error' : '' !!}">
                {!! Form::label('paymentDue',  trans('payment.Due Payment') ) !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    {!! Form::text('paymentDue', null, ['v-model'=>'payment','disabled'=>'disabled','class' => 'form-control','placeholder'=>'Payment Amount']) !!}
                </div>
                {!! $errors->first('paymentDue', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{!! $errors->has('paymentAmount') ? ' has-error' : '' !!}">
                {!! Form::label('paymentAmount',  trans('payment.Payment Amount') ) !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    {!! Form::text('paymentAmount', null, ['class' => 'form-control','placeholder'=>'Payment Amount']) !!}
                </div>
                {!! $errors->first('paymentAmount', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{!! $errors->has('paymentCredit') ? ' has-error' : '' !!}">
                {!! Form::label('paymentCredit',  trans('payment.Payment Credit') ) !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-list"></i></span>
                    {!! Form::text('paymentCredit', null, ['v-model'=>'credit','class' => 'form-control','placeholder'=>'Payment Details Cheque Number e.t.c']) !!}
                </div>
                {!! $errors->first('paymentCredit', '<p class="help-block">:message</p>') !!}
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


            <div class="form-group{!! $errors->has('paymentRemarks') ? ' has-error' : '' !!}">
                {!! Form::label('paymentRemarks',  trans('payment.Payment Remarks') ) !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                    {!! Form::text('paymentRemarks', null, ['class' => 'form-control','placeholder'=>'Payment Remarks']) !!}
                    <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                </div>
                {!! $errors->first('paymentRemarks', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group{!! $errors->has('paymentType') ? ' has-error' : '' !!}">
                {!! Form::label('paymentType',  trans('payment.Payment Type') ) !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-list"></i></span>
                    {!! Form::select('paymentType',array('Discount'=>'Discount','Compensation'=>'Compensation','Cash Received'=>'Cash Received'), null, ['class' => 'form-control']) !!}
                    <span class="input-group-addon"><i class="fa fa-list"></i></span>
                </div>
                {!! $errors->first('paymentType', '<p class="help-block">:message</p>') !!}
            </div>


        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-flat bg-green btn-block">@lang('payment.Save')</button>
        </div>
        {!! Form::close() !!}
    </div>


@endsection

@section('jquery')
    <script>
        $(document).ready(function () {
            $('.invoiceNo , .paymentMethod, .customer').select2({})

            Vue.directive('selecttwo', {
                twoWay: true,
                bind: function () {
                    $(this.el).select2({
                                width: '100%',
                                placeholder: "Select an option",
                                allowClear: true
                            })
                            .on("select2:select", function (e) {
                                this.set($(this.el).val());
                                // $(this.el).select2("val", "");
                            }.bind(this)).on("change", function (e) {
                        this.set($(this.el).val());
                        // $(this.el).select2("val", "");
                    }.bind(this));
                },
                update: function (nv, ov) {
                    $(this.el).trigger("change");
                }
            });
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
                    invoiceid: '',
                    customerid: '',
                    payment: 0,
                    sum: 0,
                    credit: 0
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
                        this.$http.get('{{url('/payment/api/customer/cost/')}}' + '/' + this.customerid).then(function (response) {

                            console.log(response.data.cost);
                            this.sum = response.data.cost;
                            this.payment = response.data.cost;
                            this.credit = response.data.credit;
                            $(".invoiceNo").prop("disabled", false);
                            $(".panel-heading").notify(
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