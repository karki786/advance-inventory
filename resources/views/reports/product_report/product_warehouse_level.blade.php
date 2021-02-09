<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>Product Name</th>
    <th>Warehouse Name</th>
    <th>Bin Location</th>
    <th>Amount</th>
</tr>
</thead>
@foreach($products as $product)
    <tr>
        <td><b>{{$product->productName}}</b></td>
        <td></td>
        <td></td>
        <td><b>{{$product->amount}}</b></td>
    </tr>
    @foreach($product->locations as $location)
        <tr>
            <td></td>
            <td>{{$location->productLocationName}}</td>
            <td>{{$location->binLocationName}}</td>
            <td>{{$location->amount}}</td>

        </tr>
    @endforeach

@endforeach
</body>
</html>