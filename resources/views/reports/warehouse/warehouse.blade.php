<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->


<thead>
<tr>
    <th>Warehouse Name</th>
    <th>Warehouse Location</th>
    <th>Warehouse Building</th>
    <th>Locations</th>
    <th>Bin Locations Count</th>

</tr>
</thead>
@foreach($warehouses as $warehouse)
    <tr>
        <td><b>{{$warehouse->whsName}}</b></td>
        <td>{{$warehouse->whsStreet}},{{$warehouse->whsZipCode}}</td>
        <td>{{$warehouse->whsBuilding}}</td>
        <td></td>
        <td><b>{{count($warehouse->binLocations)}}</b></td>
    </tr>
    @foreach($warehouse->binLocations as $location)
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$location->binCode}}</td>
            <td>1</td>


        </tr>
    @endforeach

@endforeach
</body>
</html>