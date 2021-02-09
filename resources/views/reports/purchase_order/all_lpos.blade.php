<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->

<thead>
<tr>
    <th>#</th>
    <th>{{ trans('orders.Supplier') }}</th>
    <th> {{ trans('orders.Deliver By') }}</th>
    <th>{{ trans('orders.Lpo') }}</th>
    <th>{{ trans('orders.Payment') }}</th>
    <th>{{ trans('orders.Status') }}</th>
    <th>
        {{ trans('orders.LPO Date') }}
    </th>
    <th>{{ trans('orders.Delivered') }}</th>

</tr>
</thead>


<?php $i = 1; ?>
@foreach ($purchaseOrders as $order)
    <tr>

        <th>{{$i}}</th>
        <td>{{ucwords($order->supplier->supplierName)}}</td>

        <td>{{$order->present()->delivery}} </td>
        <td>{{$order->lpoNumber}}</td>
        <td>{!!$order->present()->totalCash!!}</td>
        <td>{{ucfirst($order->lpoStatus)}}</td>
        <td>{{$order->lpoDate}} </td>
        <th>{{$order->present()->delivered}}</th>
        <?php $i++; ?>
    </tr>
@endforeach

</body>
</html>

