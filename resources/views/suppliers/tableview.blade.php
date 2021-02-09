
<div id="app">

    <vtable url="supplier/items/filter" :columns="columns" :filters="filters"></vtable>

</div>

@section('jquery')
    <script>
        new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        name: 'supplierName',
                        title: 'Supplier Name',
                    }, {
                        name: 'restockCount',
                        title: 'Restocks Count',
                    }, {
                        name: 'email',
                        title: 'Email',
                    }, {
                        name: 'phone',
                        title: 'Phone',
                    }, {
                        name: 'itemCost',
                        title: 'Total Amount ',
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
                        scope: 'trash',
                        text: 'View Deleted Items',
                        icon: 'fa fa-trash',
                        color: 'bg-purple'
                    },
                    {
                        scope: 'low',
                        text: 'View Low Stock',
                        icon: 'fa fa-minus-circle',
                        color: 'bg-red'
                    }
                ]

            },
            methods: {}
        });
    </script>
    @endsection

