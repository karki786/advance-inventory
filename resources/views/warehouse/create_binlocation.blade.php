@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('warehouse.Create Bin Location')
@endsection

@section('sidebar')

@endsection

@section('content')
    @include('warehouse.form_binlocation')
@endsection

@section('js')

@endsection