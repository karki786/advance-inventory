<template>

    <select :id="id" class="form-control">
        <option value="">Please Choose an Option</option>
        <slot></slot>
    </select>

</template>

<script>
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

                })
                // emit event on change.
                .on('change', function () {
                    vm.$emit('input', this.value)
                });
            $(this.$el).val(this.value).trigger("change");


        },
        watch: {
            value: function (value) {
                // update value
                console.log('Manual Trigger');
                console.log(this.value);


            },
            options: function (options) {
                // update options
                $(this.$el).select2({data: options})
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        },
        methods: {
            days: function (value) {
                console.log(value);
                this.$emit('input', value)
            }
        }
    };
</script>
