<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>#</th>
    <th>Invoice Numbers</th>
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
@foreach($invoices as $invoice)
    <tr>
        <td scope="row">{{$i}}</td>
        <th>{{$invoice->invoiceNo}}</th>
        <td>{{ucwords($invoice->customerText)}}</td>
        <td>{{$invoice->salesPersonText}}</td>
        <td>{{$invoice->currencyTypeText}} </td>
        <td>{{$invoice->present()->paymentMethod}}</td>
        <td>{{number_format($invoice->items->sum('total'),2)}}</td>
        <td>{{Carbon::parse($invoice->created_at)->format('d/m/Y')}} </td>
        <td>{{Carbon::parse($invoice->updated_at)->format('d/m/Y')}} </td>
    </tr>
    <?php $i++; ?>
@endforeach
</body>
</html>