<template>


    <tr class="">
        <th scope="row">{{ item.binLocation }}</th>
        <td class="no-padding" style="padding: 5px !important;">
            {{item.productLocationName}}
        </td>
        <td class="no-padding" style="padding: 5px !important;">
            {{item.binLocationName}}
        </td>
        <td class="no-padding-edit" style="background: rgba(255, 255, 0, 0.1);">
            <input v-on:keyup="editItem" v-model="item.amount" class="grid-input">
        </td>
        <td class="no-padding-edit" style="background: rgba(255, 255, 0, 0.1);">
            <input v-on:keyup="editItem" v-model="item.unitCost" class="grid-input">
        </td>
        <td class="no-padding-edit" style="background: rgba(255, 255, 0, 0.1);">
            <input v-on:keyup="editItem" v-model="item.sellingPrice" class="grid-input">
        </td>
        <td class="no-padding-edit" style="background:rgba(255, 255, 0, 0.1);">
            <input v-on:keyup="editItem" v-model="item.productBarcode" class="grid-input">
        </td>

        <td v-on:click="deleteItem(item)">
            <div class="btn btn-flat bg-red btn-block remove_location"><i class="fa fa-remove"></i></div>
        </td>

    </tr>


</template>

<script>
    Vue.filter('format_currency', function (value) {
        return value.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    })
    export default {
        props: ['item', 'currency', 'item_edit', 'edit'],
        mounted() {

        },
        create(){

        },
        data: function () {
            return {}
        },
        methods: {
            deleteItem: function (item) {
                this.$emit('delete', item);
            },
            editItem: function () {
                if (this.can_edit == false) {
                    return;
                }
                var obj = {
                    binLocation: this.itemData.binLocation,
                    productLocationName: this.itemData.productLocationName,
                    productLocation: this.itemData.productLocation,
                    binLocationName: this.itemData.binLocationName,
                    amount: this.itemData.amount,
                    unitCost: this.itemData.unitCost, //TODO fix to unitCost,
                    sellingPrice: this.itemData.sellingPrice,
                    productBarcode: this.itemData.productBarcode

                }
                $.notify(
                    "Editing Product Location",
                    {
                        className: 'info',
                        autoHideDelay: 5000,
                    }
                );
                this.$http({
                    url: this.item_edit + '/' + this.itemData.hash,
                    method: 'PATCH',
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
            }
        },
        watch: {
            item: function () {
                this.editItem();
            }
        },
        computed: {
            itemData: function () {
                return this.item;
            },
            can_edit: function () {
                return this.edit;
            }
        }
    }
</script>

<style scoped>
    .item-edit {
        display: none;
    }

    .item-editing {
        display: block;
    }

    .grid-input {
        width: 100%;
        height: 100%;
        border: none;
        background: rgba(255, 255, 0, 0.2);
        padding: 5px;

    }

    .no-padding-edit {
        background: rgba(255, 255, 0, 0.2);
    }

    .no-padding {
        padding: 0px;;
    }
</style>
