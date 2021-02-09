<template>
    <div id="upload">
        <p>Upload Your Files</p>

        <dropzone id="myVueDropzone" v-bind:url="url" v-on:vdropzone-success="showSuccess">
            <!-- Optional parameters if any! -->
            <input type="hidden" name="csrfToken" v-bind:value="token">
            <input type="hidden" name="_token" v-bind:value="token">
            <input type="hidden" name="token" v-bind:value="token">
        </dropzone>
        <table class=" table table-paper table-bordered">
            <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Caption</th>
                <th>Is it Thumbnail</th>
                <th>Save</th>
                <th>Delete</th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="picture in thumbnails">
                <td>
                    <img v-bind:src="picture.url" class="thumbnail" style="width:200px; height:auto;">

                    <div class="text-center bg-red" v-if="picture.isThumbnail">Default Image</div>
                </td>
                <td>
                    <textarea style="width: 100%" cols="2" rows="2" v-model="picture.title"></textarea>
                    {{picture.title}}
                </td>
                <td>
                    <textarea style="width: 100%" cols="2" rows="2" v-model="picture.caption"></textarea>
                    {{picture.caption}}
                </td>
                <td>
                    <input v-model="picked" type="radio" name="defaultPicture" v-bind:id="picture.id"
                           v-bind:value="picture.id">
                </td>
                <td>
                    <div class="btn btn-flat bg-green btn-block" v-on:click="saveItem(picture)">Save
                    </div>
                </td>
                <td>
                    <div class="text-center" v-if="picture.isThumbnail">
                        <div class="text-center">Cannot Delete a default Image</div>
                    </div>
                    <div v-else>
                        <div class="btn btn-flat bg-red btn-block" v-on:click="deleteItem(picture)">Delete
                        </div>
                    </div>

                </td>
            </tr>

            </tbody>
        </table>

    </div>
</template>

<script>
    import Dropzone from 'vue2-dropzone'

    export default {
        props: ['url', 'token', 'image_url', 'id'],
        name: 'MainApp',
        components: {
            Dropzone
        }, data: function () {
            return {
                'thumbnails': [],
                picked: 0
            }
        },
        mounted: function () {
            this.refreshImages();
        },
        methods: {
            'showSuccess': function (file, response) {
                console.log(response)
                this.refreshImages();
            },
            saveItem: function (item) {
                $.notify(
                    "Saving Changes Please be patient ...",
                    {
                        className: 'info',
                        autoHideDelay: 5000,
                    }
                );
                var uploadData = {
                    caption: item.caption,
                    title: item.title,
                    isThumbnail: this.picked,
                    itemId: item.id
                }
                this.$http.put(this.image_url + '/' + this.id, uploadData).then(function (response) {
                    $.notify(
                        "Changes Saved",
                        {
                            className: 'success',
                            autoHideDelay: 5000,
                        }
                    );

                }, function (response) {
                    $.notify(
                        "Error Occured while saving",
                        {
                            className: 'error',
                            autoHideDelay: 5000,
                        }
                    );
                    // error callback
                });
                this.refreshImages();
            },
            deleteItem: function (item) {
                $.notify(
                    "Deleting Photo Please be patient ...",
                    {
                        className: 'info',
                        autoHideDelay: 5000,
                    }
                );
                var x = this;
                this.$http.delete(this.image_url + '/' + item.photoHash).then(function (response) {
                    x.refreshImages();
                    $.notify(
                        "Photo Deleted",
                        {
                            className: 'success',
                            autoHideDelay: 5000,
                        }
                    );
                }, function (response) {
                    $.notify(
                        "Error Occured while deleting",
                        {
                            className: 'error',
                            autoHideDelay: 5000,
                        }
                    );
                    // error callback
                });


            },
            refreshImages: function () {
                var x = this;
                this.$http.get(this.image_url + '/' + this.id).then(function (response) {
                    console.log(response.data);
                    x.thumbnails = response.data;
                    //this.$set('thumbnails', response.data);

                }, function (response) {
                    // handle error
                });

            }
        }
    }
</script>