<section class="content-header">
    <h1>
        @lang('restock.Restocks')({{$allRestocks->count()}})
    </h1>

</section>
<hr/>
<table class="table table-paper table-condensed table-bordered table-responsive">
    <thead>
    <tr>
        <th>#</th>
        <th> {{ trans('restock.Product Name') }}</th>
        <th>{{ trans('restock.Unit Cost') }}
            ( {{ trans('restock.Item Cost') }})
        </th>
        <th> {{ trans('restock.Amount') }}</th>
        <th>@lang('restock.Warehouse')</th>
        <th>@lang('restock.Bin Location')</th>
        <th> {{ trans('restock.Supplied By') }}</th>
        <th>{{ trans('restock.Received on') }}</th>
        <th>@lang('restock.Docs')</th>
        <th>@lang('restock.Actions')</th>

    </tr>
    </thead>
    <tbody>

    <?php $i = 1; ?>
    @foreach ($allRestocks as $restock)
        <tr class="">
            <th scope="row">{{$i}}</th>

            <td>{{ucwords($restock->present()->productName)}} </td>


            <td>{{$restock->present()->unitCost}} ({{$restock->present()->itemCost}})</td>
            <td class="text-center"><b>{{doubleval($restock->amount)}}</b></td>
            <td>{{$restock->present()->warehouse}}</td>
            <td>{{$restock->present()->bin}}</td>
            <td>{{$restock->present()->supplierName}}</td>

            @include('restocks.custom.tablefields')
            <td>{{Carbon::parse($restock->created_at)->format('d/m/Y')}} </td>
            <td class="text-center">{!!$restock->present()->hasDownload!!}</td>
            <td class="text-center">
                @if(isset($restore))
                    <a href="{{action('RestockController@restore', $restock->id)}}" class="btn btn-flat bg-purple"><i
                                class="fa fa-undo"></i></a>
                @else
                    <div aria-label="Actions" role="group" class="btn-group">
                        <a class="btn btn-flat btn  bg-yellow "
                           href="{{action('RestockController@show', $restock->id)}}"><i
                                    class="fa fa-eye"></i></a>
                        <div aria-label="Actions" role="group" class="btn-group">
                            <div class="open-popup-link btn btn-flat bg-red delete-button"
                                 data-url="{{action('RestockController@destroy', $restock->id)}}"><i
                                        class="fa fa-remove"></i></div>
                            <a class="btn btn-flat bg-blue" href="{{action('RestockController@edit', $restock->id)}}">
                                <i
                                        class="   fa fa-edit"></i></a>
                        </div>
                    </div>
                @endif

            </td>
            <?php $i++; ?>
        </tr>
    @endforeach

    </tbody>
</table>
