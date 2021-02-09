<template>

    <div>


        <div class="row display">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group{!! $errors->has('barcode') ? ' has-error' : '' !!}">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                            <input v-model="barcode" v-on:keyup.13="barcodeScan" autofocus="true"
                                   class="form-control"/>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row display">
            <div class="col-md-6">
                <div class="form-group{!! $errors->has('currency') ? ' has-error' : '' !!}">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        <select2 :options="countries" v-model="def_curr" >
                        </select2>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{!! $errors->has('products') ? ' has-error' : '' !!}">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                        <prod :options="prods" v-model="productId" :disabled="def_curr == '' ? true : false"></prod>
                    </div>

                </div>
            </div>
        </div>

        <div v-if="filteredItems.length > 0" class="alert alert-error">
            <span v-for="err in filteredItems">
                    {{err.error}}<br/>
            </span>
        </div>
        <table class="table table-paper table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th><i class="fa fa-shopping-cart"></i> Product Description</th>
                <th><i class="fa fa-asterisk"></i> Quantity</th>
                <th><i class="fa fa-calculator"></i> Price</th>
                <th><i class="fa fa-plus"></i> Taxable</th>
                <th><i class="fa fa-minus"></i> Discount</th>
                <th><i class="fa fa-calculator"></i> Tax</th>
                <th><i class="fa fa-calculator"></i> Total</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <item :validate="validate" v-on:delete="destroyItem" :item="item" :key="item.productId" :base_url="base_url"
                  :currency="curr"
                  v-for="item in items"></item>
            </tbody>
            <tr>
                <th></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="sub-table-title"><b>Subtotal</b></td>
                <td class="sub-table-amount" colspan="2">{{price | format_currency}}


                </td>
            </tr>
            <tr>
                <th></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="sub-table-title"><b>Tax</b></td>
                <td class="sub-table-amount" colspan="2">{{tax | format_currency}}


                </td>
            </tr>
            <tr class="success">
                <th></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="sub-table-title"><b>Total</b></td>
                <td class="sub-table-amount" colspan="2">
                    {{payment | format_currency}}


                </td>
            </tr>

        </table>
        <input type="hidden" name="sales" :value="sales">
        <input type="hidden" name="currency" :value="curr">
    </div>
</template>

<script>

    export default {
        props: ['id','edit', 'delete_url', 'validate', 'product_url', 'barcode_url', 'prods', 'countries', 'currency', 'def_curr', 'old_data', 'pricing', 'base_url'],
        mounted: function () {
            this.items = this.old_data;
        },
        data: function () {
            return {
                msg: 'hello',
                productId: 0,
                curr: '',
                items: [],
                discount: 0,
                barcode: '',
            }
        },
        methods: {
            destroyItem: function (item) {
                $.notify(
                    "Deleting Invoice Item",
                    {
                        className: 'info',
                        autoHideDelay: 5000,
                    }
                );
                if (item.id == null) {
                    this.items.splice(this.items.indexOf(item), 1);

                } else {
                    var x = this;
                    this.$http({
                        url: this.base_url + '/' + item.id,
                        method: 'DELETE'
                    }).then(function (response) {
                        //Refresh Items
                        //Vue.set(this.items,response.data);
                        this.items.splice(this.items.indexOf(item), 1);
                        //this.items = response.data;
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
            barcodeScan: function () {
                $.notify(
                    "Barcode Scanned",
                    {
                        className: 'info',
                        autoHideDelay: 5000,
                    }
                );

                // GET request
                this.$http({
                    url: this.barcode_url + '/' + this.barcode + '/' + this.curr,
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
                var index = this.items.findIndex(x => x.productId == item.id && x.binLocation == item.locid);
                var sp = '';
                if (this.pricing == 'useUnitCost') {
                    sp = item.unitCost;
                } else {
                    sp = item.sellingPrice;
                }
                console.log(item.sellingPrice);
                if (index < 0) {
                    var obj = {
                        binLocation: item.binLocation,
                        productId: item.id,
                        productDescription: item.productName,
                        quantity: 1,
                        sellingPrice: sp,
                        discount: 0,
                        taxRate: item.taxRate,
                        prod_id: item.prod_id,
                        taxable: 1,
                        tax: 0,
                        returned: item.returned,
                        convertedPrice: item.convertedPrice,
                        convertedRate: item.conversionRate,
                        total: 0,
                        locationHash: item.hash
                    }
                    this.items.push(obj);
                } else {
                    this.items[index].quantity = parseInt(this.items[index].quantity) + 1;
                }
                if (this.edit == true) {
                    obj.salesOrderId = this.id;
                    obj.invoiceId = this.id;
                    this.$http({
                        url: this.base_url,
                        method: 'POST',
                        body: obj
                    }).then(function (response) {

                    }, function (response) {
                        // error callback
                    });
                }

            },
            emptyGrid: function (e) {

            }
        },
        watch: {
            productId: function (i) {
                this.$http({
                    url: this.base_url + '/' + i,
                    method: 'GET',
                    params: {
                        curr: this.curr
                    }
                }).then(function (response) {
                    this.addItem(response.data);
                }, function (response) {
                    // error callback
                });
            }
        },
        events: {},
        computed: {
            filteredItems: function () {
                var x = this.items.filter(function (el) {

                    return el.has_error == true;


                });
                return x;
            },
            sales: function () {
                return JSON.stringify(this.items);
            },
            payment: function () {
                return this.items.reduce(function (total, value) {
                    return total + Number(value.total);
                }, 0);
            },
            tax: function () {
                return this.items.reduce(function (tax, value) {
                    return tax + Number(value.tax);
                }, 0);
            },
            price: function () {
                return this.items.reduce(function (sellingPrice, value) {
                    return sellingPrice + Number(value.sellingPrice);
                }, 0);
            },
            products_count: function (e) {
                return this.items.length;
            }
        }
    }
</script>

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

    .grid-input {
        width: 100%;
        height: 100%;
        border: none;
        outline: none;

    }

    .sub-table-amount {
        background: #FFF;
        color: #666;
        box-shadow: 0 1px 0 #D0D7E9;
        border: 0.1px solid #f4f4f4 !important;
        border-radius: 0 !important;
        display: table-cell !important;
        vertical-align: middle !important;
        font-family: 'Source Sans Pro', sans-serif !important;
        padding: 10px !important;
        text-align: right;
    }

    .sub-table-title {
        background: #FFF;
        color: #666;
        box-shadow: 0 1px 0 #D0D7E9;
        border: 0.1px solid #f4f4f4 !important;
        border-radius: 0 !important;
        display: table-cell !important;
        vertical-align: middle !important;
        font-family: 'Source Sans Pro', sans-serif !important;
        padding: 10px !important;
    }

    .no-padding {
        padding: 0px !important;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .10000s
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */
    {
        opacity: 0
    }
</style>


