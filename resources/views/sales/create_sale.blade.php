@extends('layouts.master')


@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('createsale.Create Sale')
@endsection

@section('content')
    @if(isset($sale))
        {!! Form::model($sale, ['action' => ['SalesController@update', $sale->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'SalesController@store', 'files'=>false)) !!}
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

    <div class="row">
        <div class="col-md-8">
            <grid></grid>

        </div>
        <div class="col-md-4">
            <div class="panel panel-default cls-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        @lang('createsale.Extra Details')
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="form-group{!! $errors->has('customerId') ? ' has-error' : '' !!}">
                        {!! Form::label('customerId',  trans('createsale.Company Name') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::select('customerId',$customers, null, ['v-selecttwo'=>'customerId','class' => 'form-control']) !!}
                        </div>
                        {!! $errors->first('customerId', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group{!! $errors->has('contactId') ? ' has-error' : '' !!}">
                        {!! Form::label('contactId',  trans('createsale.Contact Person') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::select('contactId',array(), null, ['class' => 'form-control contacts']) !!}
                        </div>
                        {!! $errors->first('contactId', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group{!! $errors->has('onHold') ? ' has-error' : '' !!}">
                        {!! Form::label('onHold',  trans('createsale.Hold Items') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                            {!! Form::select('onHold',array(0=>'Sale',1=>'On Hold For Client'), null, ['v-selecttwo'=>'onHold','class' => 'form-control onHold']) !!}
                        </div>
                        {!! $errors->first('onHold', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group{!! $errors->has('saleType') ? ' has-error' : '' !!}">
                        {!! Form::label('saleType',  trans('createsale.Sale Type') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                            {!! Form::select('saleType',array(0=>'Quotation',1=>'Sales Order',2=>'Invoice'), 1, ['v-selecttwo'=>'salesType','class' => 'form-control salesType']) !!}
                        </div>
                        {!! $errors->first('saleType', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group{!! $errors->has('generatePackingSlip') ? ' has-error' : '' !!}">
                        {!! Form::label('generatePackingSlip',  trans('createsale.Generate Packing Slip') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                            {!! Form::select('generatePackingSlip',array(0=>'Do not Generate',1=>'Generate Packing Clip'), null, ['class' => 'form-control']) !!}
                        </div>
                        {!! $errors->first('generatePackingSlip', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group{!! $errors->has('emailCustomer') ? ' has-error' : '' !!}">
                        {!! Form::label('emailCustomer',  trans('createsale.Email Customer') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            {!! Form::select('emailCustomer',array(0=>'Dont Send Email',1=>'Send Email'), null, ['class' => 'form-control']) !!}
                        </div>
                        {!! $errors->first('emailCustomer', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group{!! $errors->has('paymentMethod') ? ' has-error' : '' !!}">
                        {!! Form::label('paymentMethod',  trans('createsale.Payment Method') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                            {!! Form::text('paymentMethod', 'Cash', ['disabled'=>'true','class' => 'form-control','placeholder'=>'Payment Method']) !!}
                        </div>
                        {!! $errors->first('paymentMethod', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group{!! $errors->has('paymentTerms') ? ' has-error' : '' !!}">
                        {!! Form::label('paymentTerms',  trans('createsale.Payment Terms') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                            {!! Form::textarea('paymentTerms', null, ['rows'=>'2','class' => 'form-control','placeholder'=>'Payment Terms']) !!}
                        </div>
                        {!! $errors->first('paymentTerms', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group{!! $errors->has('remark') ? ' has-error' : '' !!}">
                        {!! Form::label('remark', trans('createsale.Remarks') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                            {!! Form::textarea('remark', null, ['rows'=>'3','class' => 'form-control','placeholder'=>'Remarks']) !!}
                        </div>
                        {!! $errors->first('remark', '<p class="help-block">:message</p>') !!}
                    </div>

                    <button type="submit" class="btn btn-flat bg-green btn-block">@lang('createsale.Save')</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection

@include('layouts.partials.grid_component')
@section('jquery')
    <script>
        Vue.config.debug = true
        Vue.directive('selecttwo', {
            twoWay: true,
            bind: function () {
                $(this.el).select2({
                            width: '100%',
                            placeholder: "Select an option",
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
                @stack('scripts')

        var vm = new Vue({
                    el: 'body',
                    data: {
                        salesType: 0,
                        onHold: 0,
                        customerId: 0
                    },
                    watch: {
                        customerId: function () {
                            $('.contacts').select2().empty();
                            $(".contacts").prop("disabled", true);
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

                                $('.contacts').select2({
                                    data: response.data
                                });
                                $(".contacts").prop("disabled", false);
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

                        },
                        onHold: function () {
                            console.log("here");
                            if (this.onHold == 1) {
                                $(".salesType").select2().val("0").trigger('change');
                            } else if (this.onHold == 0) {
                                $(".salesType").select2().val("1").trigger('change');
                            }
                        }
                    }
                });
    </script>
@endsection