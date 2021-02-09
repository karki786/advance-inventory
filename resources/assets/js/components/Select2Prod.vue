<template>

    <select :id="id" class="form-control" >
        <option value="">Please Choose an Option</option>
        <slot></slot>
    </select>

</template>

<script>
    function formatRepo(repo) {
        if (repo.id == null || repo.id == undefined || repo.id == "" || repo.id == 'undefined' || repo.id == 'null') {
            return '<i class="fa fa-user"></i> <b>Please Select a Product</b>';
        }
        if (repo.productLocationName == null || repo.productLocationName == undefined || repo.productLocationName == "" || repo.productLocationName == 'undefined' || repo.productLocationName == 'null') {
            return '<i class="fa fa-shopping-cart"></i> <b>' + repo.productName + '</b>' + '<br/><b>Warehouse :</b> <i>' + repo.lc + '<br/></i> <b>Price :</b> <i><b>' + repo.sp.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '<br/></i> <b>Amount :</b> <i>' + repo.amount;
        }
        return '<i class="fa fa-shopping-cart"></i> <b>' + repo.productName + '</b>' + '<br/><b>Warehouse :</b> <i>' + repo.productLocationName + '<br/></i> <b>Bin Location :</b> <i>' + repo.binLocationName + '</i>' + '<br/></i> <b>Price :</b> <i><b>' + repo.sellingPrice.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+ '</b><br/></i> <b>Amount :</b> <i>' + repo.locsum;
    }

    function formatRepoSelection(repo) {
        return repo.productName || repo.text;
    }

    export default {
        props: ['value', 'options', 'id'],
        data: function () {
            return {}
        },
        mounted: function () {

            var vm = this;
            $(this.$el)
                // init select2
                .select2({
                    data: this.options,
                    escapeMarkup: function (markup) {
                        return markup;
                    }, // let our custom formatter work
                    templateResult: formatRepo, // omitted for brevity, see the source of this page
                    templateSelection: formatRepoSelection, // omitted for brevity, see the source of this page

                }).val(this.value).trigger("change")
                // emit event on change.
                .on('change', function () {
                    vm.$emit('input', this.value);
                });

          //  $(this.$el).val(this.value).trigger("change");

        },
        watch: {
            value: function (value) {
                // update value
                $(this.$el).val(value)
            },
            options: function (options) {
                // update options
              //  $(this.$el).select2({data: options})
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        },
        methods: {
            days: function (value) {
                this.$emit('input', value)
            }
        }
    };
</script>
