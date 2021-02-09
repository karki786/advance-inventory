<template>
    <div class="custom-actions">
        <a v-bind:href="rowData.view" v-if="show" class="btn btn-flat bg-green btn-sm"><i
                class="glyphicon glyphicon-zoom-in"></i></a>
        <a v-bind:href="rowData.edit" class="btn btn-flat bg-yellow btn-sm"><i
                class="glyphicon glyphicon-pencil"></i></a>
        <button class="btn btn-flat bg-red btn-sm" @click="itemAction('delete-item', rowData, rowIndex)"><i
                class="glyphicon glyphicon-trash"></i></button>
    </div>
</template>

<script>
    export default {
        props: {
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number
            },
            show: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            itemAction (action, data, index) {
                console.log(data.id);
                this.$events.fire('delete-show', data.delete)
            }
        }
    }
</script>

<style>
    .custom-actions button.ui.button {
        padding: 8px 8px;
    }

    .custom-actions button.ui.button > i.icon {
        margin: auto !important;
    }
</style>