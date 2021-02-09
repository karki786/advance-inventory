@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('supplier.Add New Supplier')
@endsection

@section('heading')
    Add New Supplier
@endsection

@section('content')
    @include('suppliers.form')
@endsection

@section('js')

@endsection