@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('supplier.View All Suppliers')
@endsection


@section('heading')
    {!! Helper::translateAndShorten('Suppliers','supplier',15)!!}
@endsection

@section('content')
    @include('suppliers.tableview')

    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">Suppliers Log</h3>
        </div>
        <div class="box-body">
            <div class="stats-container" id="stats-container"></div>
        </div>
    </div>

@endsection
@section('js')

    @if(isset($supplierAmountReport))
        var data = JSON.parse('{!!$supplierAmountReport!!}');
        Morris.Donut({
        element: 'stats-container',
        data:data
        });
    @endif
@endsection

@section('jquery')
    <script>
        var table = $('table').DataTable({
            responsive: true

        });
    </script>
@endsection

