<script>

    var app = new Vue({
        el: '#sidebar-menu',
        http: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        ready: function () {

            var sections = ["dispatch", "restock", "products", "suppliers", "department", "users", "staff", "printers", "purchaseorder", "warehouse", "request"];
            this.$http({url: '{{url('/api/countstatus/products')}}', method: 'GET'}).then(function (response) {
                this.products = response.data;
            }, function (response) {
                // error callback
            });

            this.$http({url: '{{url('/api/countstatus/dispatch')}}', method: 'GET'}).then(function (response) {
                this.dispatch = response.data;
            }, function (response) {
                // error callback
            });
            this.$http({url: '{{url('/api/countstatus/restock')}}', method: 'GET'}).then(function (response) {
                this.restock = response.data;
            }, function (response) {
                // error callback
            });
            this.$http({url: '{{url('/api/countstatus/suppliers')}}', method: 'GET'}).then(function (response) {
                this.suppliers = response.data;
            }, function (response) {
                // error callback
            });
            this.$http({url: '{{url('/api/countstatus/department')}}', method: 'GET'}).then(function (response) {
                this.department = response.data;
            }, function (response) {
                // error callback
            });
            this.$http({url: '{{url('/api/countstatus/users')}}', method: 'GET'}).then(function (response) {
                this.users = response.data;
            }, function (response) {
                // error callback
            });
            this.$http({url: '{{url('/api/countstatus/staff')}}', method: 'GET'}).then(function (response) {
                this.staff = response.data;
            }, function (response) {
                // error callback
            });
            this.$http({url: '{{url('/api/countstatus/printers')}}', method: 'GET'}).then(function (response) {
                this.printers = response.data;
            }, function (response) {
                // error callback
            });
            this.$http({url: '{{url('/api/countstatus/purchaseorder')}}', method: 'GET'}).then(function (response) {
                this.purchaseorder = response.data;
            }, function (response) {
                // error callback
            });
            this.$http({url: '{{url('/api/countstatus/warehouse')}}', method: 'GET'}).then(function (response) {
                this.warehouse = response.data;
            }, function (response) {
                // error callback
            });
            this.$http({url: '{{url('/api/countstatus/request')}}', method: 'GET'}).then(function (response) {
                this.request = response.data;
            }, function (response) {
                // error callback
            });

        },
        data: {
            message: 'Hello Vue.js!',
            xpath: "",
            dispatch: 0,
            restock: 0,
            products: 0,
            suppliers: 0,
            department: 0,
            users: 0,
            staff: 0,
            printers: 0,
            purchaseorder: 0,
            warehouse: 0,
            request: 0
        }
    })
</script>