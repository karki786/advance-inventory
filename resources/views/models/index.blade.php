@extends('layouts.master')

@section('title')
    Custom Fields
@endsection

@section('sidebar')
    <div class="panel panel-default cls-panel">
        <div class="panel-heading">
            <h3 class="panel-title">Add a column to a table</h3>
        </div>
        <div class="panel-body">
            @include('models.forms')
        </div>
    </div>

@endsection

@section('content')
    <h1 class="text-center">Custom Columns</h1>
    <hr/>
    <table class="table table-paper table-condensed table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Column Name</th>
            <th>Table</th>
            <th>Loop Name</th>
            <th>Column Type</th>
            <th>Fontawesome Icon</th>
            <th>Input Label</th>
            <th>Render As</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        <?php $i = 1; ?>
        @foreach ($columns as $column)
            <tr class="">
                <th scope="row">{{$i}}</th>
                <td>{{ucwords($column->columnName)}}</td>
                <td>{{$column->table}}</td>
                <td>{{$column->loop}} </td>
                <td>{{$column->columnType}}</td>
                <td>{{$column->fontawesome}}</td>
                <td>{{$column->userView}}</td>
                <td>{{$column->renderAs}}</td>
                <td>{{Carbon::parse($column->created_at)->format('d/m/Y')}} </td>
                <td class="text-center">
                    <div aria-label="Actions" role="group" class="btn-group">
                        @if(isset($restore))
                            <a href="{{action('ModelModifyController@restore', $column->id)}}" class="btn btn-warning"><i
                                        class="fa fa-undo"></i></a>
                        @else
                            <a href="#delete-popup" class="open-popup-link btn btn-primary"
                               data-url="{{action('ModelModifyController@destroy', $column->id)}}"><i
                                        class="fa fa-remove"></i></a>
                        @endif

                    </div>
                </td>
                <?php $i++; ?>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
@include('models.partials.deletepartial')
@section('js')
    function format(icon) {
    var originalOption = icon.element;
    console.log("here");
    return '<i class="fa ' + icon.text + '"></i> ' + icon.text;
    }
    $('.fontawesome').select2({
    width: "100%",
    templateResult: format,
    escapeMarkup: function(m) {
    // Do not escape HTML in the select options text
    return m;
    }
    });

@endsection