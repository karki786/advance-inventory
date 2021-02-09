@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('customer.Create A new Customer')
@endsection

@section('heading')
    @lang('customer.Create New Customer')
@endsection

@section('content')
    @include('customer.form')
@endsection

@section('js')

@endsection