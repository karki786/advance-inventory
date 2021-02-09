<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>#</th>
    <th>Invoice Number</th>
    <th>Customer</th>
    <th>Payment Method</th>
    <th>Payment Amount</th>
    <th>Payment Details</th>
    <th>Created At</th>
</tr>
</thead>
<?php $i = 1; ?>
@foreach($payments as $payment)
    <tr>
        <th scope="row">{{$i}}</th>
        <td>{{ucwords($payment->invoice->invoiceNo)}}
            @if($payment->invoice->deleted_at == null)
                (<a href="{{action('InvoiceController@show', $payment->id)}}">View Invoice</a>)
            @else
(-Deleted Invoice -)
            @endif
        </td>
        <td>{{ucwords($payment->invoice->customerText)}}</td>
        <td>{{$payment->paymentMethod}}</td>
        <td>{{number_format($payment->paymentAmount,2)}}</td>
        <td>{{$payment->paymentDetails}} </td>
        <td>{{Carbon::parse($payment->created_at)->format('d/m/Y')}}</td>
    </tr>
    <?php $i++; ?>
@endforeach
</body>
</html>