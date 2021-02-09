<template>

    <div>

        <div class="row display">
            <div class="col-md-12">
                <div class="form-group{!! $errors->has('products') ? ' has-error' : '' !!}">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                        <locs_list :options="locs" v-model="locationId" id="locsChoice"></locs_list>
                    </div>

                </div>
            </div>
        </div>

        <table class="table table-paper table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th><i class="fa fa-building"></i> Warehouse</th>
                <th><i class="fa fa-chain"></i> Bin Location</th>
                <th><i class="fa fa-asterisk"></i> Quantity</th>
                <th><i class="fa fa-asterisk"></i> Unit Cost</th>
                <th><i class="fa fa-calculator"></i> Selling Price</th>
                <th><i class="fa fa-plus"></i> Barcode</th>

                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <item-location v-on:delete="destroyItem" :item="item" :key="item.binLocation" :item_edit="item_edit"
                           :edit=edit :currency="curr"
                           v-for="item in items"></item-location>
            </tbody>


        </table>
        <input type="hidden" name="locations" :value="locations"/>
    </div>
</template>

<script>

    export default {
        props: ['delete_url', 'locs', 'old_data', 'item_edit', 'edit', 'id'],
        mounted: function () {
            this.items = this.old_data;
        },
        data: function () {
            return {
                msg: 'hello',
                locationId: 0,
                curr: '',
                items: [],
                discount: 0,
                location: ''
            }
        },
        methods: {
            destroyItem: function (item) {
                $.notify(
                    "Deleting Item From Location",
                    {
                        className: 'info',
                        autoHideDelay: 5000,
                    }
                );
                console.log(item);
                if (item.hash == null) {
                    this.items.splice(this.items.indexOf(item), 1);

                } else {
                    this.$http({
                        url: this.delete_url + '/' + item.hash,
                        method: 'DELETE'
                    }).then(function (response) {
                        //Refresh Items

                       // this.items = response.data.sales;
                        this.items.splice(this.items.indexOf(item), 1);
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
            addItem: function (loc) {
                var obj = {
                    binLocation: loc[0].id,
                    productLocationName: loc[0].whsName,
                    productLocation: loc[0].whsId,
                    binLocationName: loc[0].binCode,
                    amount: 1,
                    unitCost: 0, //TODO fix to unitCost,
                    sellingPrice: 1,
                    productBarcode: ''

                }
                this.items.push(obj);
                if (this.can_edit == false) {
                    return;
                }
                obj.productId = this.item_id;
                this.$http({
                    url: this.item_edit,
                    method: 'POST',
                    body: obj
                }).then(function (response) {
                    //Refresh Items
                    $.notify(
                        "Finished Editing",
                        {
                            className: 'success',
                            autoHideDelay: 5000,
                        }
                    );
                }, function (response) {
                    $.notify(
                        "An error Occured when Editing",
                        {
                            className: 'error',
                            autoHideDelay: 5000,
                        }
                    );
                });

            },
            emptyGrid: function (e) {

            }
        },
        watch: {
            locationId: function (i) {
                if (i == null || i == "") {
                    return;
                }
                var loc = this.locs.filter(function (loc) {
                    return loc.id == i
                });
                this.addItem(loc);

            }
        },
        computed: {
            locations: function () {
                return JSON.stringify(this.items);
            },
            can_edit: function () {
                return this.edit;
            },
            item_id: function () {
                return this.id;
            }
        }
    }
</script>




