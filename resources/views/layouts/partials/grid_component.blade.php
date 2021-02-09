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

                        <p>@lang('createinvoice.Payment')</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>@{{ discount | currency curr  }}</h3>

                        <p>@lang('createinvoice.Discount')</p>
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

                        <p>@lang('createinvoice.Items')</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group{!! $errors->has('barcode') ? ' has-error' : '' !!}">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    {!! Form::text('barcode', null, ['v-el:bcode', 'v-model'=>'barcode', 'v-on:keyup.13'=>'barcodeScan','autofocus'=>'true','class' => 'form-control barcode','placeholder'=>'Barcode']) !!}
                </div>
                {!! $errors->first('barcode', '<p class="help-block">:message</p>') !!}
            </div>
    </div>
</div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group{!! $errors->has('currency') ? ' has-error' : '' !!}">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    {!! Form::select('currency',$countries, $prevCurr, ['v-selecttwo'=>'curr','class' => 'form-control']) !!}
                </div>
                {!! $errors->first('currency', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{!! $errors->has('products') ? ' has-error' : '' !!}">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                    {!! Form::select('products',array(), null, [":disabled"=>"curr == 0 ? true : false",'v-product'=>'productId','class' => 'form-control products']) !!}
                </div>
                {!! $errors->first('products', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <validator name="validation1">
        <table class="table table-paper table-bordered ">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('createinvoice.Product Description')</th>
                <th>@lang('createinvoice.Quantity')</th>
                <th>@lang('createinvoice.Price')</th>
                <th>@lang('createinvoice.Taxable')</th>
                <th>@lang('createinvoice.Discount')</th>
                <th>@lang('createinvoice.Total') (@{{ curr }})</th>
                <th></th>

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
                    <input v-on:keyup="editItem(item)" v-model="item.quantity" class="grid-input">
                </td>
                <td class="no-padding">
                    <input v-on:keyup="editItem(item)" v-model="item.sellingPrice" class="grid-input">
                </td>
                <td class="no-padding">
                    <select v-model="item.taxable" class="grid-input">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </td>
                <td class="no-padding">
                    <input v-on:keydown.9="emptyGrid" v-model="item.discount" class="grid-input">
                </td>
                <td>@{{item.total}} (Tax : @{{item.tax}} )</td>
                <td v-on:click="deleteItem(item)"><i class="fa fa-remove"></i></td>

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
$(document).ready(function () {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
            Vue.http.headers.common['X-CSRF-TOKEN'] = '{!! csrf_token() !!}';
    function formatRepo(repo) {
        console.log(repo.productLocation);
        if(repo.id == null || repo.id == undefined || repo.id == "" || repo.id == 'undefined' || repo.id == 'null' ){
            return '<i class="fa fa-user"></i> <b>Please Select a Product</b>';
        }
        if(repo.productLocationName == null || repo.productLocationName  == undefined || repo.productLocationName  == "" || repo.productLocationName  == 'undefined' || repo.productLocationName  == 'null' ){
            return  '<i class="fa fa-shopping-cart"></i> <b>' + repo.productName + '</b>' + '<br/><b>Warehouse :</b> <i>' + repo.lc +'<br/></i> <b>Price :</b> <i>' + repo.sp;
        }
        return  '<i class="fa fa-shopping-cart"></i> <b>' + repo.productName + '</b>' + '<br/><b>Warehouse :</b> <i>' + repo.productLocationName + '<br/></i> <b>Bin Location :</b> <i>' + repo.binLocationName + '</i>' +'<br/></i> <b>Price :</b> <i>' + repo.sellingPrice;
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
                        data:{!! json_encode($prods) !!},
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
                    @elseif(isset($salesOrder) or isset($invoice) or isset($subscription) or isset($receipt))
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
                items: [],
                discount: 0,
                barcode:''
            }
        },
        methods: {
            deleteItem: function (item) {
                $.notify(
                        "Deleting Invoice Item",
                        {
                            className: 'info',
                            autoHideDelay: 5000,
                        }
                );
                if (item.id == null) {
                    this.items.$remove(item);
                } else {
                    this.$http({
                        url: '{{$delete_url  or ''}}/' + item.id,
                        method: 'DELETE'
                    }).then(function (response) {
                        //Refresh Items
                        this.items = response.data.sales;
                        $.notify(
                                "Deleted Invoice Item and items refetched",
                                {
                                    className: 'success',
                                    autoHideDelay: 5000,
                                }
                        );
                    }, function (response) {
                        $.notify(
                                "Failed Deleting Invoice Item",
                                {
                                    className: 'danger',
                                    autoHideDelay: 5000,
                                }
                        );
                    });
                }
            },
            barcodeScan:function(){
                console.log(this.barcode);
              // console.log(this.$els.bcode.focus());
                $.notify(
                        "Barcode Scanned",
                        {
                            className: 'info',
                            autoHideDelay: 5000,
                        }
                );

                // GET request
                this.$http({
                    url: '{{url('/invoice/api/getproductscan/')}}/' + this.barcode + '/' + this.curr,
                    method: 'GET'
                }).then(function (response) {
                    this.addItem(response.data);
                    $.notify(
                            "Barcode Item Fetched",
                            {
                                className: 'success',
                                autoHideDelay: 5000,
                            }
                    );
                }, function (response) {
                    // error callback
                });
                this.barcode = '';
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
                        binLocation: item.locid,
                        productId: item.id,
                        productDescription: item.productName,
                        quantity: 1,
                        sellingPrice: item.sellingPrice, //TODO fix to unitCost
                        discount: 0,
                        taxRate: item.taxRate,
                        taxable: 1,
                        tax:0,
                        returned:item.returned,
                        convertedPrice: item.convertedPrice,
                        convertedRate: item.conversionRate,
                        total: 0


                    }
                    this.items.push(obj);
                } else {
                    console.log(this.items[index].quantity = parseInt(this.items[index].quantity) + 1);
                }

            },
            editItem: function (item) {

            },
            emptyGrid: function (e) {
                console.log("here");
            }
        },
        watch: {
            productId: function (i) {
                if(i == 'null'){
                    return;
                }
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

            },
            items: {
                handler: function (val, oldVal) {
                    val.forEach(function (item) {
                        var sub_total = (item.quantity * item.sellingPrice - item.discount);
                        var tax = 0;
                        item.tax = tax;
                        if (item.taxable == 1) {
                            tax = item.taxRate / 100 * sub_total;
                            item.tax = tax.toFixed(2);
                        }

                        item.total = (sub_total + tax).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    });
                },
                deep: true
            }
        },
        computed: {
            total: function () {
                var sum = 0;
                var discount= 0;
                for (var i = 0; i < this.items.length; i++) {
                    sum = sum + this.items[i]['sellingPrice'] * this.items[i]['quantity'];
                    if (this.items[i]['taxable'] == 1) {
                        tax = this.items[i]['taxRate'] / 100 * sum;
                        tax = tax.toFixed(2);
                        sum = parseFloat(sum)+parseFloat(tax);
                    }
                    discount = parseFloat(discount) + parseFloat(this.items[i]['discount']);
                }
                this.discount = discount;
                return sum;
            },
            products_count: function (e) {
                return this.items.length;
            }
        }
    });

    @endpush
</script>