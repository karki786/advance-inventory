@extends('layouts.master')

@section('title')
    Manage Translation
@endsection
@section('heading')
    Manage Languages
@endsection


@section('content')
    @if(isset($language))
        {!! Form::model($language, ['action' => ['LanguageController@update', $language->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'LanguageController@store', 'files'=>false)) !!}
    @endif
    <div class="form-group{!! $errors->has('language') ? ' has-error' : '' !!}">
        {!! Form::label('language', 'Language 2 Letter Code') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-globe"></i></span>
            {!! Form::text('language', null, ['class' => 'form-control','placeholder'=>'Language 2 Letter Code']) !!}
        </div>
        {!! $errors->first('language', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group{!! $errors->has('language_full') ? ' has-error' : '' !!}">
        {!! Form::label('language_full', 'Full Language Text') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-globe"></i></span>
            {!! Form::text('language_full', null, ['class' => 'form-control','placeholder'=>'Full Language Text']) !!}
        </div>
        {!! $errors->first('language_full', '<p class="help-block">:message</p>') !!}
    </div>
    <button type="submit" class="btn btn-flat bg-green btn-block">Add Language</button>



    {!! Form::close() !!}



@endsection




@section('jquery')
    <script>
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
                locationId: 0,
                productId: productId,
                binLocationId: binLocationId

            },
            methods: {
                prodPicked: function (val) {
                    this.fullhash = val;
                    this.$http({
                        url: '{{url('api/dispatch/item')}}' + '/' + val,
                        method: 'GET',
                    }).then(function (response) {
                        this.productId = response.data.prod_id;
                        this.productLocationHash = response.data.hash;
                        this.dispatchedItem = response.data.prod_id;
                        this.hash = response.data.hash;
                        console.log(response.data);
                    }, function (response) {
                        // error callback
                    });

                }
            },
            watch: {
                'amount': function () {
                    var x = this;
                    this.$http({
                        url: '{{action('Api\SalesOrderItemController@validateInventory')}}',
                        method: 'GET',
                        params: {
                            'productId': x.fullhash,
                            'quantity': x.amount
                        }
                    }).then(function (response) {
                        var data = response.data;
                        console.log(data);
                        if (data.enough === false) {
                            var string = 'Over Dispatch Only ' + data.amount + ' items can be dispatched';
                            x.error = string;
                            x.has_error = true;
                        } else {
                            x.has_error = false;
                        }
                    });


                }
            }
        });


    </script>
@endsection