@extends('layouts.master')

@section('title', 'View POS Sale')

@section('content')
    <section class="content-header">
        <h1>
            View Sales
            <small>View Sales</small>
        </h1>

    </section>
    <hr/>

    <table class="table table-paper table-condensed table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Receipt No</th>
            <th>Sales Person</th>
            <th>Currency Type</th>
            <th>Amount</th>
            <th>Actions</th>

        </tr>
        </thead>
        <tbody>

        <?php $i = 1; ?>
        @foreach ($receipts as $receipt)
            <tr class="">
                <th scope="row">{{$i}}</th>
                <td>{{ucwords($receipt->receiptNo)}}</td>
                <td>{{$receipt->salesPersonText}}</td>
                <td>{{$receipt->currencyTypeText}} </td>
                <td>{{number_format($receipt->items->sum('total'),2)}}</td>
                <td>
                    <div aria-label="Actions" role="group" class="btn-group">
                        <a href="#delete-popup" class="open-popup-link btn btn-flat bg-red"
                           data-url="{{action('ReceiptController@destroy', $receipt->id)}}"><i
                                    class="fa fa-remove"></i></a>
                        <a class="btn btn-flat bg-blue" href="{{action('ReceiptController@edit', $receipt->id)}}"> <i
                                    class="   fa fa-edit"></i></a>
                        <a class="btn btn-flat bg-purple" href="{{action('ReceiptController@show', $receipt->id)}}"> <i
                                    class="  fa fa-eye"></i></a>
                    </div>
                </td>
                <?php $i++; ?>
            </tr>
        @endforeach

        </tbody>
    </table>


@endsection

@section('jquery')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection