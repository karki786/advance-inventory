@extends('layouts.master')

@section('title')
    Manage Translation
@endsection
@section('heading')
    Manage Language Translations
@endsection


@section('content')
    @if(isset($translation))
        {!! Form::model($translation, ['action' => ['TranslationController@update', $translation->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'TranslationController@store', 'files'=>false)) !!}
    @endif




    <div class="form-group{!! $errors->has('language') ? ' has-error' : '' !!}">
        {!! Form::label('language', 'Language') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-globe"></i></span>
            {!! Form::text('language', $language, ['class' => 'form-control','placeholder'=>'Language']) !!}
        </div>
        {!! $errors->first('language', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group{!! $errors->has('module') ? ' has-error' : '' !!}">
        {!! Form::label('module', 'Module') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-list"></i></span>
            {!! Form::select('module',$modules, null, ['class' => 'form-control']) !!}
        </div>
        {!! $errors->first('module', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group{!! $errors->has('orig_lang') ? ' has-error' : '' !!}">
        {!! Form::label('orig_lang', 'Original Text') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-comment"></i></span>
            {!! Form::text('orig_lang', null, ['class' => 'form-control','placeholder'=>'Original Text']) !!}
        </div>
        {!! $errors->first('orig_lang', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group{!! $errors->has('trans_lang') ? ' has-error' : '' !!}">
        {!! Form::label('trans_lang', 'Translated Text') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-comment-o"></i></span>
            {!! Form::text('trans_lang', null, ['class' => 'form-control','placeholder'=>'Translated Text']) !!}
        </div>
        {!! $errors->first('trans_lang', '<p class="help-block">:message</p>') !!}
    </div>
    <input type="hidden" name="languageId" value="{{$id}}"/>
    <button type="submit" class="btn btn-flat bg-green btn-block">Translate</button>

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