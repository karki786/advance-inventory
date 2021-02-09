<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>#</th>
    <th>Order No</th>
    <th>Customer</th>
    <th>Sales Person</th>
    <th>Currency</th>
    <th>Payment Method</th>
    <th>Total</th>
    <th>Created On</th>
    <th>Last Revised</th>
</tr>
</thead>
<?php $i = 1; ?>
@foreach($salesOrders as $order)
    <tr>
        <td scope="row">{{$i}}</td>
        <th>{{$order->orderNo}}</th>
        <td>{{ucwords($order->customerText)}}</td>
        <td>{{$order->salesPersonText}}</td>
        <td>{{$order->currencyTypeText}} </td>
        <td>{{$order->present()->paymentMethod}}</td>
        <td>{{number_format($order->items->sum('total'),2)}}</td>
        <td>{{Carbon::parse($order->created_at)->format('d/m/Y')}} </td>
        <td>{{Carbon::parse($order->updated_at)->format('d/m/Y')}} </td>
    </tr>
    <?php $i++; ?>
@endforeach
</body>
</html>