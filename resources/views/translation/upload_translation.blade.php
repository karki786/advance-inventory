@extends('layouts.master')

@section('title')
    Manage Translation
@endsection
@section('heading')
    Manage Languages
@endsection


@section('content')
    @if(isset($upload))
        {!! Form::model($upload, ['action' => ['TranslationController@upload', $upload->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'TranslationController@upload', 'files'=>true)) !!}
    @endif
    <div class="form-group{!! $errors->has('module') ? ' has-error' : '' !!}">
        {!! Form::label('module', 'Module') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-list"></i></span>
            {!! Form::select('module',$modules, null, ['class' => 'form-control']) !!}
            <span class="input-group-addon"><i class="fa fa-list"></i></span>
        </div>
        {!! $errors->first('module', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group{!! $errors->has('language') ? ' has-error' : '' !!}">
        {!! Form::label('language', 'Language') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-globe"></i></span>
            {!! Form::text('language', null, ['class' => 'form-control','placeholder'=>'Language']) !!}
            <span class="input-group-addon"><i class="fa fa-globe"></i></span>
        </div>
        {!! $errors->first('language', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group{!! $errors->has('files') ? ' has-error' : '' !!}">
        {!! Form::label('files', 'Upload Files') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-file"></i></span>
            {!! Form::file('files',  ['class' => 'form-control']) !!}
            <span class="input-group-addon"><i class="fa fa-file"></i></span>
        </div>
        {!! $errors->first('files', '<p class="help-block">:message</p>') !!}
    </div>

    <button type="submit" class="btn btn-flat bg-green btn-block">Save</button>

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