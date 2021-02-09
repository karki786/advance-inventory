@extends('emails.master')

@section('content')
    Dear {{$invoice->customerText}},<br/>
    The below items have been delivered on {{\Carbon\Carbon::today()->format('Y-m-d')}}, <br/><br/>
    <table>
        <thead>
        <tr>
            <td style="padding: 5px;"> Description</td>
            <td style="padding: 5px;">Quantity</td>
            <td style="padding: 5px;">Cost</td>
        </tr>
        </thead>
        <tbody>
        @foreach($invoice->items as $item)
            <tr style="padding: 5px;">
                <td style="padding: 5px;">{{$item->productDescription}}</td>
                <td style="padding: 5px;"> {{$item->quantity-$item->returned}} </td>
                <td style="padding: 5px;"> {{number_format($item->total + $item->tax,2)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <br/>
    Total for the above items is <b>{{number_format($invoice->items->sum('total')+$invoice->items->sum('tax'),2)}}</b>
    <br/>
    Your current due ammount is {{$dueAmmount}}

@endsection