<style>
    table, th, td {
        border: 1px solid black;
    }
</style>
<table class="table  table-condensed table-bordered">
    <thead>
    <tr>
        <th>Sale Order</th>
        <td>Product</td>
        <td>Quantity</td>
        <td>Deliver To</td>
        <td>Customer Signature</td>

    </tr>
    </thead>
    <tbody>

    <tr>
        <td colspan="5" class="text-center"><b>{{\App\ShippingZone::find($zone)->shippingZone}}</b></td>
    </tr>
    @foreach($deliveryGroup as $deliveryRun)
        @foreach($deliveryRun->items as $delivery)
            @foreach($delivery->salesOrder->items->sortBy('subZone') as $item)
                <tr>
                    @if ($loop->first)
                        <td rowspan="{{count($delivery->salesOrder->items)}}">{{$delivery->salesOrder->orderNo}}
                            <br/>
                            @if($delivery->delivered == 1)
                                <a href="{{action('InvoiceController@create', array('order'=>$delivery->salesOrder->id))}}"
                                   class="btn btn-flat bg-green"><i
                                            class="fa fa-file"></i> @lang('viewsalesorder.Invoice')
                                </a>
                            @endif<br/>
                            ({{$delivery->salesOrder->customer->subzone->shippingZone}})
                        </td>


                    @endif
                    <td style="wrap-text: true; width: 30px;">{{$item->productDescription}}</td>
                    @if ($loop->first)
                        <td>{{$item->quantity}} (Wastage: {{$item->returned}})</td>
                    @else
                        <td></td>
                        <td style="width: 15px;">{{$item->quantity}} (Wastage: {{$item->returned}})</td>
                    @endif
                    @if ($loop->first)
                        <td rowspan="{{count($delivery->salesOrder->items)}}" style="wrap-text: true; width: 50px;">
                            <b>Name :</b> {{$delivery->salesOrder->customer->companyName}}
                            - {{$delivery->salesOrder->contact->customerName}}<br/>
                            <b>Telephone :</b> {{$delivery->salesOrder->contact->telephoneNumber}}<br/>
                            <b>Mobile :</b> {{$delivery->salesOrder->contact->mobileNumber}}<br/>
                            <b>Address :</b> {{$delivery->salesOrder->contact->address1}}<br/>
                            <b>Street :</b> {{$delivery->salesOrder->contact->street}}<br/>
                            <b>SubZone :</b> {{$delivery->salesOrder->customer->subzone->shippingZone}}<br/>

                        </td>
                        @if ($loop->first)
                            <td style="width: 20px;" rowspan="{{count($delivery->salesOrder->items)}}">
                            </td>
                        @endif
                    @endif
                </tr>
            @endforeach
        @endforeach
    @endforeach


    </tbody>
</table>

<tr>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td colspan="2"><b>SUMMMARY</b></td>
</tr>
<table>
    <thead>
    <tr>
        <td>SubZone</td>
        <td>Item Name</td>
        <td>Qty</td>
    </tr>
    </thead>
    <tbody>

    @foreach( $zones->groupBy('shippingZone') as $key => $zones)
        <tr>
            <td colspan="3">{{$key}}</td>
        </tr>
        @foreach($zones as $zone)
            <tr>
                <td></td>
                <td>{{$zone->productDescription}}</td>
                <td>{{$zone->count}}</td>
            </tr>
        @endforeach
    @endforeach

    </tbody>
</table>

