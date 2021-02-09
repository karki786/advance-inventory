<template>

    <select :id="id" class="form-control" :value="value">
        <option value="">Please Choose an Option</option>
        <slot></slot>
    </select>

</template>

<script>
    function formatRepo(repo) {
        if (repo.id == null || repo.id == undefined || repo.id == "" || repo.id == 'undefined' || repo.id == 'null') {
            return '<i class="fa fa-user"></i> <b>Please Select a Product</b>';
        }
        if (repo.whsName == null || repo.whsName == undefined || repo.whsName == "" || repo.whsName == 'undefined' || repo.whsName == 'null') {
            return '<i class="fa fa-shopping-cart"></i> <b>' + repo.binCode + '</b>' + '<br/><b>Warehouse :</b> <i>' + repo.lc + '<br/></i> <b>Price :</b> <i>' + repo.sp;
        }
        return '<i class="fa fa-shopping-cart"></i> <b>' + repo.binCode + '</b>' + '<br/><b>Warehouse :</b> <i>' + repo.whsName + '<br/></i> <b>Bin Location :</b> <i>' + repo.binCode + '</i>';
    }

    function formatRepoSelection(repo) {
        return repo.binCode || repo.text;
    }

    export default {
        props: ['value', 'options', 'id'],
        data: function () {
            return {}
        },
        mounted: function () {

            var vm = this;
            $(this.$el)
                .val(this.value)
                // init select2
                .select2({
                    data: this.options,
                    escapeMarkup: function (markup) {
                        return markup;
                    }, // let our custom formatter work
                    templateResult: formatRepo, // omitted for brevity, see the source of this page
                    templateSelection: formatRepoSelection, // omitted for brevity, see the source of this page

                })
                // emit event on change.
                .on('change', function () {
                    vm.$emit('input', this.value);

                });
            $(this.$el).val(this.value).trigger("change");

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
