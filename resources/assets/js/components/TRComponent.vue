<template>

    <tr v-bind:class="{ 'danger':item.has_error}">
        <th scope="row">{{item.productId }}</th>
        <td class="no-padding">

            <input v-on:keyup="updateItem(item)" v-model="item.productDescription"
                   class="grid-input">
        </td>
        <td class="no-padding">
            <input v-on:keyup="updateItem(item)" v-model="item.quantity" class="grid-input">
        </td>
        <td class="no-padding">
            <input v-on:keyup="updateItem(item)" v-model="item.sellingPrice" class="grid-input">
        </td>
        <td class="no-padding">
            <select v-on:keyup="updateItem(item)" v-model="item.taxable" class="grid-input">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </td>
        <td class="no-padding">
            <input v-on:keyup="updateItem(item)" v-model="item.discount" class="grid-input">
        </td>
        <td class="no-padding">
            <input v-on:keyup="updateItem(item)" v-model="item.tax" class="grid-input">
        </td>
        <td>{{item.total | format_currency}}</td>
        <td v-on:click="deleteItem(item)"><i class="fa fa-remove"></i></td>

    </tr>


</template>

<script>
    Vue.filter('format_currency', function (value) {
        return value.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    })
    export default {
        props: ['item', 'currency', 'base_url', 'validate'],
        mounted() {
            this.calculateTotal(this.item);
        },
        create(){

        },
        methods: {
            deleteItem: function (item) {
                this.$emit('delete', item);
            },
            updateItem:function(item){
                if (item.id > 0) {
                    this.$http({
                        url: this.base_url + '/' + item.id,
                        method: 'PATCH',
                        body: item
                    }).then(function (response) {

                    }, function (response) {
                        // error callback
                    });
                }
            },
            calculateTotal: function (val) {
                var quantity = val.quantity;
                var price = val.sellingPrice;
                var discount = val.discount || 0;
                var tax = 0;
                var sub_total = (parseFloat(quantity) * parseFloat(price)) - parseFloat(discount);
                if (val.taxable == 1) {
                    tax = parseFloat(val.taxRate) / 100 * parseFloat(sub_total);
                    tax = tax.toFixed(2);
                }
                val.price = sub_total;
                val.tax = tax;
                val.total = (parseFloat(sub_total) + parseFloat(tax));
            }
        },
        watch: {
            item: {
                handler: function (val) {
                    if (this.validate == false || this.validate == "false") {
                        this.calculateTotal(val);
                        return 0;
                    }
                    var x = this;
                    this.$http({
                        url: this.base_url + '/validate/item',
                        method: 'GET',
                        params: val
                    }).then(function (response) {
                        var data = response.data;
                        if (data.enough === false) {
                            var string = val.productDescription + ' : Over Dispatch Only ' + data.amount + ' items can be dispatched';
                            Vue.set(this.item, 'error', string);
                            Vue.set(this.item, 'has_error', true);
                        } else {
                            Vue.set(this.item, 'has_error', false);
                        }
                        this.calculateTotal(val);



                    }, function (response) {
                        // error callback
                    });

                },
                deep: true
            }
        },
        computed: {}
    }
</script>
