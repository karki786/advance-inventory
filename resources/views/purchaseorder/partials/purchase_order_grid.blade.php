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
            <div class="form-group{!! $errors->has('products') ? ' has-error' : '' !!}">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                    {!! Form::select('products',array(), null, ['v-product'=>'productId','class' => 'form-control products']) !!}
                </div>
                {!! $errors->first('products', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>


    <table class="table table-paper table-bordered ">
        <thead>
        <tr>
            <th>#</th>
            <th>@lang('createorder.Product Name')</th>
            <th>@lang('createorder.Unit Cost')</th>
            <th>@lang('createorder.Amount')</th>
            <th>@lang('createorder.Taxable')</th>
            <th>@lang('createorder.Total')</th>
            <th>@lang('createorder.Remove')</th>
        </tr>
        </thead>
        <tbody>


        <tr class="" v-for="item in items">
            <th scope="row">#</th>
            <td class="no-padding">

                <input v-model="item.productDescription"
                       class="grid-input">
            </td>
            <td class="no-padding text-center">

                <input v-model="item.unitCost" class="grid-input"/>
            </td>
            <td class="no-padding text-center">
                <input v-model="item.amount" class="grid-input"/>
            </td>
            <td class="no-padding text-center">
                <input v-model="item.taxable | bool" class="grid-input"/>
            </td>
            <td class="no-padding">
                <input value="@{{ (item.taxRate/100)*(item.amount * item.unitCost)+(item.amount * item.unitCost) | currency curr }}"
                       class="grid-input">
            </td>
            <td class="no-padding text-center">
                <div v-on:click="deleteItem(item)" class="btn btn-primary btn-flat bg-red"><i class="fa fa-remove"></i>
                </div>
            </td>

        </tr>


        </tbody>
    </table>
    <div class="row">
        <div class="col-md-12">
            <span class='ttcost pull-right '> {!! Helper::translateAndShorten('Total Cost','createorder',50)!!} :  <span
                        class="totalCost">@{{ total |currency curr }}</span></span>
        </div>
    </div>

    <input type="hidden" name="orders" value="@{{items|json}}" id="orderDetails"/>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


</template>
<script>
    @push('scripts')
    function formatRepo(repo) {
        if (repo.multilocation == 1) {
            return '<b>' + repo.productDescription + '</b>' + '<br/><b>Warehouse :</b> <i>' + repo.productLocationName + '</i> <b>Bin Location :</b> <i>' + repo.binLocationName + '</i>';

        } else {
            return '<b>' + repo.productDescription + '</b>';

        }
    }

    function formatRepoSelection(repo) {
        return repo.productDescription || repo.text;
    }


    Vue.directive('product', {
        twoWay: true,
        bind: function () {
            $(this.el).select2({
                        width: '100%',
                        placeholder: "Select an option",
                        data:{!! $prods !!},
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

    Vue.filter('bool', function (value) {
        if (value == 1) {
            return "Yes";
        } else {
            return "NO";
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
                items: []
            }
        },
        props: ['curr']
        ,
        ready: function () {
                    @if(old('orders'))
            var oldData = {!!  json_encode(old('orders')) !!};
            if (oldData.length > 0) {
                this.items = oldData;
            }
                    @elseif(isset($purchaseorder))
            var oldData = {!!  $orders !!};
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
                this.$http.delete('{{url('order/api/reorder/delete')}}/' + item.id).then(function (returndata, status, request) {
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
                index = this.items.findIndex(x => x.productId == item.id);
                console.log(index);
                if (index < 0) {
                    obj = {
                        productId: item.id,
                        productDescription: item.productName,
                        taxable: 1,
                        taxRate: item.productTaxRate,
                        amount: 1,
                        unitCost: item.unitCost, //TODO fix to unitCost
                        usesMultipleStorage: item.usesMultipleStorage

                    }
                    this.items.push(obj);
                } else {
                    this.items[index].amount = parseInt(this.items[index].amount) + 1;
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
                if (i == "") {
                    return 0;
                }
                $.notify(
                        "Fetching Location Details",
                        {
                            className: 'info',
                            autoHideDelay: 5000,
                        }
                );
                var query = String(i).split("-");
                // GET request
                this.$http({
                    url: "{{url('order/api/reorder/')}}" + '/' + query[0] + '/' + query[1],
                    method: 'GET'
                }).then(function (response) {
                    console.log(response);
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
                    sum = sum + this.items[i]['unitCost'] * this.items[i]['amount'];
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