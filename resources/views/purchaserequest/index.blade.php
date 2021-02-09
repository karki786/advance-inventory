@extends('layouts.master')

@section('title')
    Purchase Requests
@endsection


@section('content')
    <section class="content-header">
        <h1>
            Your Purchase Requests ({{$requests->count()}})
            <small>Your Purchase Requests recent first</small>
        </h1>
    </section>
    <hr/>
    <table class="table table-paper table-bordered">

        <tbody>
        <tr>
            <td class="success">LPO Approved <span class="pull-right badge bg-blue">{{$lpoApproved}}</span><a
                        href="{{action('PurchaseRequestController@index',array('status'=>'lpoApproved'))}}"><i
                            class="fa fa-filter"></i></a></td>
            <td class="info">LPO Created <span class="pull-right badge bg-blue">{{$lpoCreated}}</span> <a
                        href="{{action('PurchaseRequestController@index',array('status'=>'lpoCreated'))}}"><i
                            class="fa fa-filter"></i></a></td>
            <td class="warning">Request Approved <span class="pull-right badge bg-blue">{{$approvedRequests}}</span>
                <a href="{{action('PurchaseRequestController@index',array('status'=>'requestApproved'))}}"><i
                            class="fa fa-filter"></i></a></td>
            <td class="danger">Awaiting Approval <span
                        class="pull-right badge bg-blue">{{$awaitingApproval}}</span>
                <a href="{{action('PurchaseRequestController@index',array('status'=>'waitingApproval'))}}"><i
                            class="fa fa-filter"></i></a></td>
        </tr>

        </tbody>
    </table>
    <hr/>

    <table class="table table-paper table-condensed table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Requested By</th>
            <th>Request No</th>
            <th>
                <i class="fa fa-info-circle pull-right " {!!Helper::popover('Reminder','Hover to see people who will be reminded of in-action at specified date')!!}></i>
                Reminder
            </th>
            <th>Request Date <i class="fa fa-info-circle pull-right " data-container="body" data-toggle="popover"
                                title="Info" data-content="Hover on this column to get additional info"
                                trigger="hover"></i>
            </th>
            <th>Department</th>
            <th>Actions <i class="fa fa-info-circle pull-right " data-container="body" data-toggle="popover"
                           title="Info" data-content="Hover on this column to get additional info" trigger="hover"></i>
            </th>

        </tr>
        </thead>
        <tbody>

        <?php $i = 1; ?>
        @foreach ($requests as $request)
            @if($request->requestApproved == 0)
                <tr class="danger">
            @elseif($request->requestApproved == 1 and $request->lpoCreated == 0)
                <tr class="warning">
            @elseif($request->requestApproved == 1 and $request->lpoCreated == 1 and $request->lpoApproved == 0 )
                <tr class="info">
            @elseif($request->lpoApproved == 1 and $request->lpoCreated == 1 and $request->lpoApproved == 1 )
                <tr class="success">
                    @endif
                    <td>{{$i}}</td>
                    <td>{{$request->requestOwner->name}}</td>
                    <td>{{$request->requestNo}}</td>
                    <td>{{$request->remindMeOn}}</td>
                    <td>{{$request->present()->requestDate}}</td>
                    <td>{{$request->department->name}}</td>
                    <td class="text-center">
                        <div aria-label="Actions" role="group" class="btn-group">
                            @if(isset($restore))
                                <a href="{{action('PurchaseRequestController@restore', array('id'=>$request->id))}}"
                                   class="btn btn-warning"><i
                                            class="fa fa-undo"></i></a>
                            @else
                                <a class="btn btn-flat bg-green" target="_blank"
                                   href="{{ url('purchaserequests/'. $request->requestNo . '-' . str_slug($request->requestOwner->name) . '.pdf')}}"
                                   data-container="body" data-toggle="popover" title="Delivery Terms"
                                   data-content="Print From PDF" trigger="hover"
                                        > <i
                                            class="   fa fa-file-pdf-o"></i></a>
                                <a class="btn btn-flat bg-purple" target="_blank"
                                   href="{{ url('purchaserequests/'. $request->requestNo . '-' . str_slug($request->requestOwner->name) . '.xlsx')}}"
                                   data-container="body" data-toggle="popover" title="Delivery Terms"
                                   data-content="Print From Excel" trigger="hover"
                                        > <i
                                            class="   fa fa-file-excel-o"></i></a>
                                <a class="btn btn-flat bg-blue"
                                   href="{{action('PurchaseRequestController@edit', $request->id)}}"
                                   data-container="body" data-toggle="popover" title="Delivery Terms"
                                   data-content="Edit  LPO" trigger="hover"
                                        > <i
                                            class="   fa fa-edit"></i></a>
                                <div class=" btn btn-flat bg-red delete-button"
                                     data-url="{{action('PurchaseRequestController@destroy', $request->id)}}"><i
                                            class="fa fa-remove"></i></div>
                                <a class=" btn btn-flat bg-yellow"
                                   href="{{action('PurchaseOrderController@create', array('request'=>$request->id))}}"><i
                                            class="fa fa-file"></i></a>
                            @endif

                        </div>
                    </td>

                    <?php $i = $i + 1; ?>
                </tr>
                @endforeach
        </tbody>
    </table>
    <div class="text-center"><?php echo $requests->appends($sort)->render(); ?></div>
@endsection

@section('js')


    $('[data-toggle="popover"]').popover({
    trigger:'hover',
    placement:'top'
    });
@endsection

