<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<table class="table no-margin">

    <tr>
        <td>
            <b>Report Type</b>
        </td>
        <td colspan="5" >
            Delivery Times for Lpo's
        </td>

    </tr>
    <tr>
        <td>
            <b>Supplier</b>
        </td>
        <td colspan="5" >
            {{$supplier->supplierName}}
        </td>
    </tr>
</table>
<table class="table no-margin">
    <thead>
    <tr>
        <th>LPO Number</th>
        <th>LPO Date</th>
        <th>Requested Delivery Date</th>
        <th>Delivery Date</th>
        <th>Delivered</th>
        <th>Delivery Time in Days</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($lpos as $lpo)
        <tr class="">
            <td>{{$lpo->lpoNumber}}</td>
            <td>{{ucwords($lpo->lpoDate)}}</td>
            <td>{{ucwords($lpo->polDeliverBy)}}</td>
            <td>{{ucwords($lpo->updated_at)}}</td>
            <td>{{$lpo->present()->lpoStatus}}</td>
            <td>{{$lpo->present()->getDeliveryTime}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

