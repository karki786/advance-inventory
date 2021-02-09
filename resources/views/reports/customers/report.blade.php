<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>#</th>
    <th>Company Name</th>
    <th>Customer Type</th>
    <th>Quotes</th>
    <th>Quotes Amount</th>
    <th>Invoices</th>
    <th>Invoices Amount</th>
    <th>Invoices Payments</th>
    <th>Company Email</th>
    <th>Tel</th>
</tr>
</thead>
<?php $i = 1; ?>
@foreach($customers as $customer)
    <tr>
        <td scope="row">{{$i}}</td>
        <td>{{ucwords($customer->companyName)}}</td>
        <td>{{$customer->customerType}}</td>
        <td>{{count($customer->quotes)}}</td>
        <td>{{number_format($customer->salesItems->sum('total'),2)}}</td>
        <td>{{count($customer->invoices)}}</td>
        <td>{{number_format($customer->invoiceItems->sum('total'),2)}}</td>
        <td>{{number_format($customer->payments->sum('paymentAmount'),2)}}</td>
        <td>{{$customer->companyEmail}} </td>
        <td>Mob: {{$customer->mobileNumber}} Tel: {{$customer->telephoneNumber}}</td>
    </tr>
    <?php $i++; ?>
@endforeach
</body>
</html>