<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">View Product Dispatches </h3>

        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table  table-condensed ">
            <table class="table no-margin">
                <thead>
                <tr>
                    <th>Dispatch Date</th>
                    <th>Amount</th>
                    <th>Staff</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($product->dispatches as $dispatch)
                    <tr class="">
                        <td>{{ucwords($dispatch->created_at)}}</td>
                        <td>{{ucwords($dispatch->amount)}}</td>
                        <td>{{ucwords($dispatch->staff->name)}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->

    <!-- /.box-footer -->
</div>


