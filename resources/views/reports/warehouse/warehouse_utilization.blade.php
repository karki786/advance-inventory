<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>Warehouse Name</th>
    <th>Locations</th>
    <th>Products</th>
</tr>
</thead>
@foreach($warehouses as $warehouse)
    <tr>
        <td><b>{{$warehouse->whsName}}</b></td>
        <td></td>

    </tr>
    @foreach($warehouse->binLocations as $location)
        <tr>
            <td></td>
            <td>{{$location->binCode}}</td>



        </tr>
        @foreach($location->products as $product)
            <tr>
                <td></td>
                <td></td>
                <td>{{$product->binLocationName}}</td>

            </tr>
        @endforeach
    @endforeach


@endforeach
</body>
</html>