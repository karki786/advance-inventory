<template>
    <div id="upload">
        <p>Upload Your Files</p>

        <dropzone id="myVueDropzone" v-bind:url="url" v-on:vdropzone-success="showSuccess">
            <!-- Optional parameters if any! -->
            <input type="hidden" name="csrfToken" v-bind:value="token">
            <input type="hidden" name="_token" v-bind:value="token">
            <input type="hidden" name="token" v-bind:value="token">
        </dropzone>

    </div>
</template>

<script>
    import Dropzone from 'vue2-dropzone'

    export default {
        props: ['url', 'token', 'image_url'],
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