<template id="grid">



</template>

<script>
    @push('scripts')
            Vue.config.debug = true;
    Vue.filter('bool', function (value) {
        if (value == 1) {
            return "Yes";
        } else {
            return "NO";
        }
    });

    function formatRepo(repo) {

        return '<b>' + repo.whsName + '</b>' + '<br/><b>Bin Location :</b> <i>' + repo.binCode;
    }

    function formatRepoSelection(repo) {
        return repo.binCode || repo.text;
    }


    Vue.directive('product', {
        twoWay: true,
        bind: function () {
            $(this.el).select2({
                        width: '100%',
                        placeholder: "Select an option",
                        data: {!! $locs !!},
                        escapeMarkup: function (markup) {
                            return markup;
                        }, // let our custom formatter work
                        templateResult: formatRepo, // omitted for brevity, see the source of this page
                        templateSelection: formatRepoSelection, // omitted for brevity, see the source of this page
                    })
                    .on("select2:select", function (e) {
                        this.set($(this.el).val());
                        // $(this.el).select2("val", "");
                    }.bind(this)).on("change", function (e) {
                this.set($(this.el).val());
                //  $(this.el).select2("val", "");
            }.bind(this));
        },
        update: function (nv, ov) {
            $(this.el).trigger("change");
        }
    });

    Vue.directive('locations', {
        deep: true,
        update: function (items) {

            if (items.warehouseId == "") {
                return;
            }

            Vue.http.get('{{url('/api/v1/locations/')}}' + '/' + items.warehouseId).then(function (response) {
                // app.options = response;
                // items.binlocation = "";
                app.$set('options', response.data);
                console.log(response.data);
                app.$validatorReset();


            }, function (response) {

                // error callback
            });

        }
    });

    Vue.component('grid', {
        template: '#grid',
        http: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        ready: function () {
                    @if(old('orders'))
            var oldData = {!!  json_encode(old('orders')) !!};
            if (oldData.length > 0) {
                this.items = oldData;
            }
                    @elseif(isset($purchaseorder))
            var oldData = {!!  json_encode($orders) !!};
            if (oldData.length > 0) {
                console.log(oldData);
                this.items = oldData;
            }
            @else
            //this.newEmptyRow();
            @endif
        },


        data: function () {
            return {

                items: []
            }
        },
        methods: {
            /**
             * Used to toggle an item for Editing
             * @param item
             */
            editItem: function (item) {
                if (this.$v1.valid == false) {
                    //   return;
                }

                console.log(this.items);
                var index = this.items.indexOf(item);
                var object = this.items[index];
                console.log(object);
                //Remove Edit Class from everything Else
                this.toggleEdit(item);
                object.editing = true;
                object.saved = false;
            },
            /**
             * Removes Edit Class from all Items except from one being edited
             * Note May be redudant
             * @param item
             */
            toggleEdit: function (item) {
                if (this.$v1.valid == false) {
                    // return;
                }
                var index = this.items.indexOf(item);
                var arrayLength = this.items.length;
                for (var i = 0; i < arrayLength; i++) {
                    if (i != index) {
                        this.items[i].editing = false;
                        this.items[i].saved = true;
                    }
                    if (this.items[i].saved == false) {
                        // this.items.$remove(this.items[i]);
                    }
                }
            },
            /**
             * Removes Item from grid
             * @param item
             */
            deleteItem: function (item) {
                this.items.$remove(item);
            }
            ,
            /**
             * Removes all active edits and creates a new empty row
             */
            removeActiveEdits: function () {
                if (this.$v1.valid == false) {
                    return;
                }
                var arrayLength = this.items.length;
                for (var i = 0; i < arrayLength; i++) {
                    this.items[i].editing = false;
                    this.items[i].saved = true;

                }
                //this.newEmptyRow();
            },
        },
        filters: {
            splitlocation: function (val) {
                if (val != null) {
                    if (val.length > 0) {
                        return val.split(":")[1];
                    } else {
                        return ""
                    }
                }


            }
        }
    });
    @endpush
</script>