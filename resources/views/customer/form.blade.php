@if(isset($customer))
    {!! Form::model($customer, ['action' => ['CustomerController@update', $customer->id], 'method' =>
    'patch'])
    !!}
    <script>
        window.contacts = {!! json_encode($contacts)  !!};
    </script>
@else
    {!! Form::open(array('action' => 'CustomerController@store', 'files'=>false)) !!}
    <script>
        @if(old('contacts'))
            window.contacts = {!! json_encode(old('contacts')) !!}
                @else
            window.contacts = [];
                @endif

    </script>
@endif
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default cls-panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    @lang('customer.Customer Details')
                </h3>
            </div>

            <div class="panel-body">
                <div class="form-group{!! $errors->has('companyName') ? ' has-error' : '' !!}">
                    {!! Form::label('companyName', trans('customer.Company')) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-building"></i></span>
                        {!! Form::text('companyName', null, ['class' => 'form-control','placeholder'=>'Company']) !!}
                    </div>
                    {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('companyCurrency') ? ' has-error' : '' !!}">
                    {!! Form::label('companyCurrency',  trans('customer.Company Currency') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        {!! Form::select('companyCurrency',$currency, $def_currency, ['class' => 'form-control currency']) !!}
                    </div>
                    {!! $errors->first('companyCurrency', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('country') ? ' has-error' : '' !!}">
                    {!! Form::label('country',  trans('customer.Country') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                        {!! Form::select('country',$countries, null, ['class' => 'form-control country']) !!}
                    </div>
                    {!! $errors->first('country', '<p class="help-block">:message</p>') !!}
                </div>

                <div class="form-group{!! $errors->has('city') ? ' has-error' : '' !!}">
                    {!! Form::label('city',  trans('customer.City') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('city', null, ['class' => 'form-control','placeholder'=>'City']) !!}

                    </div>
                    {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('customerType') ? ' has-error' : '' !!}">
                    {!! Form::label('customerType',  trans('customer.Customer Type') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        {!! Form::select('customerType',array(0=>'Cash',1=>'Credit'), null, ['class' => 'form-control']) !!}
                    </div>
                    {!! $errors->first('customerType', '<p class="help-block">:message</p>') !!}
                </div>


            </div>
        </div>
    </div>
    <div class=col-md-6>
        <div class="panel panel-default cls-panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    @lang('customer.Customer Finance Details')
                </h3>
            </div>

            <div class="panel-body">
                <div class="form-group{!! $errors->has('creditLimit') ? ' has-error' : '' !!}">
                    {!! Form::label('creditLimit',  trans('customer.Credit Limit') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        {!! Form::text('creditLimit', null, ['class' => 'form-control','placeholder'=>'Credit Limit']) !!}

                    </div>
                    {!! $errors->first('creditLimit', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('days') ? ' has-error' : '' !!}">
                    {!! Form::label('days',  trans('customer.Credit Limit Days') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        {!! Form::text('days', null, ['class' => 'form-control','placeholder'=>'Credit Limit Days']) !!}

                    </div>
                    {!! $errors->first('days', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('active') ? ' has-error' : '' !!}">
                    {!! Form::label('active',  trans('customer.Active') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                        {!! Form::select('active',array(0=>'Active',1=>'Disabled'), null, ['class' => 'form-control status']) !!}

                    </div>
                    {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('disableReason') ? ' has-error' : '' !!}">
                    {!! Form::label('disableReason',  trans('customer.Disable Reason') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                        {!! Form::text('disableReason', null, ['class' => 'form-control','placeholder'=>'Disable Reason']) !!}

                    </div>
                    {!! $errors->first('disableReason', '<p class="help-block">:message</p>') !!}
                </div>
                <div class="form-group{!! $errors->has('companyEmail') ? ' has-error' : '' !!}">
                    {!! Form::label('companyEmail',  trans('customer.Company Email') ) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        {!! Form::text('companyEmail', null, ['class' => 'form-control','placeholder'=>'Company Email']) !!}

                    </div>
                    {!! $errors->first('companyEmail', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default cls-panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Customer Login Details
        </h3>
    </div>

    <div class="panel-body">
        <div class="form-group{!! $errors->has('email') ? ' has-error' : '' !!}">
            {!! Form::label('email',  trans('customer.Customer Email') ) !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                {!! Form::text('email', null, ['class' => 'form-control','placeholder'=>'Email']) !!}
            </div>
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group{!! $errors->has('password') ? ' has-error' : '' !!}">
            {!! Form::label('password', 'Password (If a password is set it will show up as encrypted type a new password to reset it)') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                {!! Form::text('password', $password, ['class' => 'form-control','placeholder'=>'Password']) !!}
            </div>
            {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div id="app">
        <div class="col-md-12">
            <div class="panel panel-default cls-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        @lang('customer.Customer Contacts')
                        (@lang('customer.You can add multiple Contact People here'))
                    </h3>
                </div>

                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <span v-for="contact in contacts">
                <div class="form-group">
                    <label for="customerName">@lang('customer.Customer Name')</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input class="form-control" v-model="contact.customerName" type="text"
                               id="customerName">
                    </div>
                </div>

                    <div class="form-group">
                        <label for="telephoneNumber">@lang('customer.Telephone Number')</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            <input class="form-control" placeholder="Telephone Number" v-model="contact.telephoneNumber"
                                   type="text" id="telephoneNumber">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="mobileNumber">@lang('customer.Mobile Number')</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            <input class="form-control" placeholder="Mobile Number" v-model="contact.mobileNumber"
                                   type="text"
                                   id="mobileNumber">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="street">@lang('customer.Street')</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                            <input class="form-control" placeholder="Street" v-model="contact.street" type="text"
                                   id="street">

                        </div>

                    </div>

                    <div class="form-group">
                        <label for="address1">@lang('customer.Address 1')</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                            <input class="form-control" placeholder="Address" v-model="contact.address1" type="text"
                                   id="address1">

                        </div>

                    </div>
                    <div class="form-group">
                        <label for="address2">@lang('customer.Address 2')</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                            <input class="form-control" placeholder="Address" v-model="contact.address2" type="text"
                                   id="address2">

                        </div>

                    </div>
                    
                    <div class="form-group">
                        <label for="address2">@lang('customer.House Number')</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                            <input class="form-control" placeholder="Address" v-model="contact.houseno" type="text"
                                   id="houseno">

                        </div>

                    </div>
                    <div class="form-group">
                        <label for="address2">@lang('customer.Society Name')</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                            <input class="form-control" placeholder="Address" v-model="contact.societyname" type="text"
                                   id="societyname">

                        </div>

                    </div>

                    <div class="form-group">
                        <label for="zipCode">@lang('customer.Zip Code')</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                            <input class="form-control" placeholder="Zip Code" v-model="contact.zipCode" type="text"
                                   id="zipCode">

                        </div>

                    </div>

                    <div class="form-group">
                        <label for="zipCode">@lang('customer.Email')</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input class="form-control" placeholder="Zip Code" v-model="contact.email" type="text"
                                   id="email">

                        </div>

                    </div>

<hr/>
                    </span>

                    <div class="text-center" v-on:click="addContact" style="color: green; font-size: 18px;"><i
                                class="fa fa-plus-circle"></i></div>
                </div>
            </div>
        </div>
        <input type="hidden" name="contacts" v-bind:value="cnts">
    </div>
</div>


<button type="submit" class="btn btn-flat bg-green btn-block save_form">@lang('customer.Create Customer')</button>


{!! Form::close() !!}

@section('jquery')
    <script>
        $('.date').datepicker({
            format: "yyyy/mm/dd"
        });

        $('.country,.currency, .status,.vac').select2({});
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
        var vm = new Vue({
                el: '#app',
                data: {
                    contacts: contacts
                },
                methods: {
                    addContact: function () {
                        obj = {
                            customerName: '',
                            telephoneNumber: '',
                            mobileNumber: '',
                            street: '',
                            address1: '',
                            address2: '',
                            zipCode: '',
                            email: '',
                            houseno: '',
                            societyname: '',
                        }
                        this.contacts.push(obj);
                    }
                },
                computed: {
                    cnts: function () {
                        return JSON.stringify(this.contacts)
                    }
                },
                watch: {}
            })
        ;


    </script>
@endsection
