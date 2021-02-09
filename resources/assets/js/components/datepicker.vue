<template>

    <input type="text" :name="name" class="form-control">

</template>

<script>
    export default {
        props: ['name', 'limit', 'value'],
        data: function () {
            return {}
        },
        mounted: function () {
            var vm = this;
            $(this.$el).datepicker({
                clearBtn: true,
                startDate: this.limit,
                format: "yyyy/mm/dd"
            }).on('changeDate', function (e) {
                vm.$emit('input', e.format());
            });
            $(this.$el).val(this.value);
        },
        watch: {
            limit: function (val, oldVal) {
                //   var dte = moment(val, 'yyyy/mm/dd').add(1, 'days');
                $(this.$el).datepicker('setStartDate', val);
            }
        },
        destroyed: function () {
        },
        methods: {}
    };
</script>
