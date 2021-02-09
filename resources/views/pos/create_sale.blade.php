@extends('layouts.master')

@section('title', 'Record POS Sale')

@section('content')
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
    @if(isset($receipt))
        {!! Form::model($receipt, ['action' => ['ReceiptController@update', $receipt->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'ReceiptController@store', 'files'=>false)) !!}
    @endif
    <div class="row">
        <div class="col-md-8">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <grid></grid>

        </div>
    </div>


      <button type="submit" class="btn btn-flat bg-green btn-block">Save</button>
    {!! Form::close() !!}



@endsection

@include('layouts.partials.grid_component')
@section('jquery')
    <script>

        Vue.config.debug = true;
        @stack('scripts')
        $('.contacts').select2({});
        $('.salesorder').select2({});
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
            el: 'body',
            data: {
                salesType: 2,
                onHold: 0,
                customerId: 0
            },
            watch: {
                customerId: function () {
                    if (this.customerId === undefined || this.customerId === 'null' || this.customerId === null || this.customerId == "") {
                        return 0;
                    }
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
                        @if(isset($invoice))
                         $(".contacts").val({{$invoice->contactId}}).trigger("change");
                        @endif
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