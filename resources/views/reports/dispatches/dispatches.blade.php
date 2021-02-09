<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>#</th>
    <th> {{ trans('stockitems.Product Name') }}</th>
    <th>{{ trans('viewdispatcheditems.Amount') }}</th>
    <th>{{ trans('viewdispatcheditems.Category Name') }}</th>
    <th>{{ trans('viewdispatcheditems.Dispatched To') }}</th>
    <th> {{ trans('viewdispatcheditems.Item Cost') }}</th>
    <th>Warehouse</th>
    <th>Bin Location</th>
    <th>Staff Request</th>
    <th> {{ trans('viewdispatcheditems.Dispatched On') }}</th>

</tr>
</thead>
<?php $i = 1; ?>
@foreach($dispatches as $dispatch)
    <tr>
        <th scope="row">{{$i}}</th>
        @if($dispatch->product)
            <td>{{ucwords($dispatch->present()->productName)}}</td>
        @else
            <td>-Deleted Product-</td>
        @endif

        <td><b>{{doubleval($dispatch->amount)}}</b></td>
        <td><b>{{$dispatch->categoryName}}</b></td>
        @if($dispatch->staff)
            <td>{{ucwords($dispatch->present()->user)}}
            </td>
        @else
            <td>-Deleted User -</td>
        @endif
        <td>{{$dispatch->present()->totalCost}}</td>
        <td>{{$dispatch->present()->warehouse}}</td>
        <td>{{$dispatch->present()->bin}}</td>
        <td>{!!  $dispatch->present()->request!!}</td>
        <td>{{$dispatch->created_at}} </td>
    </tr>
    <?php $i++; ?>
@endforeach
</body>
</html>