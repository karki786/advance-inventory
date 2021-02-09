<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>#</th>
    <th> {{ trans('restockeditems.Product Name') }}</th>
    <th>{{ trans('restockeditems.Unit Cost') }}
        ( {{ trans('restockeditems.Item Cost') }})
    </th>
    <th> {{ trans('restockeditems.Amount') }}</th>
    <th>Warehouse</th>
    <th>Bin Location</th>
    <th> {{ trans('restockeditems.Supplied By') }}</th>
    <th>{{ trans('restockeditems.Received on') }}</th>

</tr>
</thead>
<?php $i = 1; ?>
@foreach($dispatches as $dispatch)
    <tr>
        <th scope="row">{{$i}}</th>
        <td>{{ucwords($restock->present()->productName)}} </td>
        <td>{{$restock->present()->unitCost}} ({{$restock->present()->itemCost}})</td>
        <td class="text-center"><b>{{doubleval($restock->amount)}}</b></td>
        <td>{{$restock->present()->warehouse}}</td>
        <td>{{$restock->present()->bin}}</td>
        <td>{{$restock->present()->supplierName}}</td>
        <td>{{Carbon::parse($restock->created_at)->format('d/m/Y')}} </td>
    </tr>
    <?php $i++; ?>
@endforeach
</body>
</html>