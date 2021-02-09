<template id="upload-grid">
    <div class="alert alert-error text-center" v-if="uploaderror.length > 0"
         style="margin: 0 auto;">@{{ uploaderror }}</div>
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="form-group{!! $errors->has('image') ? ' has-error' : '' !!}">
                <div class="text-center"> {!! Form::label('image', trans('createproduct.Upload Image Of Product')) !!}</div>
                <div class="input-group col-md-12">
                    <div class="dropzone col-md-12" id="image"></div>
                </div>
                {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>

    <table class=" table table-paper table-bordered">
        <thead>
        <tr>
            <th>{!! trans('createproduct.Image') !!}</th>
            <th>{!!trans('createproduct.Image Title')!!}</th>
            <th>{!!trans('createproduct.Image Caption')!!}</th>
            <th>{!!trans('createproduct.Use Image for Frontend Thumbnail?')!!}</th>
            <th>{!! trans('createproduct.Save Changes') !!}</th>
            <th>{!! trans('createproduct.Delete Image') !!}</th>

        </tr>
        </thead>
        <tbody>
        <tr v-for="picture in thumbnails">
            <td>
                <img v-bind:src="picture.filename.path" class="thumbnail" style="width:200px; height:auto;">

                <div class="text-center bg-red" v-if="picture.isThumbnail">Default Image</div>
            </td>
            <td>
                <textarea style="width: 100%" cols="2" rows="2" v-model="picture.title"></textarea>
                @{{picture.title}}
            </td>
            <td>
                <textarea style="width: 100%" cols="2" rows="2" v-model="picture.caption"></textarea>
                @{{picture.caption}}
            </td>
            <td>
                <input type="radio" name="defaultPicture" id="@{{ picture.id }}" value="@{{ picture.id }}"
                       v-model="picked">
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
</template>

<script>
    @push('scripts')


    @endpush
</script>