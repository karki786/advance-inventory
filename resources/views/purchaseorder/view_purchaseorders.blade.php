@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('purchaseorder.Purchase Orders')
@endsection

@section('heading')
    @lang('purchaseorder.Your Purchase Orders')
@endsection

@section('content')

    <div id="app">
    <vtable url="order/items/filter" :columns="columns" :filters="filters"></vtable>
    </div>

    <hr/>
@endsection

@section('jquery')
    <script>
        new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        name: 'supplierName',
                        title: 'Supplier Name',
                        visible:true
                    }, {
                        name: 'delivery',
                        title: 'Deliver By',
                        visible:true
                    }, {
                        name: 'lpoNumber',
                        title: 'LPO No',
                        visible:true
                    }, {
                        name: 'totalCash',
                        title: 'Payment',
                        visible:true
                    },{
                        name: 'lpoStatus',
                        title: 'Status',
                        visible:true
                    },{
                        name: 'deliveryStatus',
                        title: 'Delivery Status',
                        visible:true
                    },{
                        name: 'lpoDate',
                        title: 'LPO Date',
                        visible:true
                    },{
                        name: 'delivered',
                        title: 'Items Delivered',
                        visible:true
                    },{
                        name: 'restockButton',
                        title: 'Restock',
                        visible:true
                    },
                    {
                        name: '__component:custom-actions',
                        title: 'Actions',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    }
                ],
                filters: [
                    {
                        scope: 'delivered',
                        text: 'Full Delivery',
                        icon: 'fa fa-check',
                        color: 'bg-green'
                    },
                    {
                        scope: 'lateDelivery',
                        text: 'Overdue Delivery',
                        icon: 'fa fa-clock-o',
                        color: 'bg-purple'
                    },
                    {
                        scope: 'undelivered',
                        text: 'Undelivered Items',
                        icon: 'fa fa-minus-circle',
                        color: 'bg-red'
                    },{
                        scope: 'WaitingApproval',
                        text: 'Awaiting Approval',
                        icon: 'fa fa-clock-o',
                        color: 'bg-blue'
                    },{
                        scope: 'partDelivery',
                        text: 'Part Delivery',
                        icon: 'fa fa-shopping-cart',
                        color: 'bg-maroon'
                    }
                ]

            },
            methods: {}
        })

    </script>
@endsection

