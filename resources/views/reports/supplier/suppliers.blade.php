<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>#</th>
    <th> Supplier Name</th>
    <th>Phone</th>
    <th>Website</th>
    <th>Email</th>
    <th>Restocks Count</th>
    <th>Restock Sum</th>
    <th>Supplier Since</th>

</tr>
</thead>
<?php $i = 1; ?>
@foreach($suppliers as $supplier)
    <tr>
        <th scope="row">{{$i}}</th>
        <td>{{ucwords($supplier->supplierName)}} </td>
        <td>{{$supplier->phone}}</td>
        <td>{{$supplier->website}}</td>
        <td>{{$supplier->email}}</td>
        <td>{{$supplier->restockscount}}</td>
        <td>{{number_format($supplier->restockssum,2)}}</td>
        <td>{{Carbon::parse($supplier->created_at)->format('d/m/Y')}} </td>
    </tr>
    <?php $i++; ?>
@endforeach
</body>
</html>