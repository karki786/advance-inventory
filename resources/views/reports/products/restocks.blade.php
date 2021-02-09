<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<table class="table table-paper table-condensed table-bordered table-responsive">
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
        @include('restocks.custom.tableheader')


    </tr>
    </thead>
    <tbody>

    <?php $i = 1; ?>
    @foreach ($allRestocks as $restock)
        <tr class="">
            <th scope="row">{{$i}}</th>
            @if($restock->product)
                <td>{{ucwords($restock->present()->productName)}} </td>
            @else
                <td>-Deleted Product-</td>
            @endif

            <td>{{$restock->present()->unitCost}} ({{$restock->present()->itemCost}})</td>
            <td class="text-center"><b>{{doubleval($restock->amount)}}</b></td>
            <td>{{$restock->present()->warehouse}}</td>
            <td>{{$restock->present()->bin}}</td>
            <td>{{$restock->present()->supplierName}}</td>

            @include('restocks.custom.tablefields')
            <td>{{Carbon::parse($restock->created_at)->format('d/m/Y')}} </td>

            <?php $i++; ?>
        </tr>
    @endforeach

    </tbody>
</table>
</body>
</html>