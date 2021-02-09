<template id="sales-grid">
    <style>
        .amount_display {
            box-shadow: 0 1px 2px #E5E5E5;
            padding: 1px;
            margin-bottom: 3px;
            text-align: center;
            padding: 5px;
        }

        .amount_display h3 {
            margin: 0px;
            padding: 0px;
        }

        .display {
            margin-bottom: 8px;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                    <locations></locations>
                </div>
            </div>
        </div>
    </div>


    <table class="table table-paper table-bordered ">
        <thead>
        <tr>
            <th>#</th>
            <th>Product Location</th>
            <th>Quantity</th>
            <th>Unit Cost</th>
            <th>Selling Price</th>
            <th>BarCode</th>
            <th class="text-center">Delete</th>
        </tr>
        </thead>
        <tbody>


        <tr class="" v-for="item in items">
            <th scope="row">#</th>
            <td class="no-padding">

                <input v-model="item.productLocationName"
                       class="grid-input" disabled>
            </td>
            <td class="no-padding">

                <input v-model="item.binLocationName"
                       class="grid-input" disabled>
            </td>
            <td class="no-padding">
                <input v-model="item.amount" class="grid-input">
            </td>
            <td class="no-padding">
                <input v-model="item.unitCost" class="grid-input">
            </td>

            <td class="no-padding">
                <input v-model="item.sellingPrice" class="grid-input">
            </td>

            <td class="no-padding">
                <input v-model="item.productBarcode" class="grid-input">
            </td>
            <td class="no-padding text-center">
                <div v-on:click="deleteItem(item)" class="btn btn-primary btn-flat bg-red"><i class="fa fa-remove"></i>
                </div>
            </td>

        </tr>


        </tbody>
    </table>


    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(env('APP_DEBUG'))

    @endif
    <input type="hidden" name="locations" value="@{{items | json}}">
</template>
<script>
    @push('scripts')
    function formatRepo(repo) {

        return '<b>' + repo.whsName + '</b>' + '<br/><b>Bin Location :</b> <i>' + repo.binCode;
    }

    function formatRepoSelection(repo) {
        return repo.binCode || repo.text;
    }


    Vue.directive('product', {
        twoWay: true,
        bind: function () {
            $(this.el).select2({
                width: '100%',
                placeholder: "Select an option",
                data:{!! $locs !!},
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                templateResult: formatRepo, // omitted for brevity, see the source of this page
                templateSelection: formatRepoSelection, // omitted for brevity, see the source of this page
            })
                .on("select2:select", function (e) {
                    this.set($(this.el).val());
                    // $(this.el).select2("val", "");
                }.bind(this)).on("change", function (e) {
                this.set($(this.el).val());
                //  $(this.el).select2("val", "");
            }.bind(this));
        },
        update: function (nv, ov) {
            $(this.el).trigger("change");
        }
    });


    Vue.component('grid', {
        template: '#sales-grid',
        http: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        data: function () {
            return {
                msg: 'hello',
                productId: 0,
                curr: '',
                items: []
            }
        },
        ready: function () {
                    @if(old('locations'))
            var oldData = {!!  json_encode(old('locations')) !!};
            if (oldData.length > 0) {
                this.items = oldData;
            }
                    @elseif(isset($product))
            var oldData = {!!  $gridData !!};
            if (oldData.length > 0) {
                console.log(oldData);
                this.items = oldData;
            }
            @else
            //this.newEmptyRow();
            @endif
        },
        methods: {
            deleteItem: function (item) {
                $.notify(
                    "Deleting Requested Location",
                    {
                        className: 'info',
                        autoHideDelay: 5000,
                    }
                );
                if (item.id == undefined) {
                    this.items.$remove(item);
                    $.notify(
                        "Location Successfully Deleted",
                        {
                            className: 'success',
                        }
                    );
                    return 0;

                }
                // GET request
                this.$http.delete('{{url('api/v1/product/location/')}}/' + item.id).then(function (returndata, status, request) {
                    $.notify(
                        "Location Successfully Deleted",
                        {
                            className: 'success',
                        }
                    );
                    this.items.$remove(item);

                }, function (data, status, request) {
                    // handle error
                });

            },
            addItem: function (item) {
                if (item.id == undefined) {
                    return 0;
                }
                console.log(item);
                index = this.items.findIndex(x => x.productId == item.id && x.binLocation == item.locid);
                console.log(index);
                if (index < 0) {
                    obj = {
                        binLocation: item.binLocation,
                        productLocationName: item.productLocationName,
                        productLocation: item.productLocation,
                        binLocationName: item.binLocationName,
                        amount: 1,
                        unitCost: 0, //TODO fix to unitCost,
                        sellingPrice: 1,
                        productBarcode: ''

                    }
                    this.items.push(obj);
                } else {
                    console.log(this.items[index].quantity = parseInt(this.items[index].quantity) + 1);
                }
                //console.log(this.items[index].quantity = this.items[index].quantity + 1234556);
                /*
                 console.log(this.items[0]);
                 this.items = this.items.filter(function (el) {
                 return el.productId == 12;
                 });
                 console.log(x.er = "ddsf");
                 */

                // this.items.$set(index, {quantity: 2345});
                //this.items[index] = this.items[index]['quantity'] + 5;
                //console.log(this.items[index]['quantity']);
            },
            emptyGrid: function (e) {
                console.log("here");
            }
        },
        watch: {
            productId: function (i) {
                if (i === undefined || i === 'null' || i === null) {
                    return 0;
                }
                $.notify(
                    "Fetching Location Details",
                    {
                        className: 'info',
                        autoHideDelay: 5000,
                    }
                );
                // GET request
                this.$http({
                    url: '{{url('/product/api/location/')}}' + '/' + i,
                    method: 'GET'
                }).then(function (response) {
                    this.addItem(response.data);
                    $.notify(
                        "Location Added",
                        {
                            className: 'success',
                            autoHideDelay: 5000,
                        }
                    );
                }, function (response) {
                    // error callback
                });

            }
        },
        computed: {
            total: function () {
                var sum = 0;
                for (var i = 0; i < this.items.length; i++) {
                    sum = sum + this.items[i]['unitCost'] * this.items[i]['quantity'];
                }
                return sum;
            },
            products_count: function (e) {
                return this.items.length;
            }
        }
    });

    @endpush
</script>