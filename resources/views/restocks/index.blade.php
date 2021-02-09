@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('restock.View Restock Logs')
@endsection






@section('content')
    @include('restocks.tableview')
@endsection



@section('jquery')
    <script>
        var table = $('table').DataTable({
            responsive: true

        });
    </script>
@endsection
