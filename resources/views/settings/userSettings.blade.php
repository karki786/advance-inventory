@extends('layouts.master')

@section('title')
    Your Settings
@endsection
@section('heading')
    <h1>
        Manage your Settings

    </h1>
@endsection

@section('content')
    <div id="app">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($company, ['action' => ['CompanyController@update', $company->id], 'method' =>
                     'patch'])
                     !!}
                <tabs>
                    <tab name="Company Details" prefix="<span class='fa fa-building'> </span> ">
                        <div class="form-group{!! $errors->has('companyName') ? ' has-error' : '' !!}">
                            {!! Form::label('companyName', 'Company Name') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                {!! Form::text('companyName', null, ['class' => 'form-control','placeholder'=>'']) !!}
                            </div>
                            {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('country') ? ' has-error' : '' !!}">
                            {!! Form::label('country', 'Country') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                {!! Form::select('country',$countries, null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('city') ? ' has-error' : '' !!}">
                            {!! Form::label('city', 'City') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                {!! Form::text('city', null, ['class' => 'form-control','placeholder'=>'City']) !!}
                            </div>
                            {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('defaultCurrency') ? ' has-error' : '' !!}">
                            {!! Form::label('defaultCurrency', 'Currency') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                {!! Form::select('defaultCurrency',$currency, null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('defaultCurrency', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('street') ? ' has-error' : '' !!}">
                            {!! Form::label('street', 'Street') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                                {!! Form::text('street', null, ['class' => 'form-control','placeholder'=>'Street']) !!}
                            </div>
                            {!! $errors->first('street', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('phone') ? ' has-error' : '' !!}">
                            {!! Form::label('phone', 'Phone') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                {!! Form::text('phone', null, ['class' => 'form-control','placeholder'=>'Company Telephone']) !!}
                            </div>
                            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('zipCode') ? ' has-error' : '' !!}">
                            {!! Form::label('zipCode', 'Zip Code') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                {!! Form::text('zipCode', null, ['class' => 'form-control','placeholder'=>'Zip Code']) !!}
                            </div>
                            {!! $errors->first('zipCode', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('companySlogan') ? ' has-error' : '' !!}">
                            {!! Form::label('companySlogan', 'Company Slogan') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                                {!! Form::text('companySlogan', null, ['class' => 'form-control','placeholder'=>'Company Slogan']) !!}
                            </div>
                            {!! $errors->first('companySlogan', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('defaultLpoTaxAmmount') ? ' has-error' : '' !!}">
                            {!! Form::label('defaultLpoTaxAmmount', 'Default Lpo Tax Ammount') !!}
                            <div class="input-group">
                                {!! Form::text('defaultLpoTaxAmmount',null, ['class' => 'form-control','placeholder'=>'Default Tax on LPO']) !!}
                                <span class="input-group-addon">%</span>
                            </div>
                            {!! $errors->first('defaultLpoTaxAmmount', '<p class="help-block">:message</p>') !!}
                        </div>


                        <div class="form-group{!! $errors->has('language') ? ' has-error' : '' !!}">
                            {!! Form::label('language', 'Default Application Language') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                {!! Form::select('language',array('en'=>'English','ru'=>'Russian','de'=>'German','es'=>'Spanish','nl'=>'Dutch','fr'=>'French','pt'=>'Portuguese','in'=>'Indonesian'), null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('language', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group{!! $errors->has('image') ? ' has-error' : '' !!}">
                                    <div class="text-center"> {!! Form::label('image', 'Upload Company Logo') !!}</div>
                                    <div class="input-group col-md-12">
                                        <avatarupload
                                                url="{{url("/company/upload/photo/".$company->id)}}"
                                                token="{!! csrf_token() !!}">
                                        </avatarupload>
                                    </div>
                                    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                    </tab>
                    <tab name="Invoicing and Receipting" prefix="<span class='fa fa-list'> </span> ">
                        <div class="form-group{!! $errors->has('salesOrderNumberingFormat') ? ' has-error' : '' !!}">
                            {!! Form::label('salesOrderNumberingFormat', 'Sales Order Numbering Format') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                                {!! Form::text('salesOrderNumberingFormat', null, ['class' => 'form-control','placeholder'=>'Sales Order Numbering Format']) !!}
                                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                            </div>
                            {!! $errors->first('salesOrderNumberingFormat', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('invoiceNumberingFormat') ? ' has-error' : '' !!}">
                            {!! Form::label('invoiceNumberingFormat', 'Invoice Numbering Format') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                                {!! Form::text('invoiceNumberingFormat', null, ['class' => 'form-control','placeholder'=>'Invoice Numbering Format']) !!}
                                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                            </div>
                            {!! $errors->first('invoiceNumberingFormat', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('lpoNumberingFormat') ? ' has-error' : '' !!}">
                            {!! Form::label('lpoNumberingFormat', 'Lpo Numbering Format') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                                {!! Form::text('lpoNumberingFormat', null, ['class' => 'form-control','placeholder'=>'LPO Numbering Format']) !!}
                            </div>
                            {!! $errors->first('lpoNumberingFormat', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="alert alert-info">
                            You can use the below to choose your lpo format
                            {$lpoNumber} , {$date}, {$month}, {$year}, {$supplier} e.g
                            LPO-{$year}/{$month}/{$date}/{$lpoNumber}
                        </div>
                        <div class="form-group{!! $errors->has('purchaseOrderFormat') ? ' has-error' : '' !!}">
                            {!! Form::label('purchaseOrderFormat', 'Purchase Order Format') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                                {!! Form::select('purchaseOrderFormat',array('sales_order_1'=>'Sales Order 1','sales_order_2'=>'Sales Order 2','sales_order_2'=>'Sales Order 2'), null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('purchaseOrderFormat', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('receiptNumberingFormat') ? ' has-error' : '' !!}">
                            {!! Form::label('receiptNumberingFormat', 'Receipt Numbering Format') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                                {!! Form::text('receiptNumberingFormat', null, ['class' => 'form-control','placeholder'=>'Recipt Numbering']) !!}
                                <span class="input-group-addon"><i class="fa fa-file"></i></span>
                            </div>
                            {!! $errors->first('receiptNumberingFormat', '<p class="help-block">:message</p>') !!}
                        </div>
                    </tab>
                    <tab name="Application Settings" prefix="<span class='fa fa-cogs'> </span> ">
                        <a class="btn btn-flat bg-green btn-block" href="{{action('SettingController@createSymlink')}}">Create
                            Storage Link Shortcut</a>
                        <div class="form-group{!! $errors->has('enableBetaFeatures') ? ' has-error' : '' !!}">
                            {!! Form::label('enableBetaFeatures', 'Enable Beta Features') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-cogs"></i></span>
                                {!! Form::select('enableBetaFeatures',array(0=>'Do not enable Beta features',1=>'Enable Beta Features'), null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('enableBetaFeatures', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('enableStaffDispatch') ? ' has-error' : '' !!}">
                            {!! Form::label('enableStaffDispatch', 'Enable Staff Dispatches') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                {!! Form::select('enableStaffDispatch',array(0=>'Do not enable Dispatching to Staff',1=>'Enable Dispatching to Staff'), null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('enableStaffDispatch', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('userToRunCron') ? ' has-error' : '' !!}">
                            {!! Form::label('userToRunCron', 'User that will be used to run Cron Jobs') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                {!! Form::select('userToRunCron',$users, null, ['class' => 'form-control']) !!}
                            </div>
                            {!! $errors->first('userToRunCron', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('companyCliReports') ? ' has-error' : '' !!}">
                            {!! Form::label('companyCliReports', 'Cli Reports Email') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                {!! Form::text('companyCliReports', null, ['class' => 'form-control','placeholder'=>'reports']) !!}
                            </div>
                            {!! $errors->first('companyCliReports', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group{!! $errors->has('homepage') ? ' has-error' : '' !!}">
                                {!! Form::label('homepage', 'Default Homepage') !!}
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                    {!! Form::text('homepage', null, ['class' => 'form-control','placeholder'=>'']) !!}
                                </div>
                                {!! $errors->first('homepage', '<p class="help-block">:message</p>') !!}
                            </div>

                    </tab>
                    <button type="submit" class="btn btn-flat save_form bg-green btn-block">Save Company Info
                    </button>
                </tabs>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('jquery')
    <script>

        //Colorpicker
        app = new Vue({
            el: '#app',
            data: {}
        });
    </script>

@endsection