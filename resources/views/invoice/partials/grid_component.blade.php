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
    <div class="">
        <div class="row display">
            <div class="col-md-4">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>@{{ total | currency curr  }}</h3>

                        <p>Payment</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>@{{ total | currency curr  }}</h3>

                        <p>Discount</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>@{{ products_count }}</h3>

                        <p>Items</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group{!! $errors->has('products') ? ' has-error' : '' !!}">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                    {!! Form::select('products',array(), null, ['v-product'=>'productId','class' => 'form-control products']) !!}
                </div>
                {!! $errors->first('products', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{!! $errors->has('currency') ? ' has-error' : '' !!}">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    {!! Form::select('currency',$countries, null, ['v-selecttwo'=>'curr','class' => 'form-control']) !!}
                </div>
                {!! $errors->first('currency', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <validator name="validation1">
        <table class="table table-paper table-bordered ">
            <thead>
            <tr>
                <th>#</th>
                <th>Product Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Taxable</th>
                <th>Discount</th>
                <th>Total</th>

            </tr>
            </thead>
            <tbody>


            <tr class="" v-for="item in items">
                <th scope="row">@{{ item.productId }}</th>
                <td class="no-padding">

                    <input v-model="item.productDescription" v-validate:message="{ required: true, minlength: 8 }"
                           class="grid-input">
                </td>
                <td class="no-padding">
                    <input v-model="item.quantity" class="grid-input">
                </td>
                <td class="no-padding">
                    <input v-model="item.sellingPrice" class="grid-input">
                </td>
                <td class="no-padding">
                    <input v-model="item.taxable" class="grid-input">
                </td>
                <td class="no-padding">
                    <input v-on:keydown.9="emptyGrid" v-model="item.discount" class="grid-input">
                </td>
                <td>@{{item.quantity * item.sellingPrice | currency curr }}  </td>

            </tr>


            </tbody>
        </table>
    </validator>


    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <input type="hidden" name="sales" value="@{{items | json}}">
</template>
<script>
    @push('scripts')
    function formatRepo(repo) {

        return '<b>' + repo.productName + '</b>' + '<br/><b>Warehouse :</b> <i>' + repo.productLocationName + '</i> <b>Bin Location :</b> <i>' + repo.binLocationName + '</i>';
    }

    function formatRepoSelection(repo) {
        return repo.productName || repo.text;
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


    Vue.component('grid', {
        template: '#sales-grid',
        ready: function () {
                    @if(old('sales'))
            var oldData = {!!  json_encode(old('sales')) !!};
            if (oldData.length > 0) {
                this.items = oldData;
            }
                    @elseif(isset($salesOrder) or isset($invoice))
            var oldData = {!!  json_encode($sales) !!};
            if (oldData.length > 0) {
                console.log(oldData);
                this.items = oldData;
            }
            @else
            //this.newEmptyRow();
            @endif
        },
        data: function () {
            return {
                msg: 'hello',
                productId: 0,
                curr: '',
                items: []
            }
        },
        methods: {
            addItem: function (item) {
                if (item.id == undefined) {
                    return 0;
                }
                console.log(item);
                index = this.items.findIndex(x=>x.productId == item.id && x.binLocation == item.locid);
                console.log(index);
                if (index < 0) {
                    obj = {
                        binLocation: item.locid,
                        productId: item.id,
                        productDescription: item.productName,
                        quantity: 1,
                        sellingPrice: item.sellingPrice, //TODO fix to unitCost
                        discount: 0,
                        taxRate: item.taxRate,
                        taxable: 1,
                        convertedPrice: item.convertedPrice,
                        convertedRate: item.conversionRate

                    }
                    this.items.push(obj);
                } else {
                    console.log(this.items[index].quantity = parseInt(this.items[index].quantity) + 1);
                }

            },
            emptyGrid: function (e) {
                console.log("here");
            }
        },
        watch: {
            productId: function (i) {
                var query = String(i).split("-");
                // GET request
                this.$http({
                    url: '{{url('/invoice/api/getproduct/')}}/' + query[0] + '/' + query[1] + '/' + this.curr,
                    method: 'GET'
                }).then(function (response) {
                    this.addItem(response.data);
                }, function (response) {
                    // error callback
                });

            }
        },
        computed: {
            total: function () {
                var sum = 0;
                for (var i = 0; i < this.items.length; i++) {
                    sum = sum + this.items[i]['sellingPrice'] * this.items[i]['quantity'];
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