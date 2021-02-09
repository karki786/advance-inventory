<template>
    <vodal :show="show" animation="door" @hide="cancelDelete()">
        <h1 class="text-center">Delete Confirmation</h1>
        <hr/>
        <div v-if="error" class="alert alert-error">
            An Error occurred while deleting
        </div>
        <div style="padding: 20px;">
            Are you sure you want to delete this item?
        </div>
        <br/>
        <div class="row">
            <div class="col-md-6">
                <button type="submit" v-on:click="deleteItem" class="btn btn-flat bg-green btn-block">Yes</button>

            </div>
            <div class="col-md-6">
                <button type="submit" v-on:click="cancelDelete" class="btn btn-flat bg-red btn-block">No</button>
            </div>
        </div>
    </vodal>
</template>

<script>
    export default {
        props: ['show', 'delete_url'],
        name: 'delete',

        data() {
            return {
                error: false
            }
        },
        methods: {
            cancelDelete(){
                this.$events.fire('delete-hide')
            },
            deleteItem(){
                this.error = false;
                this.$http.delete(this.delete_url).then(response => {
                    this.$events.fire('delete-finished')
                }, response => {
                    this.error = true;
                });

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